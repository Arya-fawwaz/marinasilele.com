<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        // Ambil semua testimoni, urutkan dari yang terbaru
        $testimonials = Testimonial::with('user:id,name,avatar')
            ->select('id', 'user_id', 'rating', 'comment', 'created_at')
            ->latest()
            ->paginate(10);
        return view('testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        Testimonial::create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Hapus cache halaman beranda agar testimoni baru langsung tampil
        cache()->forget('home_testimonials');

        return back()->with('success', 'Terima kasih! Ulasan bintang ' . $request->rating . ' Anda berhasil dikirim.');
    }
}