@extends('layouts.app')

@section('title', $product->name . ' - Marinasi Lele')

@section('content')
<div class="container py-5 animate-fade-in">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none text-muted fw-semibold hover-text-accent transition-all">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
        </a>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">
                @php
                    $productImage = $product->image_url;
                @endphp
                <img src="{{ $productImage }}" alt="{{ $product->name }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 500px; object-fit: cover; width: 100%;">
            </div>

            <div class="col-md-6 p-4 p-lg-5 d-flex flex-column justify-content-center">
                
                {{-- Status Stok --}}
                @if($product->stock > 10)
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold mb-3 align-self-start" style="letter-spacing: 0.5px;"><i class="fas fa-check-circle me-1"></i> Tersedia</span>
                @elseif($product->stock > 0)
                    <span class="badge bg-warning-subtle text-warning-dark px-3 py-2 rounded-pill fw-bold mb-3 align-self-start" style="letter-spacing: 0.5px;"><i class="fas fa-exclamation-circle me-1"></i> Stok Tipis (Sisa {{ $product->stock }})</span>
                @else
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold mb-3 align-self-start" style="letter-spacing: 0.5px;"><i class="fas fa-times-circle me-1"></i> Habis Terjual</span>
                @endif

                {{-- Judul & Harga --}}
                <h1 class="fw-black text-dark mb-2 display-6">{{ $product->name }}</h1>
                <h2 class="fw-bold text-accent mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-dark text-uppercase small" style="letter-spacing: 1px;">Deskripsi Produk</h6>
                    <p class="text-muted lh-lg mb-0" style="text-align: justify;">{{ $product->description }}</p>
                </div>

                {{-- Garansi Keunggulan --}}
                <div class="d-flex align-items-center mb-4 text-muted small fw-medium">
                    <i class="fas fa-shield-alt text-success me-2 fs-5"></i> 
                    Dijamin higienis, praktis, dan kaya akan bumbu rempah Nusantara pilihan.
                </div>

                {{-- Form Tambah ke Keranjang --}}
                <div class="mt-auto pt-4 border-top border-light">
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex gap-3 align-items-center flex-wrap">
                                @csrf
                                <div class="input-group input-group-qty" style="width: 140px;">
                                    <span class="input-group-text bg-light border-0 fw-bold text-muted">Qty</span>
                                    <input type="number" name="quantity" class="form-control bg-light border-0 text-center fw-bold text-dark" value="1" min="1" max="{{ $product->stock }}">
                                </div>
                                <button type="submit" class="btn btn-brand rounded-pill px-4 py-3 fw-bold shadow-sm flex-grow-1">
                                    <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button class="btn btn-light text-muted fw-bold w-100 rounded-pill py-3 border" disabled>Maaf, Sedang Kosong</button>
                        @endif
                    @else
                        {{-- Tampilan Jika Belum Login --}}
                        <div class="alert bg-light border-0 shadow-sm rounded-4 text-center p-3 mb-0">
                            <p class="mb-2 text-muted small">Silakan login terlebih dahulu untuk mulai berbelanja.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill px-4 btn-sm fw-bold">Login Sekarang</a>
                        </div>
                    @endauth
                </div>
                
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --accent-color: #A81C1C; 
        --accent-hover: #8B1515;
    }
    .text-accent { color: var(--accent-color) !important; }
    .fw-black { font-weight: 900; }
    
    /* Warna Badge */
    .bg-success-subtle { background-color: #d1e7dd !important; color: #0f5132 !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; color: #664d03 !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; color: #842029 !important; }

    /* Tombol Interaktif */
    .btn-brand { 
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)); 
        color: white; 
        border: none; 
        transition: all 0.3s; 
    }
    .btn-brand:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 8px 20px rgba(168, 28, 28, 0.3); 
        color: #FFB800; 
    }
    
    .hover-text-accent:hover { color: var(--accent-color) !important; }
    .transition-all { transition: all 0.3s ease; }
    
    /* Animasi Masuk */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }

    /* Mobile optimization */
    @media (max-width: 575.98px) {
        .input-group-qty {
            width: 100% !important;
            margin-bottom: 0.5rem;
        }
        .display-6 {
            font-size: 1.8rem !important;
        }
    }
</style>
@endpush
@endsection