@extends('admin.layouts.admin')

@section('title', 'Daftar Pesanan Masuk')

@section('content')
<div class="container-fluid p-0 animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Manajemen <span style="color: #A81C1C;">Pesanan</span></h2>
            <p class="text-muted small mt-1">Pantau dan kelola semua pesanan pelanggan di sini.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="border-0 text-uppercase py-3 ps-3 rounded-start">No. Order</th>
                            <th class="border-0 text-uppercase py-3">Tanggal</th>
                            <th class="border-0 text-uppercase py-3">Pelanggan</th>
                            <th class="border-0 text-uppercase py-3">Total Tagihan</th>
                            <th class="border-0 text-uppercase py-3">Pembayaran</th>
                            <th class="border-0 text-uppercase py-3">Status</th>
                            <th class="border-0 text-uppercase py-3 text-center rounded-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($orders as $row)
                        <tr>
                            <td class="ps-3 py-3 border-bottom border-light fw-bold text-dark">#{{ $row->order_number }}</td>
                            <td class="py-3 border-bottom border-light text-muted small">{{ $row->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-3 border-bottom border-light fw-medium">{{ optional($row->user)->name ?? 'Guest' }}</td>
                            <td class="py-3 border-bottom border-light fw-black text-danger">Rp {{ number_format($row->total_amount ?? $row->total_price, 0, ',', '.') }}</td>
                            
                            {{-- FIX SENYAWA: Deteksi Pembayaran murni dari kolom tunggal 'status' --}}
                            <td class="py-3 border-bottom border-light">
                                @if(strtolower($row->status) == 'success' || strtolower($row->status) == 'completed')
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold"><i class="fas fa-check me-1"></i> Lunas</span>
                                @elseif(strtolower($row->status) == 'awaiting_confirmation')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm fw-bold animate-pulse"><i class="fas fa-bell me-1"></i> Klaim COD</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold"><i class="fas fa-clock me-1"></i> Belum Bayar</span>
                                @endif
                            </td>
                            
                            {{-- Status Alur Pengiriman/Proses Makanan --}}
                            <td class="py-3 border-bottom border-light">
                                @php
                                    $statusKey = strtolower($row->status);
                                    $statusBadge = [
                                        'pending' => 'warning', 
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'completed' => 'success', 
                                        'success' => 'success',
                                        'awaiting_confirmation' => 'info',
                                        'cancelled' => 'danger'
                                    ][$statusKey] ?? 'secondary';

                                    $statusDisplay = [
                                        'success' => 'COMPLETED'
                                    ][$statusKey] ?? strtoupper($row->status);
                                @endphp
                                <span class="badge bg-{{ $statusBadge }} px-3 py-2 rounded-pill text-uppercase fw-bold" style="font-size: 0.7rem;">
                                    {{ $statusDisplay }}
                                </span>
                            </td>
                            
                            <td class="py-3 border-bottom border-light text-center">
                                <a href="{{ route('admin.orders.show', $row->id) }}" class="btn btn-sm text-white rounded-pill px-4 fw-bold shadow-sm" style="background-color: #A81C1C;">
                                    Detail <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 border-0 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                <h5>Belum Ada Pesanan Masuk</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if(method_exists($orders, 'links'))
                <div class="mt-4 d-flex justify-content-end">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .fw-black { font-weight: 900; }
    
    /* Table Floating Rows */
    .table {
        border-collapse: separate !important;
        border-spacing: 0 12px !important;
        margin-top: -12px;
    }

    .table thead th {
        border-bottom: none !important;
        padding-bottom: 0.5rem !important;
    }

    .table tbody tr {
        background-color: #ffffff !important;
        box-shadow: var(--shadow-sm) !important;
        border-radius: var(--radius-lg);
        transition: var(--transition) !important;
    }

    .table tbody tr td {
        padding: 1.25rem 1rem !important;
        border-top: 1px solid var(--border-color) !important;
        border-bottom: 1px solid var(--border-color) !important;
    }

    .table tbody tr td:first-child {
        border-left: 1px solid var(--border-color) !important;
        border-top-left-radius: var(--radius-lg) !important;
        border-bottom-left-radius: var(--radius-lg) !important;
    }

    .table tbody tr td:last-child {
        border-right: 1px solid var(--border-color) !important;
        border-top-right-radius: var(--radius-lg) !important;
        border-bottom-right-radius: var(--radius-lg) !important;
    }

    .table tbody tr:hover {
        transform: translateY(-3px) scale(1.002);
        box-shadow: var(--shadow-premium) !important;
    }

    @keyframes pulse { 
        0% { opacity: 0.7; transform: scale(0.98); } 
        50% { opacity: 1; transform: scale(1); } 
        100% { opacity: 0.7; transform: scale(0.98); } 
    }
    .animate-pulse { animation: pulse 2s infinite ease-in-out; }
    
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }
</style>
@endpush
@endsection