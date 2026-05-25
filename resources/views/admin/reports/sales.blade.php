@extends('admin.layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid p-0 animate-fade-in" style="animation-delay: 0.1s;">
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-4 px-4 py-3 mb-4 d-flex align-items-center d-print-none">
            <i class="fas fa-check-circle fs-4 me-3"></i>
            <span class="fw-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- HEADER & TOMBOL AKSI --}}
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end mb-4 gap-3 d-print-none">
        <div>
            <h2 class="fw-black text-dark mb-1">Laporan <span style="color: #A81C1C;">Penjualan</span></h2>
            <p class="text-muted small mb-0">Pantau pergerakan omzet dan rekapitulasi transaksi lunas.</p>
        </div>
        
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.reports.sales.excel', request()->all()) }}" class="btn btn-success rounded-pill fw-bold shadow-sm px-4 py-2 d-flex align-items-center transition-all">
                <i class="fas fa-file-excel me-2"></i> Export Excel
            </a>
            <button onclick="window.print()" class="btn btn-danger rounded-pill fw-bold shadow-sm px-4 py-2 d-flex align-items-center transition-all">
                <i class="fas fa-file-pdf me-2"></i> Cetak PDF
            </button>
            
            @if($orders->count() > 0)
                <form action="{{ route('admin.reports.sales.clear', request()->all()) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-dark rounded-pill fw-bold shadow-sm px-4 py-2 d-flex align-items-center transition-all" onclick="return confirm('PERINGATAN! Anda yakin ingin menutup pembukuan? Semua data penjualan yang tampil ini akan DIHAPUS PERMANEN dari database.')">
                        <i class="fas fa-trash-alt me-2"></i> Tutup Pembukuan
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- TOOLBAR FILTER TANGGAL --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
        <div class="card-body p-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center text-muted fw-medium small">
                <i class="fas fa-filter me-2 text-primary"></i> Filter Data Berdasarkan Tanggal:
            </div>
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="d-flex w-100 w-md-auto gap-2 align-items-center">
                <input type="date" name="start_date" class="form-control bg-light border-0 rounded-3 px-3" value="{{ request('start_date') }}" required>
                <span class="text-muted fw-bold">-</span>
                <input type="date" name="end_date" class="form-control bg-light border-0 rounded-3 px-3" value="{{ request('end_date') }}" required>
                <button type="submit" class="btn text-white rounded-3 px-4 fw-bold shadow-sm" style="background-color: #A81C1C;">Terapkan</button>
                @if(request('start_date'))
                    <a href="{{ route('admin.reports.sales') }}" class="btn btn-light rounded-3 px-3 border" title="Reset Filter"><i class="fas fa-redo-alt text-muted"></i></a>
                @endif
            </form>
        </div>
    </div>

    {{-- HEADER KHUSUS CETAK PDF --}}
    <div class="d-none d-print-block mb-4 pb-3 border-bottom border-2 border-dark text-center">
        <h1 class="fw-black text-dark mb-1" style="font-size: 24pt;">MARINASI LELE</h1>
        <h4 class="text-muted mb-2">Laporan Pendapatan & Penjualan</h4>
        <p class="small text-muted mb-0">
            <strong>Periode:</strong> {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') . ' s/d ' . \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Keseluruhan (Semua Waktu)' }}
        </p>
    </div>

    {{-- KARTU RINGKASAN (SUMMARY WIDGETS) --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient-primary text-white overflow-hidden summary-card">
                <div class="card-body p-4 position-relative">
                    <i class="fas fa-wallet position-absolute opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    <p class="mb-1 text-white-50 fw-semibold text-uppercase small" style="letter-spacing: 1px;">Total Omzet / Pendapatan</p>
                    <h3 class="fw-black mb-0 display-6">Rp {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white summary-card">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-warning-subtle text-warning-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-receipt fs-3"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted fw-semibold text-uppercase small" style="letter-spacing: 1px;">Total Transaksi</p>
                        <h3 class="fw-black text-dark mb-0">{{ $orders->count() }} <span class="fs-6 fw-medium text-muted">Pesanan</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white summary-card">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-box-open fs-3"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted fw-semibold text-uppercase small" style="letter-spacing: 1px;">Total Item Terjual</p>
                        <h3 class="fw-black text-dark mb-0">{{ $orders->sum(function($order) { return $order->items->sum('quantity'); }) }} <span class="fs-6 fw-medium text-muted">Porsi</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- AREA GRAFIK --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="fw-bold text-dark mb-1"><i class="fas fa-chart-line text-success me-2 d-print-none"></i> Tren Pendapatan</h6>
                            <p class="text-muted small mb-0 d-print-none">Grafik fluktuasi pergerakan nilai omzet harian.</p>
                        </div>
                    </div>
                    <canvas id="revenueChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-1"><i class="fas fa-chart-bar text-primary me-2 d-print-none"></i> Histogram Volume</h6>
                        <p class="text-muted small mb-0 d-print-none">Distribusi jumlah item/porsi terjual per hari.</p>
                    </div>
                    <canvas id="volumeChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL RINCIAN INVOICE --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.8rem; letter-spacing: 1px;">
                        <tr>
                            <th class="border-0 py-4 ps-4 text-uppercase">No. Invoice</th>
                            <th class="border-0 py-4 text-uppercase">Waktu Transaksi</th>
                            <th class="border-0 py-4 text-uppercase">Pelanggan</th>
                            <th class="border-0 py-4 text-center text-uppercase">Jumlah Item</th>
                            <th class="border-0 py-4 text-end pe-4 text-uppercase">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($orders as $row)
                        <tr>
                            <td class="ps-4 py-3 border-bottom border-light fw-bold text-dark">#{{ $row->order_number }}</td>
                            <td class="py-3 border-bottom border-light text-muted small">{{ $row->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-3 border-bottom border-light fw-medium">{{ optional($row->user)->name ?? 'Guest' }}</td>
                            <td class="py-3 border-bottom border-light text-center fw-bold">
                                <span class="badge bg-secondary-subtle text-dark px-3 py-2 rounded-pill">{{ $row->items->sum('quantity') }} Porsi</span>
                            </td>
                            <td class="py-3 pe-4 border-bottom border-light fw-black text-danger text-end fs-6">Rp {{ number_format($row->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 border-0 text-muted">
                                <div class="my-4">
                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3 opacity-25"></i>
                                    <h6 class="fw-bold">Belum ada data penjualan.</h6>
                                    <p class="small">Laporan akan muncul otomatis saat ada pesanan yang lunas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* UTILITIES */
    .fw-black { font-weight: 900; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .text-warning-dark { color: #856404 !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-secondary-subtle { background-color: #e2e3e5 !important; }
    .bg-gradient-primary { background: linear-gradient(135deg, #A81C1C, #8B1515); }
    
    .transition-all { transition: all 0.3s ease; }
    .btn:hover { transform: translateY(-2px); }
    .summary-card { border: 1px solid rgba(0,0,0,0.03); }

    /* ANIMASI MASUK */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }

    /* PENGATURAN MODE CETAK PDF (PRINT) */
    @media print {
        body { background-color: white !important; font-family: Arial, sans-serif !important; }
        .d-print-none, .sidebar, .navbar { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; margin-bottom: 20px !important; }
        .table { width: 100% !important; }
        .container-fluid { padding: 0 !important; width: 100% !important; }
        
        /* Memaksa warna background tetap muncul di PDF */
        .bg-gradient-primary { background: #A81C1C !important; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .bg-secondary-subtle { background-color: #e2e3e5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        
        /* Sesuaikan ukuran col saat print agar sejajar */
        .col-md-4 { width: 33.333333% !important; float: left !important; }
        .col-lg-7 { width: 58.333333% !important; float: left !important; }
        .col-lg-5 { width: 41.666667% !important; float: left !important; }
        .row::after { content: ""; clear: both; display: table; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = {!! json_encode($chartDates ?? []) !!};
        const dataTotals = {!! json_encode($chartTotals ?? []) !!};
        const dataVolumes = {!! json_encode($chartVolumes ?? []) !!};

        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataTotals,
                    borderColor: '#A81C1C',
                    backgroundColor: 'rgba(168, 28, 28, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#FFB800',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });

        const ctxVol = document.getElementById('volumeChart').getContext('2d');
        new Chart(ctxVol, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Porsi Terjual',
                    data: dataVolumes,
                    backgroundColor: '#FFB800',
                    borderRadius: 6
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
    });
</script>
@endpush
@endsection