@extends('admin.layouts.admin')

@section('title', 'Laporan Stok Produk')

@section('content')
<div class="container-fluid p-0 animate-fade-in">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-black text-dark mb-1" style="font-weight: 900; letter-spacing: -0.5px;">Laporan <span style="color: #e67e22;">Stok</span></h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Pantau ketersediaan produk marinasi Anda secara real-time.</p>
        </div>
        
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-add-modern rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                <i class="fas fa-box-open"></i> Kelola Produk
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 summary-card overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Total Produk Aktif</p>
                        <h3 class="fw-black text-dark mb-0">{{ isset($products) ? $products->where('status', 'active')->count() : 0 }} <span class="fs-6 text-muted fw-normal">Item</span></h3>
                    </div>
                    <div class="summary-icon bg-primary-soft text-primary">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
                <div class="bg-primary" style="height: 4px; width: 100%;"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 summary-card overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Stok Menipis (< 10)</p>
                        <h3 class="fw-black text-dark mb-0">{{ isset($products) ? $products->where('stock', '<=', 10)->where('stock', '>', 0)->count() : 0 }} <span class="fs-6 text-muted fw-normal">Item</span></h3>
                    </div>
                    <div class="summary-icon bg-warning-soft text-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="bg-warning" style="height: 4px; width: 100%;"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 summary-card overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Stok Habis</p>
                        <h3 class="fw-black text-dark mb-0">{{ isset($products) ? $products->where('stock', '<=', 0)->count() : 0 }} <span class="fs-6 text-muted fw-normal">Item</span></h3>
                    </div>
                    <div class="summary-icon bg-danger-soft text-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
                <div class="bg-danger" style="height: 4px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <div class="table-responsive pb-5">
        <table class="table table-custom borderless align-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">#</th>
                    <th width="35%" class="text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Nama Produk</th>
                    <th width="15%" class="text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Harga Jual</th>
                    <th width="30%" class="text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Indikator Stok</th>
                    <th width="15%" class="text-end text-muted fw-bold text-uppercase pe-4" style="font-size: 0.75rem; letter-spacing: 1px;">Sisa Fisik</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $index => $p)
                    <tr class="row-hover-lift" style="animation-delay: {{ $index * 0.05 }}s;">
                        <td class="text-center text-muted fw-semibold">
                            {{ method_exists($products, 'currentPage') ? $loop->iteration + ($products->currentPage() - 1) * $products->perPage() : $loop->iteration }}
                        </td>
                        
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="product-thumbnail shadow-sm border border-light" style="width: 45px; height: 45px;">
                                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 1rem;">{{ $p->name }}</h6>
                                    <span class="text-muted" style="font-size: 0.75rem;">Status: 
                                        <span class="{{ $p->status == 'active' ? 'text-success' : 'text-danger' }} fw-bold">
                                            {{ strtoupper($p->status) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div class="fw-semibold text-dark" style="font-size: 0.95rem;">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                        </td>
                        
                        <td>
                            @php
                                $maxStock = 100; // Asumsi batas maksimal visual bar
                                $percentage = ($p->stock / $maxStock) * 100;
                                $percentage = $percentage > 100 ? 100 : $percentage;
                                
                                $barColor = 'bg-success';
                                if($p->stock <= 10 && $p->stock > 0) $barColor = 'bg-warning';
                                if($p->stock <= 0) $barColor = 'bg-danger';
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 8px; border-radius: 10px; background-color: rgba(0,0,0,0.05);">
                                    <div class="progress-bar {{ $barColor }} rounded-pill" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $p->stock }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="text-end pe-4">
                            @if($p->stock > 10)
                                <div class="badge-modern bg-success-soft text-success">
                                    {{ $p->stock }} Pcs
                                </div>
                            @elseif($p->stock > 0)
                                <div class="badge-modern bg-warning-soft text-warning">
                                    {{ $p->stock }} Pcs
                                </div>
                            @else
                                <div class="badge-modern bg-danger-soft text-danger">
                                    Habis
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state-wrapper py-5">
                                <div class="empty-state-icon mb-3" style="width: 80px; height: 80px; background-color: rgba(0,0,0,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: #adb5bd;">
                                    <i class="fas fa-clipboard-list fa-3x"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Data Tidak Ditemukan</h5>
                                <p class="text-muted mb-0">Belum ada data produk untuk ditampilkan pada laporan ini.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(isset($products) && method_exists($products, 'hasPages') && $products->hasPages())
    <div class="d-flex justify-content-center mt-2 d-print-none">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
    @endif

</div>

@push('styles')
<style>
    /* Animasi Masuk */
    @keyframes fadeInUpRow {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeInUpRow 0.6s ease forwards;
    }

    /* Summary Cards */
    .summary-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Tabel Custom: Floating Rows */
    .table-custom {
        border-collapse: separate;
        border-spacing: 0 12px;
        margin-top: -12px;
    }
    .table-custom thead th {
        border-bottom: none;
        padding-bottom: 0.5rem;
    }
    .table-custom tbody tr {
        background-color: #ffffff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        border-radius: 15px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        opacity: 0;
        animation: fadeInUpRow 0.5s ease forwards;
    }
    .table-custom tbody tr td {
        padding: 1rem;
        border-top: 1px solid rgba(0,0,0,0.015);
        border-bottom: 1px solid rgba(0,0,0,0.015);
        vertical-align: middle;
    }
    .table-custom tbody tr td:first-child {
        border-left: 1px solid rgba(0,0,0,0.015);
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
    }
    .table-custom tbody tr td:last-child {
        border-right: 1px solid rgba(0,0,0,0.015);
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
    }
    .row-hover-lift:hover {
        transform: translateY(-3px) scale(1.005);
        box-shadow: 0 15px 30px rgba(230, 126, 34, 0.08);
    }

    /* Thumbnail Produk */
    .product-thumbnail {
        border-radius: 10px;
        overflow: hidden;
        background-color: #f8f9fa;
        flex-shrink: 0;
    }
    .product-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Badge & Colors */
    .badge-modern {
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.8rem;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.15); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.2); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }

    /* Tombol Utama (Orange Theme Admin) */
    .btn-add-modern {
        background: linear-gradient(135deg, #e67e22, #f39c12);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-add-modern:hover {
        background: linear-gradient(135deg, #d35400, #e67e22);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(230, 126, 34, 0.3) !important;
    }

    /* Print Styling */
    @media print {
        body { background-color: white !important; }
        .admin-sidebar, .admin-topbar, .btn, .d-print-none { display: none !important; }
        .main-content-wrapper { margin-left: 0 !important; }
        .card, .table-custom tbody tr { box-shadow: none !important; border: 1px solid #ddd !important; }
        .progress { display: none !important; }
    }
</style>
@endpush
@endsection