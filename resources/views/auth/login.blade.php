@extends('layouts.app')

@section('title', 'Masuk Akun - Marinasi Lele')

@push('styles')
<style>
    .auth-wrapper {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px rgba(168, 28, 28, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.6);
        width: 100%;
        max-width: 450px;
        position: relative;
        overflow: hidden;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(to right, #A81C1C, #FFB800);
    }

    .auth-icon-header {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(168, 28, 28, 0.1), rgba(255, 184, 0, 0.1));
        color: #A81C1C;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        border: 2px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 8px 16px rgba(168, 28, 28, 0.08);
    }

    .form-control-custom {
        background-color: #f8f9fa;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        padding: 0.8rem 1.2rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        background-color: #ffffff;
        border-color: #FFB800;
        box-shadow: 0 0 0 4px rgba(255, 184, 0, 0.15);
    }

    .btn-brand-submit {
        background: linear-gradient(135deg, #A81C1C, #8B1515);
        color: #ffffff;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 0.85rem 1.5rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(168, 28, 28, 0.25);
        border: none;
    }

    .btn-brand-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(168, 28, 28, 0.35);
        color: #FFB800;
    }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.6s ease forwards; }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card p-4 p-md-5 animate-fade-in">
        
        <div class="auth-icon-header">
            <i class="fas fa-user-lock fa-2x"></i>
        </div>

        <div class="text-center mb-4">
            <h3 class="fw-bolder text-dark mb-2">Selamat <span style="color: #A81C1C;">Datang</span></h3>
            <p class="text-muted small">Masuk ke akun Anda untuk melanjutkan pesanan.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success small py-2 rounded-3 border-0">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 1px;">Alamat Email</label>
                <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="password" class="form-label fw-bold text-secondary small text-uppercase mb-0" style="letter-spacing: 1px;">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none small fw-semibold text-muted" href="{{ route('password.request') }}">
                            Lupa Sandi?
                        </a>
                    @endif
                </div>
                <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 form-check">
                <input class="form-check-input shadow-sm" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label small fw-medium text-secondary" for="remember_me">
                    Ingat sesi saya
                </label>
            </div>

            <div class="d-grid gap-3">
                <button type="submit" class="btn btn-brand-submit text-uppercase">
                    Masuk Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </button>
                
                <div class="position-relative text-center my-2">
                    <hr class="border-secondary opacity-25">
                    <span class="bg-white px-3 small fw-bold text-muted text-uppercase position-absolute top-50 start-50 translate-middle" style="letter-spacing: 1px;">Atau</span>
                </div>

                <a href="{{ route('register') }}" class="btn btn-outline-dark rounded-pill py-2 fw-bold" style="border-color: rgba(168, 28, 28, 0.2); color: #A81C1C;">
                    Buat Akun Baru
                </a>
            </div>
        </form>
    </div>
</div>
@endsection