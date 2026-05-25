@extends('layouts.app')

@section('title', 'Katalog Produk Marinasi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card category-card sticky-top animate-fade-in" style="top: 20px; z-index: 1010; animation-delay: 0.1s;">
                <div class="card-header bg-white border-0 py-3 d-flex align-items-center fw-bold text-primary-custom" style="border-radius: 20px 20px 0 0;">
                    <div class="icon-box me-2"><i class="fas fa-filter text-white"></i></div> 
                    Kategori
                </div>
                <div class="list-group list-group-flush rounded-bottom-20 pb-2">
                    @php $currentCat = request('category'); @endphp
                    
                    <a href="{{ route('products.index') }}" 
                       class="list-group-item list-group-item-action {{ is_null($currentCat) ? 'active' : '' }}">
                        <i class="fas fa-border-all me-2 category-icon"></i> Semua Produk
                    </a>
                    
                    @if(isset($categories) && $categories->count())
                        @foreach($categories as $cat)
                            <a href="?category={{ $cat->id }}" 
                               class="list-group-item list-group-item-action {{ $currentCat == $cat->id ? 'active' : '' }}">
                                <i class="fas fa-fish me-2 category-icon"></i> {{ $cat->name }}
                            </a>
                        @endforeach
                    @else
                        <div class="list-group-item text-muted">Belum ada kategori</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in" style="animation-delay: 0.2s;">
                <h1 class="h3 fw-bolder text-primary-custom mb-0 d-flex align-items-center">
                    <span class="title-accent me-2"></span> Katalog Produk
                </h1>
                <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill shadow-sm">
                    {{ $products->total() ?? 0 }} Produk
                </span>
            </div>

            <div class="row g-3 g-md-4">
                @forelse($products as $product)
                    <div class="col-xl-4 col-md-6 col-6 animate-fade-in" style="animation-delay: {{ 0.2 + ($loop->iteration * 0.1) }}s;">
                        <div class="card h-100 product-card border-0">
                            {{-- Stok Badge --}}
                            @if($product->stock > 10)
                                <div class="modern-badge badge-success">Tersedia</div>
                            @elseif($product->stock > 0)
                                <div class="modern-badge badge-warning">Stok Tipis</div>
                            @else
                                <div class="modern-badge badge-danger">Habis</div>
                            @endif

                            {{-- Image Wrapper --}}
                            <a href="{{ route('products.show', $product->id) }}" class="product-img-wrapper">
                                @php
                                    $productImage = $product->image_url;
                                @endphp
                                <img src="{{ $productImage }}" 
                                     class="card-img-top" alt="{{ $product->name }}">
                            </a>
                            
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold mb-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark hover-text-accent transition-all">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                
                                <p class="card-text text-muted small flex-grow-1 lh-sm mb-3 opacity-75">
                                    {{ Str::limit($product->description, 65) }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-end mb-4">
                                    <div>
                                        <div class="small text-muted mb-1"><i class="fas fa-box-open me-1"></i> Sisa: {{ $product->stock }}</div>
                                        <div class="product-price h5 mb-0 fw-black">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <div class="d-grid mt-auto">
                                    @auth
                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-modern-accent w-100 rounded-pill shadow-sm">
                                                    <i class="fas fa-cart-plus me-2"></i> Tambah
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-light text-muted fw-bold w-100 rounded-pill border" disabled>Habis Terjual</button>
                                        @endif
                                    @else
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-modern-outline w-100 rounded-pill">
                                            Detail Produk
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 animate-fade-in">
                        <div class="text-center py-5 bg-white border-0 shadow-sm empty-state-box">
                            <div class="floating-icon">
                                <i class="fas fa-box-open fa-4x text-muted mb-4 opacity-50"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Oops, Kosong!</h4>
                            <p class="text-muted">Tidak ada produk yang ditemukan di kategori ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if(method_exists($products, 'hasPages') && $products->hasPages())
                <div class="d-flex justify-content-center mt-5 pagination-modern animate-fade-in" style="animation-delay: 0.8s;">
                    {{ $products->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Variabel Warna */
    :root {
        --primary-color: #2c3e50;
        --accent-color: #e67e22;
        --accent-hover: #d35400;
        --accent-light: #fff8f3;
        --shadow-soft: 0 10px 30px rgba(0,0,0,0.05);
        --shadow-hover: 0 15px 35px rgba(230, 126, 34, 0.15);
    }

    /* Utilitas Text */
    .text-primary-custom { color: var(--primary-color); }
    .fw-black { font-weight: 800; }
    .transition-all { transition: all 0.3s ease; }
    .hover-text-accent:hover { color: var(--accent-color) !important; }

    /* Keyframes Animasi Keren */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    .floating-icon { animation: float 3s ease-in-out infinite; }

    /* Elemen Judul */
    .title-accent {
        display: inline-block;
        width: 6px;
        height: 24px;
        background: linear-gradient(to bottom, var(--accent-color), #f1c40f);
        border-radius: 10px;
    }

    /* Styling Sidebar Kategori */
    .category-card {
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(0,0,0,0.02);
    }
    .rounded-bottom-20 { border-radius: 0 0 20px 20px; overflow: hidden; }
    .icon-box {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(230, 126, 34, 0.3);
    }
    .list-group-item-action {
        border: none;
        padding: 0.85rem 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        font-weight: 500;
        color: #555;
    }
    .list-group-item-action::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: var(--accent-color);
        transform: scaleY(0);
        transition: transform 0.3s ease;
        transform-origin: center;
    }
    .list-group-item-action:hover, .list-group-item-action.active {
        background-color: var(--accent-light);
        color: var(--accent-color);
        padding-left: 2rem;
    }
    .list-group-item-action:hover::before, .list-group-item-action.active::before {
        transform: scaleY(1);
    }
    .category-icon { opacity: 0.6; transition: opacity 0.3s; }
    .list-group-item-action:hover .category-icon, .list-group-item-action.active .category-icon { opacity: 1; }

    /* Styling Card Produk */
    .product-card {
        border-radius: 20px;
        background: #fff;
        box-shadow: var(--shadow-soft);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    /* Image Hover Effect */
    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        display: block;
        height: 220px;
    }
    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .product-card:hover .product-img-wrapper img {
        transform: scale(1.12) rotate(1deg);
    }

    /* Badges */
    .modern-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        backdrop-filter: blur(5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .badge-success { background: rgba(46, 204, 113, 0.9); color: white; }
    .badge-warning { background: rgba(241, 196, 15, 0.9); color: #333; }
    .badge-danger { background: rgba(231, 76, 60, 0.9); color: white; }

    /* Typografi Card */
    .product-price {
        color: var(--accent-color);
        background: -webkit-linear-gradient(45deg, var(--accent-color), #f1c40f);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Buttons */
    .btn-modern-accent {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        border: none;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
    }
    .btn-modern-accent:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(230, 126, 34, 0.4);
        color: white;
    }
    .btn-modern-outline {
        color: var(--accent-color);
        border: 2px solid var(--accent-color);
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
        background: transparent;
    }
    .btn-modern-outline:hover {
        background: var(--accent-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
    }

    /* Empty State */
    .empty-state-box { border-radius: 25px; }

    /* Modern Pagination */
    .pagination-modern .page-item .page-link {
        border-radius: 50% !important;
        margin: 0 4px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: var(--primary-color);
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .pagination-modern .page-item.active .page-link {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        box-shadow: 0 4px 10px rgba(230, 126, 34, 0.3);
    }
    .pagination-modern .page-item .page-link:hover:not(.active) {
        background-color: var(--accent-light);
        color: var(--accent-color);
        transform: translateY(-2px);
    }

    /* Responsive mobile styles */
    @media (max-width: 767.98px) {
        .category-card {
            position: static !important;
            margin-bottom: 1.5rem;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
        .category-card .card-header {
            background: transparent !important;
            padding: 0 0 0.75rem 0 !important;
            font-size: 1.1rem;
        }
        .category-card .list-group {
            flex-direction: row !important;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 0.5rem;
            -webkit-overflow-scrolling: touch;
            gap: 0.5rem;
            border-radius: 0 !important;
            display: flex !important;
        }
        .category-card .list-group-item {
            border-radius: 50px !important;
            border: 1px solid #e9ecef !important;
            padding: 0.5rem 1.25rem !important;
            display: inline-block;
            width: auto !important;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .category-card .list-group-item.active {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)) !important;
            color: white !important;
            border-color: var(--accent-color) !important;
        }
        .category-card .list-group-item::before {
            display: none !important;
        }
        
        /* 2 Columns grid adjustments */
        .product-card .card-body {
            padding: 1rem !important;
        }
        .product-card .card-title {
            font-size: 0.95rem !important;
            line-height: 1.3;
        }
        .product-card .card-title a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card .product-price {
            font-size: 1rem !important;
        }
        .product-card .product-img-wrapper {
            height: 140px;
        }
        .product-card .btn-modern-accent, 
        .product-card .btn-modern-outline {
            font-size: 0.8rem !important;
            padding: 0.5rem 0.75rem !important;
        }
        .product-card .card-text {
            display: none !important; /* Hide description on mobile grid to maintain uniform height */
        }
        .product-card .modern-badge {
            top: 10px;
            right: 10px;
            padding: 0.25rem 0.6rem;
            font-size: 0.65rem;
        }
    }
</style>
@endpush