@extends('layouts.app')

@section('title', 'Marinasi Lele - Lauk Praktis & Lezat')

@push('styles')
<style>
    /* Custom Modern E-Commerce Styles (Tema Merah, Kuning, & Batik Nusantara) */
    :root {
        --brand-primary: #A81C1C;    /* Merah Keraton */
        --brand-secondary: #FFB800;  /* Kuning Emas Sogan */
        --brand-dark: #1A1A1A;
        --radius-xl: 2rem;
        --radius-lg: 1.5rem;
        --radius-md: 1.25rem;
        --radius-sm: 0.75rem;
        --transition-bouncy: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        --transition-smooth: all 0.4s ease;
        
        /* Premium Subtle Batik Kawung Pattern */
        --batik-pattern: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M40 0 C40 22 22 40 0 40 C22 40 40 58 40 80 C40 58 58 40 80 40 C58 40 40 22 40 0 Z' fill='%23A81C1C' fill-opacity='0.02'/%3E%3Ccircle cx='40' cy='40' r='4' fill='%23FFB800' fill-opacity='0.05'/%3E%3C/svg%3E");
    }

    body {
        background-color: #FCF9F5;
        color: #333;
        overflow-x: hidden;
    }

    /* --- AMBIENT INTERACTIVE BACKGROUND --- */
    .ambient-bg-container {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        z-index: -1;
        overflow: hidden;
        pointer-events: none;
        background-image: var(--batik-pattern);
        background-attachment: fixed;
    }

    .ambient-glow {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.5;
        animation: floatGlow 15s infinite alternate ease-in-out;
    }

    .glow-1 {
        width: 45vw; height: 45vw;
        background: radial-gradient(circle, rgba(168, 28, 28, 0.12) 0%, transparent 70%);
        top: -5%; left: -10%;
    }

    .glow-2 {
        width: 55vw; height: 55vw;
        background: radial-gradient(circle, rgba(255, 184, 0, 0.1) 0%, transparent 70%);
        bottom: -15%; right: -10%;
        animation-delay: -7s;
    }

    @keyframes floatGlow {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(60px, 60px) scale(1.15); }
    }

    .main-container {
        padding-top: 2.5rem;
        padding-bottom: 5rem;
        position: relative;
        z-index: 1;
    }

    /* --- ANIMASI MASUK --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-up {
        opacity: 0;
        animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    /* --- CINEMATIC ULTRAWIDE VIDEO BANNER --- */
    .hero-banner-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 6rem;
        padding: 0 1rem;
        perspective: 2000px;
    }

    .hero-banner {
        border-radius: var(--radius-xl);
        padding: 8px; 
        background: linear-gradient(135deg, rgba(255,255,255,0.7), rgba(255,255,255,0.1));
        box-shadow: 0 30px 60px rgba(168, 28, 28, 0.15), inset 0 0 0 1px rgba(255,255,255,0.8);
        backdrop-filter: blur(20px);
        transition: var(--transition-bouncy);
        position: relative;
        width: 100%;
        max-width: 1200px; 
        transform-style: preserve-3d;
        will-change: transform;
        cursor: pointer;
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: -2px; left: -2px; right: -2px; bottom: -2px;
        background: linear-gradient(45deg, var(--brand-primary), var(--brand-secondary), var(--brand-primary));
        z-index: -1;
        border-radius: calc(var(--radius-xl) + 2px);
        opacity: 0;
        transition: opacity 0.5s ease;
        filter: blur(20px);
    }

    .hero-banner:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 40px 80px rgba(168, 28, 28, 0.25), inset 0 0 0 1px rgba(255,255,255,1);
    }

    .hero-banner:hover::before {
        opacity: 0.6;
        animation: gradientGlow 3s linear infinite;
    }

    @keyframes gradientGlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .hero-banner video {
        width: 100%;
        aspect-ratio: 21 / 9; 
        object-fit: cover;
        display: block;
        border-radius: calc(var(--radius-xl) - 6px);
        box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
    }

    /* --- ANIMATED GRADIENT TEXT --- */
    .text-gradient {
        background: linear-gradient(to right, var(--brand-primary), var(--brand-secondary), #8B1515);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shine 4s linear infinite;
    }

    @keyframes shine {
        to { background-position: 200% center; }
    }

    /* --- 3D INTERACTIVE CARDS --- */
    .interactive-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: var(--radius-md);
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: var(--transition-bouncy);
        transform-style: preserve-3d;
        will-change: transform;
    }

    .interactive-card:hover {
        box-shadow: 0 30px 60px rgba(168, 28, 28, 0.12), 0 0 0 2px var(--brand-secondary) inset;
        background: rgba(255, 255, 255, 0.95);
        z-index: 10;
    }

    /* Feature Cards */
    .feature-card {
        padding: 3rem 1.5rem;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .feature-icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(168, 28, 28, 0.05), rgba(255, 184, 0, 0.1));
        border-radius: 25px; 
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem auto;
        color: var(--brand-primary);
        transition: var(--transition-bouncy);
        border: 1px solid rgba(255, 184, 0, 0.3);
        transform: translateZ(40px);
    }

    .feature-card:hover .feature-icon-wrapper {
        background: linear-gradient(135deg, var(--brand-primary), #8B1515);
        color: #fff;
        transform: translateZ(60px) scale(1.15) rotate(8deg);
        border-color: transparent;
        box-shadow: 0 20px 30px rgba(168, 28, 28, 0.4);
    }

    .feature-card h4 { transform: translateZ(30px); font-size: 1.25rem; transition: var(--transition-smooth); }
    .feature-card:hover h4 { color: var(--brand-primary) !important; }
    .feature-card p { transform: translateZ(15px); }

    /* Product Cards */
    .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        padding-top: 75%;
        border-radius: var(--radius-md) var(--radius-md) 0 0;
        transform: translateZ(25px);
    }

    .product-img-wrapper img {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .product-card:hover .product-img-wrapper img {
        transform: scale(1.15);
    }

    .price-tag {
        background: linear-gradient(135deg, var(--brand-primary), #8B1515);
        color: #fff;
        padding: 0.5rem 1.2rem;
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        position: absolute;
        top: 1.5rem; right: 0;
        font-weight: 800;
        z-index: 2;
        box-shadow: -8px 8px 20px rgba(168, 28, 28, 0.3);
        border-left: 3px solid var(--brand-secondary);
        font-size: 0.95rem;
        transform: translateX(10px);
        transition: var(--transition-bouncy);
    }

    .product-card:hover .price-tag {
        transform: translateX(0);
    }

    /* Buttons */
    .btn-brand {
        background: linear-gradient(135deg, var(--brand-primary), #8B1515);
        color: white;
        border: none;
        transition: var(--transition-bouncy);
        font-weight: 800;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .btn-brand::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 100%; height: 100%;
        background: linear-gradient(135deg, #FFB800, #F37021);
        z-index: -1;
        transform: translateY(100%);
        transition: var(--transition-bouncy);
    }

    .btn-brand:hover::after {
        transform: translateY(0);
    }

    .btn-brand:hover {
        color: #1A1A1A;
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 15px 25px rgba(255, 184, 0, 0.4);
    }

    /* Aksen Judul Kebudayaan */
    .title-heritage-badge {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.4));
        backdrop-filter: blur(10px);
        color: var(--brand-primary);
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 4px;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid rgba(255, 184, 0, 0.4);
        box-shadow: 0 8px 15px rgba(168, 28, 28, 0.08);
    }

    /* --- ANIMASI SCROLLING TESTIMONI --- */
    .marquee-wrapper {
        overflow: hidden;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        padding: 2rem 0;
        background: linear-gradient(to right, rgba(252, 249, 245, 1) 0%, rgba(252, 249, 245, 0) 10%, rgba(252, 249, 245, 0) 90%, rgba(252, 249, 245, 1) 100%);
    }

    .marquee-track {
        display: flex;
        width: max-content;
        animation: scrollMarquee 25s linear infinite; 
        gap: 2.5rem;
        padding: 0 1rem;
    }

    @keyframes scrollMarquee {
        0% { transform: translateX(100vw); }
        100% { transform: translateX(-100%); }
    }

    .marquee-track:hover {
        animation-play-state: paused;
    }

    .testimonial-card-animated {
        width: 380px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(15px);
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.04);
        border: 1px solid rgba(255, 255, 255, 0.9);
        display: flex;
        flex-direction: column;
        position: relative;
        transition: var(--transition-bouncy);
    }
    
    .testimonial-card-animated:hover {
        transform: scale(1.05) translateY(-10px);
        z-index: 10;
        box-shadow: 0 25px 50px rgba(168, 28, 28, 0.15);
        background: #ffffff;
    }

    .quote-icon-bg {
        position: absolute;
        top: 1rem; right: 1.5rem;
        font-size: 3.5rem;
        color: rgba(168, 28, 28, 0.05);
        transition: var(--transition-bouncy);
    }

    .testimonial-card-animated:hover .quote-icon-bg {
        color: rgba(255, 184, 0, 0.2);
        transform: rotate(15deg) scale(1.2);
    }

    /* --- AKORDEON INFORMASI (CANGGIH) --- */
    .info-section {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border-radius: var(--radius-xl);
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        padding: 4rem;
        border: 1px solid rgba(255,255,255,1);
    }

    .accordion-item {
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: var(--radius-md) !important;
        margin-bottom: 1rem;
        overflow: hidden;
        background: #ffffff;
        transition: var(--transition-smooth);
    }

    .accordion-item:hover {
        box-shadow: 0 10px 25px rgba(168, 28, 28, 0.08);
        border-color: rgba(255, 184, 0, 0.3);
    }

    .accordion-button {
        font-size: 1.05rem;
        color: #444;
        transition: var(--transition-smooth);
    }

    .accordion-button:not(.collapsed) {
        color: var(--brand-primary);
        background-color: transparent;
        box-shadow: inset 0 -1px 0 rgba(0,0,0,.05);
        font-weight: 800;
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23A81C1C'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .accordion-button:focus {
        border-color: transparent;
        box-shadow: none;
    }
    }

    /* --- MOBILE RESPONSIVE OPTIMIZATIONS --- */
    @media (max-width: 767.98px) {
        .hero-banner-wrapper {
            margin-bottom: 2.5rem;
            padding: 0 0.5rem;
        }
        .hero-banner {
            border-radius: var(--radius-md);
            padding: 4px;
        }
        .hero-banner video {
            aspect-ratio: 16 / 9;
            border-radius: calc(var(--radius-md) - 2px);
        }
        .info-section {
            padding: 1.5rem !important;
            border-radius: var(--radius-lg) !important;
        }
        .info-section h3 {
            font-size: 1.6rem !important;
        }
        .accordion-button {
            padding: 1.25rem 1rem !important;
            font-size: 0.95rem;
        }
        .testimonial-card-animated {
            width: 300px;
            padding: 1.5rem;
        }
        .quote-icon-bg {
            font-size: 2.5rem;
        }
        .marquee-wrapper {
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            left: 0;
            right: 0;
            padding: 1rem 0;
        }
        h2.fw-black {
            font-size: 1.8rem !important;
        }
    }
</style>
@endpush

@section('content')

<div class="ambient-bg-container">
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>
</div>

<div class="container main-container">
    
    {{-- ==================== CINEMATIC ULTRAWIDE BANNER ==================== --}}
    <div class="hero-banner-wrapper animate-fade-up" style="animation-delay: 0.1s;">
        <div class="hero-banner" data-tilt data-tilt-max="3" data-tilt-speed="400" data-tilt-perspective="1500">
            <a href="{{ route('products.index') }}">
                @php
                    $bannerPath = public_path('images/banner-lauk.mp4');
                    $bannerUrl = file_exists($bannerPath) ? asset('images/banner-lauk.mp4') : 'http://googleusercontent.com/generated_video_content/6740527814937026519';
                @endphp
                <video autoplay loop muted playsinline>
                    <source src="{{ $bannerUrl }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video HTML5.
                </video>
            </a>
        </div>
    </div>

    {{-- Grid Tiga Fitur Utama Unggulan --}}
    <div class="row text-center mb-5 g-4">
        <div class="col-md-4">
            <div class="feature-card interactive-card animate-fade-up" style="animation-delay: 0.2s;" data-tilt data-tilt-max="10">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-utensils fs-3"></i>
                </div>
                <h4 class="fw-bolder mb-3 text-dark">Rempah Bintang Lima</h4>
                <p class="text-muted small mb-0 lh-lg">Racikan kunyit, ketumbar, dan serai alami meresap sempurna hingga ke dalam serat daging, menghasilkan cita rasa Nusantara autentik.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card interactive-card animate-fade-up" style="animation-delay: 0.3s;" data-tilt data-tilt-max="10">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-box-open fs-3"></i>
                </div>
                <h4 class="fw-bolder mb-3 text-dark">Kemasan Vakum Steril</h4>
                <p class="text-muted small mb-0 lh-lg">Dikemas kedap udara dengan teknologi vakum tinggi, mengunci kelembapan rempah marinasi agar higienis tanpa pengawet.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card interactive-card animate-fade-up" style="animation-delay: 0.4s;" data-tilt data-tilt-max="10">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-qrcode fs-3"></i>
                </div>
                <h4 class="fw-bolder mb-3 text-dark">Transaksi Otomatis</h4>
                <p class="text-muted small mb-0 lh-lg">Kemudahan transaksi instan dan modern menggunakan interkoneksi QRIS serta kode Virtual Account bank secara aman.</p>
            </div>
        </div>
    </div>

    {{-- Section Produk Unggulan --}}
    <div class="d-flex justify-content-between align-items-end mb-5 pt-4 animate-fade-up" style="animation-delay: 0.1s;">
        <div>
            <span class="title-heritage-badge mb-3">PILIHAN TERPOPULER</span>
            <h2 class="fw-black text-dark mb-0" style="font-weight: 900; font-size: 2.5rem;">
                Menu <span class="text-gradient">Unggulan</span>
            </h2>
        </div>
        <a href="{{ route('products.index') }}" class="text-decoration-none fw-bolder hover-text-accent transition-all d-none d-md-block" style="color: var(--brand-primary); font-size: 1.1rem;">
            Lihat Katalog Lengkap <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>

    <div class="row g-4 mb-5 pb-5">
        @forelse($featuredProducts as $product)
            <div class="col-md-4 col-sm-6">
                <div class="product-card interactive-card animate-fade-up" style="animation-delay: {{ 0.2 + ($loop->index * 0.1) }}s;" data-tilt data-tilt-max="5">
                    <div class="product-img-wrapper">
                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 z-index-1 rounded-pill fw-bold shadow-lg py-2 px-3">🔥 Terlaris</span>
                        <div class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body d-flex flex-column p-4" style="transform: translateZ(30px);">
                        <h5 class="card-title fw-bolder text-dark mb-2 fs-4">{{ $product->name }}</h5>
                        <p class="card-text text-muted small mb-4 flex-grow-1 lh-lg">{{ Str::limit($product->description, 85) }}</p>
                        <div class="mt-auto d-grid">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-brand rounded-pill py-3 shadow-sm text-uppercase small">
                                Pesan Sekarang <i class="fas fa-shopping-cart ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 animate-fade-up" style="animation-delay: 0.2s;">
                <div class="text-muted bg-white rounded-4 p-5 shadow-sm border border-light">
                    <i class="fas fa-box-open fa-3x mb-3 text-secondary opacity-30"></i>
                    <p class="fs-6 fw-semibold text-secondary">Belum ada produk unggulan yang dirilis.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Tombol Katalog Khusus Mobile --}}
    <div class="text-center d-md-none mb-5 animate-fade-up" style="animation-delay: 0.5s;">
        <a href="{{ route('products.index') }}" class="btn btn-brand rounded-pill px-5 py-3 fw-bold shadow-sm" style="border-width: 2px;">
            Lihat Katalog Lengkap <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>

    {{-- Section Testimoni Animasi Berjalan (Marquee) --}}
    @if(isset($testimonials) && $testimonials->count() > 0)
        <div class="text-center mb-5 pt-4 animate-fade-up" style="animation-delay: 0.1s;">
            <span class="title-heritage-badge mb-3">BUKTI RASA</span>
            <h2 class="fw-black text-dark" style="font-weight: 900; font-size: 2.5rem;">
                Apa Kata <span class="text-gradient">Pelanggan?</span>
            </h2>
        </div>
        
        <div class="marquee-wrapper pb-4 animate-fade-up" style="animation-delay: 0.3s;">
            <div class="marquee-track">
                @foreach($testimonials as $testi)
                    <div class="testimonial-card-animated">
                        <i class="fas fa-quote-right quote-icon-bg"></i>
                        <div class="rating-stars mb-4">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star {{ $i <= $testi->rating ? 'text-warning' : 'text-muted opacity-25' }} fs-5"></i>
                            @endfor
                        </div>
                        <p class="fst-italic text-secondary mb-4 flex-grow-1 lh-lg" style="font-size: 0.95rem;">"{{ Str::limit($testi->comment, 120) }}"</p>
                        
                        <div class="d-flex align-items-center mt-auto">
                            <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center fw-bolder shadow-sm overflow-hidden flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.2rem; color: var(--brand-primary); border: 2px solid #fff;">
                                @if(optional($testi->user)->avatar)
                                    <img src="{{ asset($testi->user->avatar) }}" alt="Foto Pelanggan" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    {{ strtoupper(substr(optional($testi->user)->name ?? 'A', 0, 1)) }}
                                @endif
                            </div>
                            <div class="ms-3 text-start">
                                <h6 class="mb-0 fw-black text-dark" style="font-size: 1rem;">{{ optional($testi->user)->name ?? 'Pengguna Anonim' }}</h6>
                                <small class="text-muted fw-bold" style="font-size: 0.75rem; color: var(--brand-secondary) !important;">Verified Buyer <i class="fas fa-certificate text-success ms-1"></i></small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="text-center pb-5 mb-5">
            <a href="{{ route('testimonials.index') }}" class="btn btn-outline-danger rounded-pill px-5 py-3 fw-bold shadow-sm" style="border-width: 2px;">
                Lihat Semua Ulasan <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    @endif

    {{-- ==================== SECTION INFORMASI TAMBAHAN (FAQ CANGGIH) ==================== --}}
    <div class="row justify-content-center animate-fade-up" style="animation-delay: 0.2s;">
        <div class="col-lg-10">
            <div class="info-section">
                <div class="text-center mb-5">
                    <span class="title-heritage-badge mb-3">INFORMASI PENTING</span>
                    <h3 class="fw-black text-dark mb-3" style="font-size: 2.2rem;">Mengapa <span class="text-gradient">Memilih Kami?</span></h3>
                    <p class="text-muted mx-auto" style="max-width: 600px; font-size: 1.05rem;">Pertanyaan yang sering diajukan pelanggan mengenai standar kualitas dan pelayanan lauk marinasi premium kami.</p>
                </div>

                <div class="accordion" id="accordionInfo">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-leaf text-success"></i>
                                    </div>
                                    Apakah produk ini menggunakan bahan pengawet?
                                </div>
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionInfo">
                            <div class="accordion-body text-secondary px-4 py-4 lh-lg" style="background-color: #FAFAFA;">
                                <strong>Sama sekali tidak.</strong> Kami berkomitmen pada kesehatan Anda dengan mengandalkan teknologi <em>Vacuum Sealing</em> (kemasan kedap udara) dipadukan dengan suhu penyimpanan Freezer yang tepat. Hal ini menjaga ketahanan produk hingga berminggu-minggu secara alami tanpa merusak tekstur, nutrisi, dan cita rasa asli ikan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-shipping-fast text-primary"></i>
                                    </div>
                                    Bagaimana prosedur pengirimannya?
                                </div>
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionInfo">
                            <div class="accordion-body text-secondary px-4 py-4 lh-lg" style="background-color: #FAFAFA;">
                                Untuk menjamin kesegaran ikan saat tiba di tangan Anda, pesanan <em>Frozen Food</em> ini didistribusikan secara eksklusif menggunakan kurir <strong>Instan atau Same-Day</strong>. Anda juga memiliki opsi fleksibel untuk mengambil pesanan secara langsung di gerai kami (Self-Pickup).
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-4 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-fire-burner text-danger"></i>
                                    </div>
                                    Bagaimana cara penyajian yang direkomendasikan?
                                </div>
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionInfo">
                            <div class="accordion-body text-secondary px-4 py-4 lh-lg" style="background-color: #FAFAFA;">
                                <strong>Sangat praktis!</strong> Keluarkan kemasan dari freezer dan biarkan pada suhu ruang (thawing) hingga daging ikan tidak lagi kaku. Panaskan minyak dalam wajan, lalu goreng ikan hingga mencapai tingkat kematangan kuning keemasan (Golden Brown). Lauk kaya rempah siap dihidangkan bersama nasi hangat.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Hanya aktifkan tilt di desktop untuk mencegah lag dan layout jumps di layar sentuh handphone
        if (window.innerWidth > 768) {
            // Menggunakan library VanillaTilt untuk hasil 3D yang sangat mulus tanpa glitch
            VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
                max: 5,               // Derajat rotasi
                speed: 400,           // Kecepatan transisi
                glare: true,          // Efek pantulan cahaya kaca
                "max-glare": 0.2,     // Intensitas pantulan cahaya
                scale: 1.02           // Efek zoom saat disorot
            });
            
            // Tilt khusus untuk Hero Banner agar lebih berbobot
            const heroBanner = document.querySelector(".hero-banner");
            if (heroBanner) {
                VanillaTilt.init(heroBanner, {
                    max: 2,
                    speed: 1000,
                    glare: true,
                    "max-glare": 0.1,
                    scale: 1.01
                });
            }
        }
    });
</script>
@endpush