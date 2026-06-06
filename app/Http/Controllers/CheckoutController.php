<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem; // WAJIB DIPANGGIL
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();
        $totalPrice = $carts->sum(function($cart) { return ($cart->product->price ?? 0) * $cart->quantity; });
        return view('checkout.index', compact('carts', 'totalPrice'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'shipping_fee' => 'nullable|integer',
            'distance' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
        
        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        // Validasi ketersediaan stok sebelum memproses pesanan
        foreach ($carts as $cart) {
            if ($cart->product && $cart->product->stock < $cart->quantity) {
                return redirect()->back()->with('error', 'Stok produk ' . $cart->product->name . ' tidak mencukupi.');
            }
        }

        $totalPrice = $carts->sum(function($cart) { return ($cart->product->price ?? 0) * $cart->quantity; });
        $shippingFee = intval($request->input('shipping_fee', 0));
        $totalAmount = $totalPrice + $shippingFee;

        $orderNumber = 'ORD-' . time() . '-' . rand(100, 999);
        $order = Order::create([
            'user_id'          => $user->id,
            'order_number'     => $orderNumber,
            'shipping_address' => $request->address, 
            'total_price'      => $totalPrice,       
            'total_amount'     => $totalAmount,       
            'shipping_fee'     => $shippingFee,
            'distance'         => $request->input('distance'),
            'latitude'         => $request->input('latitude'),
            'longitude'        => $request->input('longitude'),
            'status'           => 'pending',
        ]);

        // Pindahkan isi keranjang ke tabel order_items & kurangi stok
        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $cart->product_id,
                'quantity'   => $cart->quantity,
                'price'      => $cart->product->price ?? 0,
            ]);

            if ($cart->product) {
                $cart->product->decrement('stock', $cart->quantity);
            }
        }

        // Hapus keranjang belanja karena item sudah dipesan
        Cart::where('user_id', $user->id)->delete();

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number . '-' . time(), // Suffix unik agar Midtrans mengizinkan pembayaran ulang jika gagal
                'gross_amount' => $order->total_amount ?? $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
            ],
        ];
        $snapToken = Snap::getSnapToken($params);
        return view('checkout.pay', compact('snapToken', 'order'));
    }

    public function getSnapToken($order_number)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();
        if (strtolower($order->status) == 'success' || strtolower($order->status) == 'completed') {
            return response()->json(['paid' => true]);
        }
        
        // JIKA STATUSNYA CANCELLED (Gagal/Telat/Expired), kembalikan ke pending, cek & kurangi stok lagi sebelum bayar
        if (strtolower($order->status) == 'cancelled') {
            // Cek ketersediaan stok
            foreach ($order->items as $item) {
                if ($item->product && $item->product->stock < $item->quantity) {
                    return response()->json([
                        'paid' => false,
                        'error' => 'Stok produk ' . $item->product->name . ' tidak mencukupi untuk mencoba bayar lagi.'
                    ], 400);
                }
            }
            
            // Kurangi stok kembali
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }
            
            // Set status kembali ke pending
            $order->update(['status' => 'pending']);
        }
        
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $method = request('method');
        $enabledPayments = [];
        if ($method == 'qris') {
            $enabledPayments = ['gopay', 'qris', 'shopeepay'];
        } elseif ($method == 'bank_transfer') {
            $enabledPayments = ['bank_transfer', 'bca_va', 'echannel', 'bni_va', 'bri_va'];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number . '-' . time(), // Suffix baru untuk transaksi ulang
                'gross_amount' => $order->total_amount ?? $order->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ],
        ];

        if (!empty($enabledPayments)) {
            $params['enabled_payments'] = $enabledPayments;
        }

        return response()->json(['paid' => false, 'snap_token' => Snap::getSnapToken($params)]);
    }

    public function successLocal($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        
        if ($order) {
            if ($order->status !== 'completed') {
                $order->update(['status' => 'completed']); 
            }
            return redirect()->route('orders.index')->with('success', 'Pembayaran Berhasil Diverifikasi!');
        }
        
        return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan');
    }

    public function handleNotification(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        try { $notif = new Notification(); } catch (\Exception $e) { return response()->json(['message' => 'Invalid'], 400); }
        
        $orderId = $notif->order_id;
        // Bersihkan timestamp suffix jika ada
        $parts = explode('-', $orderId);
        if (count($parts) > 3) {
            array_pop($parts);
            $orderId = implode('-', $parts);
        }

        $order = Order::with('items.product')->where('order_number', $orderId)->first();
        if (!$order) return response()->json(['message' => 'Not found'], 404);

        if ($notif->transaction_status == 'settlement' || $notif->transaction_status == 'capture') {
            if ($order->status !== 'completed') {
                $order->update(['status' => 'completed']);
            }
        } elseif (in_array($notif->transaction_status, ['deny', 'expire', 'cancel'])) {
            // Kembalikan stok produk jika transaksi gagal / kadaluarsa
            if ($order->status !== 'cancelled') {
                $order->update(['status' => 'cancelled']);
                
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }
        }
        return response()->json(['message' => 'Success']);
    }
}