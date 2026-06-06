@extends('layouts.app')

@section('title', 'Keranjang Belanja - Marinasi Lele')

@section('content')
<div class="container py-5 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="d-flex align-items-center mb-4">
        <h2 class="fw-black text-dark mb-0">
            <i class="fas fa-shopping-cart text-accent me-2"></i> Keranjang <span class="text-accent">Belanja</span>
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4 px-4 py-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-4 px-4 py-3 mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    @if(isset($cartItems) && $cartItems->count() > 0)
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="bg-light text-muted small tracking-wide">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase border-0">Produk</th>
                                    <th class="py-3 text-center text-uppercase border-0">Harga</th>
                                    <th class="py-3 text-center text-uppercase border-0">Kuantitas</th>
                                    <th class="py-3 text-end text-uppercase border-0">Subtotal</th>
                                    <th class="pe-4 py-3 border-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp
                                @foreach($cartItems as $item)
                                    @php
                                        $subtotal = $item->product->price * $item->quantity;
                                        $totalPrice += $subtotal;
                                    @endphp
                                    <tr class="border-bottom border-light">
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border shadow-sm flex-shrink-0" style="width: 65px; height: 65px; overflow: hidden;">
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1">{{ Str::limit($item->product->name, 35) }}</h6>
                                                    <span class="badge bg-secondary-subtle text-dark border px-2 py-1">Sisa Stok: {{ $item->product->stock }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-muted fw-medium py-4">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                        <td class="text-center py-4">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex align-items-center bg-light rounded-pill p-1 border shadow-sm">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control border-0 bg-transparent text-center fw-bold p-0 mx-2" style="width: 45px; box-shadow: none;" onchange="this.form.submit()">
                                                <button type="submit" class="btn btn-sm text-accent rounded-circle" title="Update"><i class="fas fa-sync-alt"></i></button>
                                            </form>
                                        </td>
                                        <td class="text-end fw-bold text-dark py-4">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td class="pe-4 text-end py-4">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light text-danger rounded-circle btn-sm hover-danger transition-all shadow-sm" onclick="return confirm('Yakin ingin menghapus item ini?')" title="Hapus">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 100px;">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold text-dark mb-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 text-muted">
                        <span class="fw-medium">Total Item</span>
                        <span class="fw-bold text-dark">{{ $cartItems->sum('quantity') }} Pcs</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light text-muted">
                        <span class="fw-medium">Total Harga</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-dark mb-0">Total Bayar</h5>
                        <h3 class="fw-black text-accent mb-0">Rp {{ number_format($totalPrice, 0, ',', '.') }}</h3>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-brand w-100 rounded-pill py-3 fw-bold shadow-sm btn-hover-rise mb-3">
                        Lanjut Checkout <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    
                    <a href="{{ route('products.index') }}" class="btn btn-light w-100 rounded-pill py-2 fw-semibold text-muted hover-text-dark transition-all">
                        <i class="fas fa-arrow-left me-2"></i> Kembali Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 120px; height: 120px;">
            <i class="fas fa-shopping-cart fa-4x text-muted opacity-25"></i>
        </div>
        <h4 class="fw-bold text-dark mb-3">Keranjang Anda Masih Kosong</h4>
        <p class="text-muted mb-4 max-w-600 mx-auto">Sepertinya Anda belum memilih lauk apapun. Yuk, jelajahi berbagai pilihan lauk marinasi lezat kami dan penuhi keranjang Anda!</p>
        <a href="{{ route('products.index') }}" class="btn btn-brand rounded-pill px-5 py-3 fw-bold shadow-sm btn-hover-rise">
            <i class="fas fa-fish me-2"></i> Mulai Belanja Sekarang
        </a>
    </div>
    @endif
</div>

@push('styles')
<style>
    :root {
        --accent-color: #A81C1C; 
        --accent-hover: #8B1515;
    }
    .text-accent { color: var(--accent-color) !important; }
    .fw-black { font-weight: 900; }
    .tracking-wide { letter-spacing: 1px; }
    
    .bg-secondary-subtle { background-color: #e2e3e5 !important; }

    .btn-brand { 
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)); 
        color: white; 
        border: none; 
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .btn-brand:hover { color: #FFB800; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(168, 28, 28, 0.2); }
    
    .btn-hover-rise { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .btn-hover-rise:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    
    .hover-danger:hover { background-color: #dc3545 !important; color: white !important; }

    /* Fix tombol panah (spinners) pada input number agar selalu muncul tapi rapi */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        opacity: 1; 
    }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }
</style>
@endpush
@endsection