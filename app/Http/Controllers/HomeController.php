<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial; // <-- WAJIB: Panggil model Testimonial
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // 1. Ambil produk unggulan (3 produk terbaru/terlaris)
        $featuredProducts = Product::latest()->take(3)->get();
        
        // 2. Ambil data testimoni untuk animasi berjalan (ambil 10 terbaru agar tidak berat)
        $testimonials = Testimonial::with('user')->latest()->take(10)->get();

        // 3. Kirim kedua data tersebut ke halaman home
        return view('home', compact('featuredProducts', 'testimonials'));
    }
}