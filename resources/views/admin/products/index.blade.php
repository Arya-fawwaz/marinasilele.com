@extends('admin.layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container-fluid p-0 animate-fade-in">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-black text-dark mb-1" style="font-weight: 900; letter-spacing: -0.5px;">Katalog <span style="color: #e67e22;">Produk</span></h2>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Kelola, pantau stok, dan perbarui harga produk marinasi Anda.</p>
        </div>
        
        <div class="d-flex gap-2">
            <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border border-light">
                <span class="input-group-text bg-white border-0 text-muted ps-3"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Cari produk...">
            </div>
            
            <a href="{{ route('admin.products.create') }}" class="btn btn-add-modern rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                <i class="fas fa-plus-circle"></i> Tambah Baru
            </a>
        </div>
    </div>

    <div class="table-responsive pb-5">
        <table class="table table-custom borderless align-middle">
            <thead>
                <tr>
                    <th width="5%" class="text-center text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">#</th>
                    <th width="35%" class="text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Info Produk</th>
                    <th width="15%" class="text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Harga</th>
                    <th width="15%" class="text-center text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Sisa Stok</th>
                    <th width="15%" class="text-center text-muted fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Status</th>
                    <th width="15%" class="text-end text-muted fw-bold text-uppercase pe-4" style="font-size: 0.75rem; letter-spacing: 1px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $p)
                <tr class="row-hover-lift" style="animation-delay: {{ $index * 0.05 }}s;">
                    <td class="text-center text-muted fw-semibold">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                    
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="product-thumbnail shadow-sm border border-light">
                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold text-dark" style="font-size: 1.05rem;">{{ $p->name }}</h6>
                                <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-tag me-1"></i> ID: PRD-{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="fw-bolder text-dark" style="font-size: 1rem;">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                    </td>
                    
                    <td class="text-center">
                        @if($p->stock > 10)
                            <div class="badge-modern bg-success-soft text-success">
                                <i class="fas fa-cubes me-1"></i> {{ $p->stock }} Pcs
                            </div>
                        @elseif($p->stock > 0)
                            <div class="badge-modern bg-warning-soft text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i> {{ $p->stock }} Pcs
                            </div>
                        @else
                            <div class="badge-modern bg-danger-soft text-danger">
                                <i class="fas fa-times-circle me-1"></i> Habis
                            </div>
                        @endif
                    </td>
                    
                    <td class="text-center">
                        @if($p->status == 'active')
                            <div class="d-inline-flex align-items-center gap-2 status-indicator">
                                <span class="dot-pulse bg-success"></span>
                                <span class="fw-bold text-success" style="font-size: 0.85rem;">Aktif</span>
                            </div>
                        @else
                            <div class="d-inline-flex align-items-center gap-2 status-indicator">
                                <span class="dot-static bg-secondary"></span>
                                <span class="fw-bold text-secondary" style="font-size: 0.85rem;">Nonaktif</span>
                            </div>
                        @endif
                    </td>
                    
                    <td class="text-end pe-3">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.edit', $p->id) }}" class="btn-action bg-primary-soft text-primary" title="Edit Produk">
                                <i class="fas fa-pen"></i>
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Peringatan: Apakah Anda yakin ingin menghapus produk ini secara permanen?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn-action bg-danger-soft text-danger border-0" title="Hapus Produk">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state-wrapper py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-box-open fa-3x"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Data Produk Kosong</h5>
                            <p class="text-muted mb-4">Anda belum menambahkan produk marinasi apapun ke dalam katalog.</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-add-modern rounded-pill px-4 fw-bold shadow-sm">
                                Mulai Tambah Produk
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-2">
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

    /* Tabel Custom: Floating Rows */
    .table-custom {
        border-collapse: separate;
        border-spacing: 0 12px; /* Memberikan jarak antar baris */
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
        padding: 1.25rem 1rem;
        border-top: 1px solid rgba(0,0,0,0.015);
        border-bottom: 1px solid rgba(0,0,0,0.015);
        vertical-align: middle;
    }

    /* Radius untuk sudut melengkung baris tabel */
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

    /* Efek Hover Baris */
    .row-hover-lift:hover {
        transform: translateY(-3px) scale(1.005);
        box-shadow: 0 15px 30px rgba(230, 126, 34, 0.08); /* Shadow aksen orange */
        border-color: transparent;
    }

    /* Thumbnail Produk */
    .product-thumbnail {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        overflow: hidden;
        background-color: #f8f9fa;
        flex-shrink: 0;
    }

    .product-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Tombol Aksi Bulat Modern */
    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .btn-action.bg-primary-soft:hover { background-color: #0d6efd; color: white !important; }
    .btn-action.bg-danger-soft:hover { background-color: #dc3545; color: white !important; }

    /* Badge Stok Modern */
    .badge-modern {
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        display: inline-block;
    }
    
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.15); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.2); }

    /* Indikator Status Denyut (Pulse) */
    .status-indicator {
        background-color: rgba(0,0,0,0.03);
        padding: 0.35rem 0.8rem;
        border-radius: 50px;
    }

    .dot-pulse, .dot-static {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .dot-pulse {
        box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7);
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(25, 135, 84, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
    }

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

    /* State Kosong */
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(0,0,0,0.03);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #adb5bd;
    }
</style>
@endpush

@push('scripts')
<script>
    // Inisialisasi Tooltip Bootstrap (Opsional, untuk tombol aksi)
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection