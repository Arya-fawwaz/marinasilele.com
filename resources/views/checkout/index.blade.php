@extends('layouts.app')

@section('title', 'Checkout Pesanan - Marinasi Lele')

@section('content')
<div class="container py-5 mt-2 mb-5">
    
    <div class="d-flex align-items-center mb-4 animate-fade-in">
        <i class="fas fa-lock fa-2x text-success me-3"></i>
        <h2 class="fw-black text-dark mb-0" style="font-weight: 900;">Checkout <span style="color: #A81C1C;">Aman</span></h2>
    </div>

    <form action="{{ route('checkout.process') ?? '#' }}" method="POST" class="animate-fade-in" style="animation-delay: 0.1s;">
        @csrf
        
        <div class="row g-4">
            
            <div class="col-lg-7">
                
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-truck text-primary me-2"></i> Informasi Pengiriman</h5>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase" style="letter-spacing: 0.5px;">Alamat Lengkap Pengiriman / No. Meja</label>
                            <textarea name="address" class="form-control bg-light border-light rounded-3 p-3 shadow-none focus-ring focus-ring-danger" rows="4" placeholder="Contoh: Jl. Alinda 1 Blok B No. 12 / Meja Nomor 5" required></textarea>
                            <small class="text-danger mt-2 d-block fw-medium">*Wajib diisi agar pesanan dapat diproses.</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark text-uppercase" style="font-size: 0.9rem; letter-spacing: 1px;">Metode Pembayaran</h5>
                        
                        <div class="bg-warning bg-opacity-10 p-4 rounded-4 d-flex align-items-center border border-warning border-opacity-25 transition-all">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4 flex-shrink-0" style="width: 55px; height: 55px;">
                                <i class="fas fa-qrcode text-dark fs-3"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1 fs-5">QRIS / Bayar di Tempat (Cash)</h6>
                                <p class="text-muted small mb-0 lh-lg">Anda akan diarahkan ke halaman Barcode QRIS Midtrans setelah menekan tombol Buat Pesanan di samping.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-receipt text-danger me-2"></i> Ringkasan Belanja</h5>

                        <div class="mb-4">
                            @if(isset($carts) && $carts->count() > 0)
                                @foreach($carts as $cart)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                            <i class="fas fa-fish text-muted"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">{{ $cart->product->name ?? 'Produk Marinasi' }}</h6>
                                            <span class="text-muted" style="font-size: 0.8rem;">{{ $cart->quantity }} Porsi x Rp {{ number_format($cart->product->price ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-dark">
                                        Rp {{ number_format(($cart->product->price ?? 0) * $cart->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-basket fa-2x text-muted opacity-25 mb-2"></i>
                                    <p class="text-muted mb-0 small">Keranjang Anda masih kosong.</p>
                                </div>
                            @endif
                        </div>

                        <hr class="border-secondary opacity-10 my-4">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">Total Harga Barang</span>
                            <span class="fw-bold text-dark">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted fw-medium">Biaya Layanan</span>
                            <span class="fw-bold text-success">Gratis</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-4 mb-4 border border-light">
                            <span class="fw-bold text-dark text-uppercase" style="letter-spacing: 1px; font-size: 0.9rem;">Total Tagihan</span>
                            <span class="fw-black text-danger fs-3">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn w-100 rounded-pill py-3 fw-bold shadow-sm text-white" style="background: linear-gradient(135deg, #A81C1C, #8B1515); font-size: 1.05rem;" {{ (!isset($carts) || $carts->count() == 0) ? 'disabled' : '' }}>
                            Buat Pesanan Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        
                        <div class="text-center mt-4">
                            <small class="text-success fw-bold"><i class="fas fa-shield-alt me-1"></i> Data Anda dilindungi dengan aman.</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    textarea:focus {
        border-color: #A81C1C !important;
        box-shadow: 0 0 0 0.25rem rgba(168, 28, 28, 0.15) !important;
    }
    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(168, 28, 28, 0.2) !important;
        background: linear-gradient(135deg, #8B1515, #A81C1C) !important;
    }
    button[type="submit"]:disabled {
        background: #ccc !important;
        transform: none !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }
</style>
@endpush
@endsection