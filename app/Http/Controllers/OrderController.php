<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function markPaidCod($id)
    {
        // Panggil relasi items agar bisa kurangi stok
        $order = Order::with('items.product')->findOrFail($id);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek agar tidak terkurangi ganda
        if ($order->status !== 'processing' && $order->status !== 'completed') {
            // Jika sebelumnya statusnya cancelled (dikarenakan expired di Midtrans), stoknya telah dikembalikan ke database.
            // Maka saat beralih ke COD, kita harus kurangi stoknya lagi!
            if ($order->status == 'cancelled') {
                // Cek ketersediaan stok
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->stock < $item->quantity) {
                        return back()->with('error', 'Stok produk ' . $item->product->name . ' tidak mencukupi untuk menggunakan COD.');
                    }
                }
                
                // Kurangi stok kembali
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            }

            $order->update(['status' => 'processing']);
            
            // Hapus keranjang
            Cart::where('user_id', $order->user_id)->delete();
        }

        return back()->with('success', 'Terima kasih! Pesanan diproses dan Driver akan menagih pembayaran tunai (COD).');
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('orders.show', compact('order'));
    }
}