@extends('layouts.app')

@section('title', 'Pembayaran QRIS - #' . $order->order_number)

@section('content')
<div class="container py-5 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            <div class="alert bg-warning-subtle text-dark border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-4">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                    <i class="fas fa-wallet fs-4 text-warning"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Menunggu Pembayaran</h6>
                    <p class="mb-0 small text-muted">Selesaikan pembayaran untuk pesanan <strong class="text-danger">#{{ $order->order_number }}</strong> sebesar <strong class="text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-accent text-white text-center py-4 border-0">
                    <h4 class="fw-bold mb-0 d-flex align-items-center justify-content-center">
                        <i class="fas fa-qrcode me-2"></i> Pembayaran QRIS
                    </h4>
                </div>
                
                <div class="card-body p-4 p-md-5 text-center bg-white">
                    <p class="text-muted mb-4 small">Scan QRIS berikut menggunakan aplikasi M-Banking atau e-Wallet Anda (Gopay, OVO, Dana, ShopeePay, dll).</p>

                    <div class="bg-light p-3 rounded-4 mb-4 d-inline-block shadow-sm border border-2 border-white">
                        {{-- Ganti URL gambar di bawah ini dengan lokasi file gambar QRIS asli toko Anda --}}
                        {{-- Contoh jika file ada di folder public/images: src="{{ asset('images/qris-toko.png') }}" --}}
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="Scan QRIS" class="img-fluid rounded-3" style="width: 220px; height: 220px; object-fit: contain;">
                    </div>

                    <div class="bg-light rounded-4 p-4 text-start mb-4 border border-white shadow-sm">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-medium">No. Pesanan:</span>
                            <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top border-secondary-subtle pt-3 mt-2">
                            <span class="text-muted small fw-medium align-self-center">Total Tagihan:</span>
                            <span class="fw-black text-accent fs-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="alert bg-info-subtle border-0 rounded-4 small text-info-dark mb-4 text-start d-flex">
                        <i class="fas fa-shield-alt mt-1 me-2 fs-5"></i> 
                        <span>Setelah melakukan pembayaran, pesanan Anda akan otomatis diverifikasi atau dikonfirmasi oleh admin secara manual.</span>
                    </div>

                    <a href="{{ route('orders.index') }}" class="btn btn-brand rounded-pill px-5 py-3 fw-bold shadow-sm w-100">
                        Cek Riwayat Pesanan <i class="fas fa-arrow-right ms-2"></i>
                    </a>
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
    
    .bg-accent { background-color: var(--accent-color) !important; }
    .text-accent { color: var(--accent-color) !important; }
    .fw-black { font-weight: 900; }
    
    /* Subtle Backgrounds */
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .bg-info-subtle { background-color: #cff4fc !important; color: #055160 !important; }

    /* Button Styling */
    .btn-brand { 
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)); 
        color: white; 
        border: none; 
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); 
    }
    .btn-brand:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 10px 20px rgba(168, 28, 28, 0.2); 
        color: #FFB800; 
    }

    /* Animasi Masuk */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }
</style>
@endpush
@endsection