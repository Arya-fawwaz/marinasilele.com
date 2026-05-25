@extends('layouts.app')

@section('title', 'Daftar Akun - Marinasi Lele')

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
            <i class="fas fa-user-plus fa-2x"></i>
        </div>

        <div class="text-center mb-4">
            <h3 class="fw-bolder text-dark mb-2">Daftar <span style="color: #A81C1C;">Akun Baru</span></h3>
            <p class="text-muted small">Gabung bersama kami untuk menikmati hidangan praktis lezat.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 1px;">Nama Lengkap</label>
                <input id="name" type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama Anda">
                @error('name')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 1px;">Username</label>
                <input id="username" type="text" class="form-control form-control-custom @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Pilih username unik (tanpa spasi)">
                @error('username')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 1px;">Alamat Email</label>
                <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 1px;">Kata Sandi</label>
                <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                @error('password')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 1px;">Konfirmasi Sandi</label>
                <input id="password_confirmation" type="password" class="form-control form-control-custom" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi">
            </div>

            <div class="d-grid gap-3">
                <button type="submit" class="btn btn-brand-submit text-uppercase">
                    Daftar Sekarang <i class="fas fa-check-circle ms-2"></i>
                </button>
                
                <div class="position-relative text-center my-2">
                    <hr class="border-secondary opacity-25">
                    <span class="bg-white px-3 small fw-bold text-muted text-uppercase position-absolute top-50 start-50 translate-middle" style="letter-spacing: 1px;">Atau</span>
                </div>

                <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill py-2 fw-bold" style="border-color: rgba(168, 28, 28, 0.2); color: #A81C1C;">
                    Masuk ke Akun
                </a>
            </div>
        </form>
    </div>
</div>
@endsection