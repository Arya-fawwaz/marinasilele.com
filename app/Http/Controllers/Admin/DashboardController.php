<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan Ringkasan Performa Toko di Dashboard Admin
     */
    public function index()
    {
        // 1. Menghitung Total Semua Pesanan Masuk
        $totalOrders = Order::count();

        // FIX REALTIME: Menghitung total pendapatan murni dari kolom 'status' yang bernilai success/completed
        $totalRevenue = Order::whereIn('status', ['success', 'completed'])
                             ->sum('total_amount');

        // 3. Menghitung Jumlah Katalog Produk Aktif
        $totalProducts = Product::count();

        // 4. Menghitung Jumlah Pengguna/Pelanggan Terdaftar (Opsional jika ingin digunakan)
        $totalUsers = User::count();

        // Kirim data ringkasan ke halaman view dashboard admin
        return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'totalProducts', 'totalUsers'));
    }

    /**
     * Set preview mode and redirect to homepage.
     */
    public function previewSite()
    {
        session(['admin_view_mode' => 'user']);
        \Illuminate\Support\Facades\Cookie::queue('admin_view_mode', 'user', 60);
        return redirect()->route('home');
    }
}