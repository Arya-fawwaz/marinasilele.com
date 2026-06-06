@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-0">
    
    <div class="welcome-banner p-4 p-md-5 rounded-4 mb-4 shadow-sm animate-fade-in position-relative overflow-hidden" style="animation-delay: 0.1s;">
        <div class="position-absolute top-0 end-0 h-100 w-50" style="background: radial-gradient(circle, rgba(255,184,0,0.15) 0%, transparent 70%); transform: translate(20%, -20%);"></div>
        <div class="position-absolute bottom-0 start-0 h-100 w-50" style="background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);"></div>
        
        <div class="row align-items-center position-relative z-1">
            <div class="col-md-8">
                <span class="badge bg-white text-danger fw-bold mb-3 px-3 py-2 rounded-pill shadow-sm" style="letter-spacing: 1px; font-size: 0.75rem;">
                    <i class="fas fa-bolt text-warning me-1"></i> RINGKASAN HARI INI
                </span>
                <h2 class="fw-black text-white mb-2" style="font-size: 2.2rem; letter-spacing: -0.5px;">Selamat datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-white-50 mb-0" style="font-size: 1.05rem;">Pantau performa penjualan, ketersediaan stok, dan manajemen toko Anda secara real-time.</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
                <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur rounded-pill px-4 py-2 border border-light border-opacity-25">
                    <div class="bg-warning rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                        <i class="far fa-calendar-alt text-dark fs-6"></i>
                    </div>
                    <div class="text-start">
                        <p class="text-white fw-bold mb-0 lh-1" style="font-size: 0.9rem;">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <small class="text-white-50" style="font-size: 0.75rem;">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-4 col-md-6 animate-fade-in" style="animation-delay: 0.2s;">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="fas fa-shopping-bag fa-5x text-primary"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-2 text-uppercase d-flex align-items-center gap-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Total Pesanan <span class="badge bg-success-soft text-success rounded-pill"><i class="fas fa-arrow-up me-1"></i>12%</span>
                        </p>
                        <h3 class="fw-black mb-0 text-dark" style="font-size: 2.2rem;">{{ $totalOrders ?? 0 }}</h3>
                    </div>
                    <div class="stat-icon-wrapper bg-primary-soft text-primary shadow-sm z-1">
                        <i class="fas fa-shopping-bag fs-3"></i>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0 pb-4 px-4 z-1">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill fw-bold w-100">
                        Kelola Pesanan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 animate-fade-in" style="animation-delay: 0.3s;">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="fas fa-wallet fa-5x text-success"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-2 text-uppercase d-flex align-items-center gap-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Pendapatan <span class="badge bg-success-soft text-success rounded-pill"><i class="fas fa-arrow-up me-1"></i>8%</span>
                        </p>
                        <h3 class="fw-black mb-0 text-dark" style="font-size: 1.8rem;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="stat-icon-wrapper bg-success-soft text-success shadow-sm z-1">
                        <i class="fas fa-wallet fs-3"></i>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0 pb-4 px-4 z-1">
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold w-100">
                        Lihat Laporan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 animate-fade-in" style="animation-delay: 0.4s;">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="fas fa-box-open fa-5x text-warning"></i>
                    </div>
                    <div>
                        <p class="text-muted fw-bold mb-2 text-uppercase d-flex align-items-center gap-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                            Katalog Produk <span class="badge bg-warning-soft text-warning rounded-pill"><i class="fas fa-sync-alt me-1"></i>Up to date</span>
                        </p>
                        <h3 class="fw-black mb-0 text-dark" style="font-size: 2.2rem;">{{ $totalProducts ?? 0 }}</h3>
                    </div>
                    <div class="stat-icon-wrapper bg-warning-soft text-warning shadow-sm z-1">
                        <i class="fas fa-box-open fs-3"></i>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0 pb-4 px-4 z-1">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-warning rounded-pill fw-bold w-100 text-dark">
                        Kelola Katalog <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row animate-fade-in" style="animation-delay: 0.5s;">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h5 class="fw-black text-dark mb-0">Jalan Pintas</h5>
                <span class="text-muted small fw-semibold">Akses fitur yang sering digunakan</span>
            </div>
            
            <div class="row g-3">
                <div class="col-lg-3 col-md-6 col-6">
                    <a href="{{ route('admin.products.create') }}" class="text-decoration-none">
                        <div class="card action-card border-0 shadow-sm h-100 bg-white">
                            <div class="card-body p-4 text-center">
                                <div class="action-icon bg-danger text-white mx-auto mb-3 shadow-sm">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Produk Baru</h6>
                                <p class="text-muted small mb-0 d-none d-sm-block">Tambah lauk marinasi</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-6 col-6">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                        <div class="card action-card border-0 shadow-sm h-100 bg-white">
                            <div class="card-body p-4 text-center">
                                <div class="action-icon bg-primary text-white mx-auto mb-3 shadow-sm">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Cek Pesanan</h6>
                                <p class="text-muted small mb-0 d-none d-sm-block">Proses transaksi masuk</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 col-6">
                    <a href="{{ route('admin.reports.index') }}" class="text-decoration-none">
                        <div class="card action-card border-0 shadow-sm h-100 bg-white">
                            <div class="card-body p-4 text-center">
                                <div class="action-icon bg-success text-white mx-auto mb-3 shadow-sm">
                                    <i class="fas fa-file-excel"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Unduh Laporan</h6>
                                <p class="text-muted small mb-0 d-none d-sm-block">Ekspor data penjualan</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 col-6">
                    <a href="{{ route('admin.preview-site') }}" class="text-decoration-none">
                        <div class="card action-card border-0 shadow-sm h-100 bg-white">
                            <div class="card-body p-4 text-center">
                                <div class="action-icon bg-warning text-dark mx-auto mb-3 shadow-sm">
                                    <i class="fas fa-external-link-alt"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Lihat Website</h6>
                                <p class="text-muted small mb-0 d-none d-sm-block">Kunjungi toko depan</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* Styling Dasar & Tipografi */
    .fw-medium { font-weight: 500; }
    .fw-semibold { font-weight: 600; }
    .fw-black { font-weight: 900; }
    .z-1 { z-index: 1 !important; }

    /* Welcome Banner Premium */
    .welcome-banner {
        background: linear-gradient(135deg, #090d16 0%, #1c1917 40%, #311042 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: var(--shadow-lg) !important;
    }
    
    .backdrop-blur {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* Stat Cards (3D Hover Effect) */
    .stat-card {
        border-radius: var(--radius-lg);
        transition: var(--transition);
        border: 1px solid var(--border-color) !important;
        background: var(--card-bg) !important;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15) !important;
        border-color: rgba(99, 102, 241, 0.3) !important;
    }

    /* Background Soft Warna Tonalitas Elegan */
    .bg-primary-soft { background-color: rgba(99, 102, 241, 0.1) !important; }
    .bg-success-soft { background-color: rgba(16, 185, 129, 0.1) !important; }
    .bg-warning-soft { background-color: rgba(245, 158, 11, 0.1) !important; }

    /* Icon Wrappers (Pojok Kanan Kartu) */
    .stat-icon-wrapper {
        width: 55px;
        height: 55px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: var(--transition);
    }
    .stat-card:hover .stat-icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    /* Action Cards (Shortcut) */
    .action-card {
        border-radius: var(--radius-lg);
        transition: var(--transition);
        border: 1px solid var(--border-color) !important;
        background: var(--card-bg) !important;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.1) !important;
        border-color: rgba(99, 102, 241, 0.3) !important;
    }
    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: var(--transition);
    }
    .action-card:hover .action-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Kustomisasi Warna Spesifik */
    .text-primary { color: #2563eb !important; }
    .text-success { color: #10b981 !important; }
    .text-warning { color: #f59e0b !important; }
    
    .btn-outline-primary { border-color: rgba(59, 130, 246, 0.3) !important; color: #2563eb !important; background: transparent !important; }
    .btn-outline-primary:hover { background: #2563eb !important; border-color: #2563eb !important; color: #fff !important; }
    
    .btn-outline-success { border-color: rgba(16, 185, 129, 0.3) !important; color: #10b981 !important; background: transparent !important; }
    .btn-outline-success:hover { background: #10b981 !important; border-color: #10b981 !important; color: white !important;}
    
    .btn-outline-warning { border-color: rgba(245, 158, 11, 0.3) !important; color: #f59e0b !important; background: transparent !important; }
    .btn-outline-warning:hover { background: #f59e0b !important; border-color: #f59e0b !important; color: #fff !important;}

    /* Animasi Fade In */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        opacity: 0;
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Mobile responsive optimizations */
    @media (max-width: 575.98px) {
        .welcome-banner {
            padding: 1.5rem !important;
        }
        .welcome-banner h2 {
            font-size: 1.4rem !important;
        }
        .welcome-banner p {
            font-size: 0.85rem !important;
        }
        .stat-card .card-body {
            padding: 1.25rem 1rem !important;
        }
        .stat-card h3 {
            font-size: 1.6rem !important;
        }
        .stat-icon-wrapper {
            width: 45px !important;
            height: 45px !important;
            border-radius: 12px !important;
        }
        .stat-icon-wrapper i {
            font-size: 1.1rem !important;
        }
        .action-card .card-body {
            padding: 1rem 0.5rem !important;
        }
        .action-icon {
            width: 42px !important;
            height: 42px !important;
            font-size: 0.95rem !important;
            margin-bottom: 0.5rem !important;
        }
        .action-card h6 {
            font-size: 0.8rem !important;
        }
    }
</style>
@endpush
@endsection