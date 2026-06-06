@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="container-fluid p-0 animate-fade-in">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border small fw-semibold">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pesanan
        </a>
        <div class="bg-white px-4 py-2 rounded-pill shadow-sm border fw-bold text-dark small">
            No. Invoice: <span class="text-danger">#{{ $order->order_number }}</span>
        </div>
    </div>

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-0">Manajemen <span style="color: #A81C1C;">Pesanan</span></h2>
        <p class="text-muted small mt-1">Kelola rincian data serta status transaksi pelanggan secara mendalam.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase fw-bold small mb-4" style="letter-spacing: 0.5px;"><i class="fas fa-user-clock text-danger me-2"></i> Informasi Pelanggan & Waktu</h6>
                    
                    <div class="row g-4 align-items-center">
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm fw-bold fs-4 flex-shrink-0" style="width: 55px; height: 55px;">
                                {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $order->user->name ?? 'Guest User' }}</h5>
                                <p class="text-muted small mb-0"><i class="far fa-envelope me-1"></i> {{ $order->user->email ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 border-start-md ps-md-4">
                            <div class="mb-2">
                                <small class="text-muted d-block small">Tanggal Transaksi</small>
                                <span class="fw-bold text-dark"><i class="far fa-calendar-alt me-1 text-muted"></i> {{ $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div>
                                <small class="text-muted d-block small">Waktu Pemesanan</small>
                                <span class="fw-bold text-dark"><i class="far fa-clock me-1 text-muted"></i> {{ $order->created_at->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <hr class="opacity-10 my-4">

                    <div>
                        <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;"><i class="fas fa-map-marker-alt me-1 text-danger"></i> Alamat Pengiriman / No. Meja</small>
                        <div class="bg-light p-3 rounded-3 text-dark fw-medium fs-6 border border-light">
                            {{ $order->shipping_address ?? $order->address ?? 'Tidak ada alamat.' }}
                        </div>
                        @if($order->latitude && $order->longitude)
                            <div class="mt-3">
                                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;"><i class="fas fa-map text-danger me-1"></i> Peta Lokasi Kurir (Koordinat: {{ $order->latitude }}, {{ $order->longitude }})</small>
                                <div id="map-admin" style="height: 350px; width: 100%;" class="rounded-4 border shadow-sm"></div>
                                <div class="mt-2 d-flex gap-2">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka di Google Maps
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="text-muted text-uppercase fw-bold small mb-0" style="letter-spacing: 0.5px;"><i class="fas fa-shopping-basket text-danger me-2"></i> Rincian Pembelian</h6>
                        <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill fw-bold small">{{ $order->items ? $order->items->count() : 0 }} Item</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase" style="letter-spacing: 0.5px;">
                                <tr class="border-bottom">
                                    <th class="py-3 ps-3">Produk</th>
                                    <th class="py-3 text-center">Harga Satuan</th>
                                    <th class="py-3 text-center">Qty</th>
                                    <th class="py-3 text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($order->items && $order->items->count() > 0)
                                    @foreach($order->items as $item)
                                    <tr class="border-bottom">
                                        <td class="py-3 ps-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-fish text-muted"></i>
                                                </div>
                                                <span class="fw-bold text-dark">{{ optional($item->product)->name ?? 'Produk Terhapus' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-center text-dark fw-medium">Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-3 text-center fw-bold text-dark">{{ $item->quantity }}</td>
                                        <td class="py-3 text-end pe-3 fw-black text-dark">Rp {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr class="border-bottom">
                                        <td class="py-3 ps-3 fw-bold text-dark" colspan="3"><i class="fas fa-info-circle text-muted me-1"></i> Paket Hidangan Lele / Ayam Marinasi</td>
                                        <td class="py-3 text-end pe-3 fw-black text-dark">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-4">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2 small text-muted">
                                <span>Total Harga Barang:</span>
                                <span class="fw-semibold text-dark">Rp {{ number_format($order->total_price ?? ($order->total_amount - ($order->shipping_fee ?? 0)), 0, ',', '.') }}</span>
                            </div>
                            @if(($order->shipping_fee ?? 0) > 0)
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
                                <span class="fw-bold text-muted text-uppercase small" style="letter-spacing: 0.5px;">Total Tagihan</span>
                                <span class="fw-black text-danger fs-3" style="font-weight: 900;">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="text-muted text-uppercase fw-bold small text-start mb-4" style="letter-spacing: 0.5px;"><i class="fas fa-money-check-alt text-danger me-2"></i> Status Finansial</h6>
                    
                    {{-- FIX OTOMATIS: Penentuan kotak status murni dideteksi dari kolom tunggal 'status' --}}
                    @if(strtolower($order->status) == 'success' || strtolower($order->status) == 'completed')
                        <div class="bg-success bg-opacity-10 p-5 rounded-4 border border-success border-opacity-25 animate-fade-in">
                            <i class="fas fa-check-circle text-success fa-4x mb-3 animate-pulse"></i>
                            <h4 class="fw-black text-success text-uppercase mb-0" style="font-weight: 900; letter-spacing: 1px;">LUNAS</h4>
                            <small class="text-success fw-semibold mt-2 d-block">Pembayaran Terverifikasi</small>
                        </div>
                    @elseif(strtolower($order->status) == 'awaiting_confirmation')
                        <div class="bg-info bg-opacity-10 p-5 rounded-4 border border-info border-opacity-25 animate-fade-in">
                            <i class="fas fa-clock text-info fa-4x mb-3 animate-pulse"></i>
                            <h4 class="fw-black text-info text-uppercase mb-0" style="font-weight: 900; letter-spacing: 1px;">KLAIM COD</h4>
                            <small class="text-info fw-semibold mt-2 d-block">Menunggu Setoran Tunai</small>
                        </div>
                    @else
                        <div class="bg-danger bg-opacity-10 p-5 rounded-4 border border-danger border-opacity-25 animate-fade-in">
                            <i class="fas fa-times-circle text-danger fa-4x mb-3 animate-pulse"></i>
                            <h4 class="fw-black text-danger text-uppercase mb-0" style="font-weight: 900; letter-spacing: 1px;">BELUM BAYAR</h4>
                            <small class="text-danger fw-semibold mt-2 d-block">Menunggu Transaksi</small>
                        </div>
                    @endif

                    <div class="mt-4 text-start">
                        <label class="form-label text-muted fw-bold small text-uppercase" style="letter-spacing: 0.5px;">Ubah Status Manual:</label>
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="d-flex gap-2">
                                <select name="status" class="form-select bg-light border-light rounded-3 shadow-none focus-ring focus-ring-danger">
                                    <option value="pending" {{ strtolower($order->status) == 'pending' ? 'selected' : '' }}>Belum Bayar (Pending)</option>
                                    <option value="success" {{ strtolower($order->status) == 'success' ? 'selected' : '' }}>Lunas (Success)</option>
                                    <option value="completed" {{ strtolower($order->status) == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                                    <option value="awaiting_confirmation" {{ strtolower($order->status) == 'awaiting_confirmation' ? 'selected' : '' }}>Klaim COD</option>
                                    <option value="cancelled" {{ strtolower($order->status) == 'cancelled' ? 'selected' : '' }}>Batal (Cancelled)</option>
                                </select>
                                <button type="submit" class="btn btn-dark rounded-3 px-4 fw-bold shadow-sm">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="text-muted text-uppercase fw-bold small mb-3" style="letter-spacing: 0.5px;"><i class="fas fa-truck-loading text-danger me-2"></i> Status Pengiriman</h6>
                    
                    @php
                        $alurColor = [
                            'pending' => 'warning', 'processing' => 'info',
                            'shipped' => 'primary', 'completed' => 'success', 'success' => 'success'
                        ][strtolower($order->status)] ?? 'secondary';
                    @endphp
                    <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded-3 border border-light">
                        <span class="small text-muted fw-medium">Alur Saat Ini:</span>
                        <span class="badge bg-{{ $alurColor }} text-uppercase px-3 py-1.5 rounded-pill fw-bold shadow-sm" style="font-size: 0.75rem;">
                            {{ $order->status == 'success' ? 'COMPLETED' : $order->status }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fw-black { font-weight: 900; }
    .border-start-md { border-left: 1px solid rgba(0,0,0,0.08) !important; }
    @media (max-width: 767.98px) { .border-start-md { border-left: none !important; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeInUp 0.5s ease forwards; }
    @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.03); } 100% { transform: scale(1); } }
    .animate-pulse { animation: pulse 2.5s infinite ease-in-out; }
    select:focus { border-color: #A81C1C !important; box-shadow: 0 0 0 0.25rem rgba(168, 28, 28, 0.15) !important; }
</style>
@endpush

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
        
        const map = L.map('map-admin', {
            zoomControl: true,
            attributionControl: true
        }).setView([lat, lng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const customerIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            shadowSize: [41, 41]
        });

        // Store location (fixed point: Metland Cibitung - Area Pasar/Ruko: -6.251667, 107.115833)
        const storeLat = -6.251667;
        const storeLng = 107.115833;
        const storeIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            shadowSize: [41, 41]
        });

        // Add Store Marker
        L.marker([storeLat, storeLng], { icon: storeIcon }).addTo(map)
            .bindPopup('<b>Toko Marina Si Lele</b><br>Metland Cibitung');

        // Add Customer Marker
        L.marker([lat, lng], { icon: customerIcon }).addTo(map)
            .bindPopup('<b>Lokasi Pengiriman Pelanggan</b><br>Jarak: {{ $order->distance }} km')
            .openPopup();

        // Fit map bounds to show both store and delivery location nicely
        const group = new L.featureGroup([
            L.marker([storeLat, storeLng]),
            L.marker([lat, lng])
        ]);
        map.fitBounds(group.getBounds().pad(0.2));
    });
</script>
@endpush
@endif