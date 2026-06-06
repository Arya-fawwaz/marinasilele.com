@extends('admin.layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container-fluid p-0 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit Pengguna</h2>
            <p class="text-muted mb-0">Perbarui informasi profil atau kata sandi <strong>{{ $user->name }}</strong>.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Batal
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

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary-soft text-primary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 50px; height: 50px; font-size: 1.5rem; background-color: rgba(168, 28, 28, 0.08);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Informasi Profil</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg rounded-3" required value="{{ old('name', $user->name) }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">@</span>
                                    <input type="text" name="username" class="form-control form-control-lg border-start-0" required value="{{ old('username', $user->username) }}">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-3" required value="{{ old('email', $user->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control form-control-lg rounded-3" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold text-secondary">Alamat Lengkap</label>
                                <textarea name="address" class="form-control rounded-3" rows="3">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-user-shield me-2 text-danger"></i> Keamanan & Hak Akses</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Role / Peran <span class="text-danger">*</span></label>
                            <select name="role" class="form-select form-select-lg rounded-3">
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer (Pelanggan)</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </div>

                        <hr class="my-4 opacity-25">
                        
                        <div class="alert alert-warning border-0 rounded-3 small">
                            <i class="fas fa-info-circle me-1"></i> Kosongkan kolom password di bawah ini jika Anda <strong>tidak ingin</strong> mengubah kata sandinya.
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Password Baru</label>
                            <input type="password" name="password" class="form-control form-control-lg rounded-3" placeholder="Ketik kata sandi baru">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg rounded-3" placeholder="Ulangi kata sandi baru">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm py-3 text-white">
                    <i class="fas fa-sync-alt me-2"></i> Update Pengguna
                </button>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endpush
@endsection