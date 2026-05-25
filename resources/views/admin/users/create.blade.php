@extends('admin.layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="container-fluid p-0 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Tambah Pengguna</h2>
            <p class="text-muted mb-0">Tambahkan akun baru untuk pelanggan atau administrator.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-4">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-exclamation-triangle fs-4 me-2"></i>
                <h5 class="fw-bold mb-0">Terdapat Kesalahan!</h5>
            </div>
            <ul class="mb-0 text-danger-emphasis">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-id-card me-2"></i> Informasi Profil</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg rounded-3" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">@</span>
                                    <input type="text" name="username" class="form-control form-control-lg border-start-0" placeholder="username_unik" required value="{{ old('username') }}">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3" placeholder="email@contoh.com" required value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control form-control-lg rounded-3" placeholder="0812xxxxxx" value="{{ old('phone') }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold text-secondary">Alamat Lengkap</label>
                                <textarea name="address" class="form-control rounded-3" rows="3" placeholder="Masukkan alamat lengkap...">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-user-shield me-2"></i> Keamanan & Hak Akses</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Role / Peran <span class="text-danger">*</span></label>
                            <select name="role" class="form-select form-select-lg rounded-3">
                                <option value="customer" selected>Customer (Pelanggan)</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-lg rounded-3" placeholder="Minimal 8 karakter" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg rounded-3" placeholder="Ulangi password" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm">
                    <i class="fas fa-save me-2"></i> Simpan Pengguna
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .text-primary { color: #e67e22 !important; }
    .btn-primary { background-color: #e67e22; border-color: #e67e22; }
    .btn-primary:hover { background-color: #d35400; border-color: #d35400; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(230,126,34,0.3); }
    
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards; }
</style>
@endpush
@endsection