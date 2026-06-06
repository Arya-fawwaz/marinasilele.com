@extends('admin.layouts.admin')

@section('title', 'Pusat Laporan Analitik')

@section('content')
<div class="container-fluid p-0 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-0">Pusat Laporan</h2>
        <p class="text-muted mb-0">Pilih jenis laporan untuk melihat analitik dan mengunduh data performa toko.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card report-menu-card border-0 shadow-sm h-100 p-3">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-4">
                        <div class="report-icon-box bg-orange-soft text-orange">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="fw-bold text-dark mb-1">Laporan Penjualan</h4>
                            <p class="text-muted small mb-0">Omzet, tren transaksi, & kuantitas produk terjual.</p>
                        </div>
                    </div>
                    <p class="text-secondary small flex-grow-1">
                        Pantau grafik perkembangan omzet harian/bulanan, histogram distribusi produk, serta unduh data transaksi lengkap dalam format spreadsheet Excel atau dokumen cetak PDF.
                    </p>
                    <a href="{{ route('admin.reports.sales') }}" class="btn btn-primary rounded-pill w-100 fw-semibold mt-3">
                        Buka Analitik Penjualan <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card report-menu-card border-0 shadow-sm h-100 p-3">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-4">
                        <div class="report-icon-box bg-blue-soft text-blue">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="fw-bold text-dark mb-1">Laporan Stok & Produk</h4>
                            <p class="text-muted small mb-0">Sisa inventori, produk terlaris, & log limit stok.</p>
                        </div>
                    </div>
                    <p class="text-secondary small flex-grow-1">
                        Analisis ketersediaan bahan baku lele marinasi, status produk aktif/nonaktif, serta dapatkan peringatan otomatis untuk item-item yang persediaannya hampir habis.
                    </p>
                    <a href="{{ route('admin.reports.stock') }}" class="btn btn-outline-secondary rounded-pill w-100 fw-semibold mt-3">
                        Buka Manajemen Stok <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .text-orange { color: #e67e22 !important; }
    .bg-orange-soft { background-color: rgba(230, 126, 34, 0.08) !important; }
    .text-blue { color: #2563eb !important; }
    .bg-blue-soft { background-color: rgba(59, 130, 246, 0.08) !important; }

    .report-menu-card {
        border-radius: var(--radius-lg);
        transition: var(--transition);
        border: 1px solid var(--border-color) !important;
    }
    .report-menu-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-premium) !important;
        border-color: rgba(168, 28, 28, 0.15) !important;
    }

    .report-icon-box {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endpush
@endsection