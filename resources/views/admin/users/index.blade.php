@extends('admin.layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid p-0 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Manajemen Pengguna</h2>
            <p class="text-muted mb-0">Kelola data akses pelanggan dan administrator.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
            <i class="fas fa-user-plus me-2"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle fs-4 me-3"></i> 
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase">Pengguna</th>
                            <th class="py-3 text-uppercase">Kontak info</th>
                            <th class="py-3 text-uppercase text-center">Role</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($users as $user)
                        <tr class="transition-all">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary-soft text-primary d-flex align-items-center justify-content-center fw-bold me-3 shadow-sm" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">@ {{ $user->username }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="text-dark mb-1">
                                    <i class="fas fa-envelope text-muted me-2" style="width: 15px;"></i> {{ $user->email }}
                                </div>
                                <div class="text-muted small">
                                    <i class="fas fa-phone-alt text-muted me-2" style="width: 15px;"></i> {{ $user->phone ?? 'Belum diatur' }}
                                </div>
                            </td>

                            <td class="text-center">
                                @if(strtolower($user->role) == 'admin')
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill border border-danger-subtle">
                                        <i class="fas fa-user-shield me-1"></i> Admin
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill border border-secondary-subtle">
                                        <i class="fas fa-user me-1"></i> Customer
                                    </span>
                                @endif
                            </td>

                            <td class="pe-4 text-end">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light text-primary rounded-circle action-btn" title="Edit Pengguna">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Peringatan: Menghapus pengguna ini tidak dapat dibatalkan. Lanjutkan?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-circle action-btn ms-1" title="Hapus Pengguna">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="fas fa-users-slash fa-3x text-muted mb-3 opacity-50"></i>
                                <p class="text-muted fw-medium mb-0">Belum ada data pengguna yang terdaftar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($users, 'hasPages') && $users->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
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
        background-color: var(--card-bg) !important;
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
        box-shadow: 0 10px 20px rgba(201, 42, 42, 0.08) !important;
        border-color: rgba(201, 42, 42, 0.2) !important;
    }

    /* Soft Avatar */
    .bg-primary-soft {
        background-color: rgba(201, 42, 42, 0.08) !important;
        color: var(--primary) !important;
    }

    /* Action Buttons */
    .action-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        border: 1px solid var(--border-color);
        border-radius: 10px !important;
    }
    
    .action-btn.text-primary { color: #0b5ed7 !important; background: rgba(13, 110, 253, 0.06) !important; }
    .action-btn.text-primary:hover { background-color: #0b5ed7 !important; color: white !important; border-color: #0b5ed7 !important; }
    
    .action-btn.text-danger { color: #dc2626 !important; background: rgba(220, 53, 69, 0.06) !important; }
    .action-btn.text-danger:hover { background-color: #dc2626 !important; color: white !important; border-color: #dc2626 !important; }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endpush
@endsection