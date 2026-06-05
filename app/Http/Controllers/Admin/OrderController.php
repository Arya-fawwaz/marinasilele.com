<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user:id,name,email')
            ->select('id', 'user_id', 'order_number', 'total_price', 'total_amount', 'status', 'created_at')
            ->latest()
            ->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

       public function show($id)
    {
        // Ambil data pesanan beserta relasi item dan usernya
        $order = \App\Models\Order::with(['items.product', 'user'])->findOrFail($id);

        // PASTIKAN memanggil folder 'admin.orders.show', BUKAN 'orders.show'
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,failed',
        ]);

        $order->update($request->only(['status', 'payment_status']));

        // Jika payment_status menjadi paid, update payment status juga
        if ($order->payment_status == 'paid' && $order->payment) {
            $order->payment->update(['status' => 'paid']);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan diperbarui.');
    }

    // Method khusus untuk mengupdate status pembayaran (bisa juga di dalam update)
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid,failed',
        ]);

        $order->payment_status = $request->payment_status;
        $order->save();

        if ($order->payment) {
            $order->payment->update(['status' => $request->payment_status]);
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }



    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan dihapus.');
    }

    public function confirmCod($id)
{
    $order = \App\Models\Order::findOrFail($id);
    
    // Ubah status pembayaran jadi lunas dan order jadi selesai
    $order->update([
        'payment_status' => 'paid',
        'status' => 'completed' // Otomatis pesanan selesai karena uang sudah di tangan
    ]);

    return back()->with('success', 'Pembayaran COD/QRIS berhasil dikonfirmasi! Pesanan Selesai.');
}
}