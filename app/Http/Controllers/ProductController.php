<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index(Request $request)
    {
        $categories = Category::select('id', 'name')->get();
        $query = Product::with('category:id,name')
            ->select('id', 'name', 'slug', 'price', 'image', 'category_id', 'stock', 'status');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // UBAH BAGIAN INI: Ganti ->get() menjadi ->paginate(12)
        // Angka 12 adalah jumlah produk yang tampil per halaman
        $products = $query->latest()->paginate(12); 

        // Untuk mempertahankan parameter pencarian/filter di URL saat pindah halaman
        $products->appends($request->all());

        return view('products.index', compact('products', 'categories'));
    }
    public function show($id)
    {
        $product = Product::with('category:id,name')->findOrFail($id);
        $testimonials = Testimonial::with('user:id,name,avatar')
            ->select('id', 'user_id', 'product_id', 'rating', 'comment', 'status', 'created_at')
            ->where('product_id', $id)
            ->where('status', 'approved')
            ->get();
        $averageRating = $testimonials->avg('rating');
        return view('products.show', compact('product', 'testimonials', 'averageRating'));
    }
}