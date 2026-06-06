@extends('layouts.app')

@section('title', 'Detail Invoice - Marinasi Lele')

@section('content')
<div class="container py-5 animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="/my-orders" class="btn btn-light rounded-pill px-4 shadow-sm border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-danger rounded-pill px-4 shadow-sm" style="background-color: #A81C1C; border: none;">
            <i class="fas fa-print me-2"></i> Cetak Invoice
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="p-4 p-md-5 text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="background: linear-gradient(135deg, #A81C1C, #8B1515);">
            <div>
                <h3 class="fw-black mb-1" style="font-weight: 900;"><i class="fas fa-fish me-2"></i> MarinasiLele</h3>
                <p class="mb-0 opacity-75 small">Lauk Praktis & Lezat Khas Nusantara</p>
            </div>
            <div class="text-md-end">
                <h4 class="fw-bold text-uppercase mb-0" style="letter-spacing: 1px;">INVOICE</h4>
                <span class="fs-5 opacity-90">#{{ $order->order_number }}</span>
            </div>
        </div>

        <div class="card-body p-4 p-md-5">
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <p class="text-muted text-uppercase small fw-bold mb-2" style="letter-spacing: 0.5px;">Ditagihkan Kepada:</p>
                    <h5 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small mb-2"><i class="far fa-envelope me-1"></i> {{ auth()->user()->email }}</p>
                    <p class="text-secondary small mb-0"><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $order->shipping_address ?? $order->address }}</p>
                    @if($order->latitude && $order->longitude)
                        <div class="mt-3">
                            <div id="map-show" style="height: 180px; width: 100%; max-width: 400px;" class="rounded-3 border shadow-sm"></div>
                        </div>
                    @endif
                </div>

                <div class="col-md-6 text-md-end">
                    <p class="text-muted text-uppercase small fw-bold mb-2" style="letter-spacing: 0.5px;">Detail Transaksi:</p>
                    <p class="text-dark small mb-2">Tanggal: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></p>
                    
                    {{-- FIX PERBAIKAN LOGKA LUNAS USER --}}
                    <p class="text-dark small mb-2">Pembayaran: 
                        @if(strtolower($order->status) == 'success' || strtolower($order->status) == 'completed')
                            <span class="badge bg-success px-3 py-1.5 rounded-pill shadow-sm text-white fw-bold">LUNAS</span>
                        @elseif(strtolower($order->status) == 'awaiting_confirmation')
                            <span class="badge bg-info text-dark px-3 py-1.5 rounded-pill fw-bold shadow-sm">MENUNGGU DRIVER</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold shadow-sm">BELUM LUNAS</span>
                        @endif
                    </p>

                    <p class="text-dark small mb-0">Status Pesanan: 
                        @php
                            $badgeColor = [
                                'pending' => 'warning',
                                'success' => 'success',
                                'completed' => 'success',
                                'awaiting_confirmation' => 'info'
                            ][strtolower($order->status)] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} px-3 py-1.5 rounded-pill fw-bold text-uppercase">
                            {{ $order->status == 'success' ? 'COMPLETED' : $order->status }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-borderless align-middle">
                    <thead class="bg-light text-muted small text-uppercase" style="letter-spacing: 0.5px;">
                        <tr class="border-bottom">
                            <th class="py-3 ps-3">Deskripsi Produk</th>
                            <th class="py-3 text-center">Harga</th>
                            <th class="py-3 text-center">Qty</th>
                            <th class="py-3 text-end pe-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($order->items && $order->items->count() > 0)
                            @foreach($order->items as $item)
                            <tr class="border-bottom">
                                <td class="py-3 ps-3 fw-bold text-dark">{{ optional($item->product)->name ?? 'Produk Marinasi' }}</td>
                                <td class="py-3 text-center">Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</td>
                                <td class="py-3 text-center">{{ $item->quantity }}</td>
                                <td class="py-3 text-end pe-3 fw-bold text-dark">Rp {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        @else
                            {{-- Cadangan jika relasi items kosong --}}
                            <tr class="border-bottom">
                                <td class="py-3 ps-3 fw-bold text-dark">Paket Hidangan Marinasi Lele / Ayam</td>
                                <td class="py-3 text-center">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 text-center">1</td>
                                <td class="py-3 text-end pe-3 fw-bold text-dark">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Total Harga Barang:</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($order->total_price ?? ($order->total_amount - $order->shipping_fee), 0, ',', '.') }}</span>
                    </div>
                    @if($order->shipping_fee > 0)
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Ongkos Kirim ({{ $order->distance }} km):</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
                    </div>
                    @else
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Ongkos Kirim:</span>
                        <span class="text-success fw-bold">Gratis / Dine-in</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-4 border mt-2">
                        <span class="fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">Total Pembayaran</span>
                        <span class="fw-black text-danger fs-3" style="font-weight: 900;">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .bg-success { background-color: #198754 !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .bg-info { background-color: #0dcaf0 !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; color: #0f5132 !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; color: #664d03 !important; }
    .bg-info-subtle { background-color: #cff4fc !important; color: #055160 !important; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeInUp 0.4s ease forwards; }
</style>

@if($order->latitude && $order->longitude)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const lat = {{ $order->latitude }};
        const lng = {{ $order->longitude }};
        
        const map = L.map('map-show', {
            zoomControl: false,
            attributionControl: false
        }).setView([lat, lng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        const customerIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            shadowSize: [41, 41]
        });

        L.marker([lat, lng], { icon: customerIcon }).addTo(map)
            .bindPopup('Lokasi Pengiriman Anda')
            .openPopup();
    });
</script>
@endpush
@endif
@endsection