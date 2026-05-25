@extends('layouts.app')

@section('title', 'Pesanan Saya - Marinasi Lele')

@push('styles')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endpush

@section('content')
<div class="container py-5 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="mb-4 pb-2 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-clipboard-list text-accent me-2"></i> Riwayat Pesanan</h2>
            <p class="text-muted small mb-0">Pantau status pembayaran dan pengiriman lauk marinasi Anda di sini.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3 fw-semibold shadow-sm">
            <i class="fas fa-shopping-cart me-1"></i> Belanja Lagi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-success-subtle border-success text-success fw-bold rounded-pill px-4 mb-4 shadow-sm animate-fade-in">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-12">
            @forelse($orders as $order)
                <div class="card order-main-card border-0 shadow-sm rounded-4 mb-4 overflow-hidden transition-all">
                    <div class="card-header bg-light border-0 py-3 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <span class="fw-bold text-dark fs-5">#{{ $order->order_number }}</span>
                            <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> {{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        
                        @php
                            $statusBadge = [
                                'pending' => 'warning', 'processing' => 'info', 'shipped' => 'primary',
                                'completed' => 'success', 'success' => 'success', 'cancelled' => 'danger'
                            ][strtolower($order->status)] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusBadge }}-subtle text-{{ $statusBadge }} px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.75rem;">
                            {{ $order->status == 'success' ? 'COMPLETED' : $order->status }}
                        </span>
                    </div>

                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-5 mb-3 mb-md-0">
                                <div class="mb-3">
                                    <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Total Tagihan</small>
                                    <span class="fw-black text-accent fs-3">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="d-flex align-items-center gap-2">
                                    <small class="text-muted fw-semibold">Status Pembayaran:</small>
                                    @if(strtolower($order->status) == 'success' || strtolower($order->status) == 'completed')
                                        <span class="badge bg-success px-3 py-1.5 rounded-pill shadow-sm"><i class="fas fa-check-circle me-1"></i> Lunas</span>
                                    @elseif(strtolower($order->status) == 'processing')
                                        <span class="badge bg-info text-dark px-3 py-1.5 rounded-pill fw-semibold shadow-sm"><i class="fas fa-motorcycle me-1"></i> Menunggu Driver</span>
                                    @elseif(strtolower($order->status) == 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-semibold shadow-sm"><i class="fas fa-exclamation-circle me-1"></i> Belum Bayar</span>
                                    @elseif(strtolower($order->status) == 'cancelled')
                                        <span class="badge bg-danger px-3 py-1.5 rounded-pill shadow-sm"><i class="fas fa-times-circle me-1"></i> Gagal / Kadaluarsa</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-1.5 rounded-pill shadow-sm">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-7 text-md-end">
                                <div class="d-flex justify-content-md-end gap-2 flex-wrap">
                                    @if(strtolower($order->status) == 'pending')
                                        <button type="button" class="btn btn-qris rounded-pill px-4 py-2 fw-bold shadow-sm" onclick="payExistingOrder('{{ $order->order_number }}')">
                                            <i class="fas fa-qrcode me-2"></i> Bayar Sekarang (QRIS)
                                        </button>
                                        
                                        <form action="{{ route('orders.mark_paid_cod', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm" onclick="if(confirm('Pilih metode Cash/Tunai? Driver akan menagih uang tunai saat pesanan sampai.')) this.form.submit();">
                                                <i class="fas fa-money-bill-wave me-2"></i> Gunakan Cash
                                            </button>
                                        </form>
                                    @elseif(strtolower($order->status) == 'cancelled')
                                        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm" onclick="payExistingOrder('{{ $order->order_number }}')">
                                            <i class="fas fa-sync me-2"></i> Coba Bayar Lagi
                                        </button>
                                        
                                        <form action="{{ route('orders.mark_paid_cod', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm" onclick="if(confirm('Pilih metode Cash/Tunai? Driver akan menagih uang tunai saat pesanan sampai.')) this.form.submit();">
                                                <i class="fas fa-money-bill-wave me-2"></i> Gunakan Cash
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold border-secondary-subtle hover-bg-light">
                                        <i class="fas fa-file-invoice me-1"></i> Detail Invoice
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if(strtolower($order->status) == 'processing')
                            <div class="alert bg-warning-subtle border-0 shadow-sm rounded-4 p-4 mt-4 text-center" style="border-left: 5px solid #FFB800 !important;">
                                <i class="fas fa-motorcycle text-warning mb-2 fs-3 animate-pulse"></i>
                                <h6 class="fw-bold text-dark mb-1">Membayar dengan Uang Tunai (COD)</h6>
                                <p class="mb-0 text-muted small">Pesanan sedang disiapkan. Silakan siapkan uang tunai <strong class="text-danger">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</strong> saat pesanan tiba.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white border-0 shadow-sm rounded-4 mt-3">
                    <h4 class="fw-bold text-dark">Belum Ada Transaksi</h4>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    function payExistingOrder(orderNumber) {
        fetch(`/orders/${orderNumber}/snap-token`)
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if(data.paid) {
                window.location.reload();
                return;
            }
            snap.pay(data.snap_token, {
                onSuccess: function(result){
                    // PAKSA browser pindah ke URL pelunasan
                    window.location.href = "/checkout/success-local/" + orderNumber;
                }
            });
        })
        .catch(err => {
            alert(err.error || 'Terjadi kesalahan saat memproses pembayaran ulang.');
        });
    }
</script>
<style>
    :root { --accent-color: #A81C1C; }
    .text-accent { color: var(--accent-color) !important; }
    .fw-black { font-weight: 900; }
    .order-main-card { border: 1px solid rgba(0,0,0,0.03) !important; }
    .btn-qris { background-color: #00bcd4; color: white; border: none; }
    .btn-qris:hover { background-color: #00acc1; color: white; }
    .hover-bg-light:hover { background-color: #f8f9fa; }
    .bg-success-subtle { background-color: #d1e7dd !important; color: #0f5132 !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; color: #664d03 !important; }
    .bg-info-subtle { background-color: #cff4fc !important; color: #055160 !important; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }
    @keyframes pulse { 0% { opacity: 0.6; } 50% { opacity: 1; } 100% { opacity: 0.6; } }
    .animate-pulse { animation: pulse 2s infinite ease-in-out; }
</style>
@endpush