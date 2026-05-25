<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        // Ambil semua testimoni, urutkan dari yang terbaru
        $testimonials = Testimonial::with('user')->latest()->get();
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

        return back()->with('success', 'Terima kasih! Ulasan bintang ' . $request->rating . ' Anda berhasil dikirim.');
    }
}