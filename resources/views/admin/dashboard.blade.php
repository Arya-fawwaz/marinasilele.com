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
                    <a href="{{ route('home') }}" target="_blank" class="text-decoration-none">
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
        background: linear-gradient(135deg, #1A1A1A 0%, #A81C1C 100%);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .backdrop-blur {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* Stat Cards (3D Hover Effect) */
    .stat-card {
        border-radius: 1.25rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0,0,0,0.03) !important;
    }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        border-color: rgba(0,0,0,0.08) !important;
    }

    /* Background Soft Warna Tonalitas Elegan */
    .bg-primary-soft { background-color: rgba(52, 152, 219, 0.1); }
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.12); }
    .bg-warning-soft { background-color: rgba(230, 126, 34, 0.1); } /* Sinkronisasi ke warna oranye soft */

    /* Icon Wrappers (Pojok Kanan Kartu) */
    .stat-icon-wrapper {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    .stat-card:hover .stat-icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    /* Action Cards (Shortcut) */
    .action-card {
        border-radius: 1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04) !important;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.06) !important;
        border-color: rgba(168, 28, 28, 0.2) !important;
    }
    .action-icon {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }
    .action-card:hover .action-icon {
        transform: scale(1.15);
    }

    /* Kustomisasi Warna Spesifik */
    .text-primary { color: #3498db !important; }
    .text-success { color: #2ecc71 !important; }
    .text-warning { color: #e67e22 !important; }
    
    .btn-outline-primary { border-color: rgba(52, 152, 219, 0.3); }
    .btn-outline-primary:hover { background-color: #3498db; border-color: #3498db; }
    
    .btn-outline-success { border-color: rgba(46, 204, 113, 0.3); }
    .btn-outline-success:hover { background-color: #2ecc71; border-color: #2ecc71; color: white;}
    
    .btn-outline-warning { border-color: rgba(230, 126, 34, 0.3); color: #e67e22; }
    .btn-outline-warning:hover { background-color: #e67e22; border-color: #e67e22; color: #fff;}

    /* Animasi Fade In */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
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