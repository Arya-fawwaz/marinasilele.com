<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial; // <-- WAJIB: Panggil model Testimonial
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil produk unggulan (3 produk terbaru) — cached 5 minutes
        $featuredProducts = cache()->remember('home_featured_products', 300, function() {
            return Product::with('category:id,name')
                ->select('id', 'name', 'slug', 'price', 'image', 'category_id', 'stock')
                ->latest()
                ->take(3)
                ->get();
        });
        
        // 2. Ambil data testimoni untuk animasi berjalan (ambil 10 terbaru) — cached 5 minutes
        $testimonials = cache()->remember('home_testimonials', 300, function() {
            return Testimonial::with('user:id,name,avatar')
                ->select('id', 'user_id', 'rating', 'comment', 'created_at')
                ->latest()
                ->take(10)
                ->get();
        });

        // 3. Kirim kedua data tersebut ke halaman home
        return view('home', compact('featuredProducts', 'testimonials'));
    }
}