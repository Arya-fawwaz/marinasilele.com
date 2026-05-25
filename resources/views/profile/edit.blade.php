@extends('layouts.app')

@section('title', 'Pengaturan Profil - Marinasi Lele')

@section('content')
<div class="container py-5 animate-fade-in" style="animation-delay: 0.1s;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <h2 class="fw-black text-dark mb-4"><i class="fas fa-user-cog text-danger me-2"></i> Pengaturan <span class="text-danger">Profil</span></h2>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center">
                    <i class="fas fa-check-circle fs-4 me-3 text-success"></i>
                    <span class="fw-medium text-dark">{{ session('success') }}</span>
                </div>
            @endif

            <div class="row g-4">
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white border">
                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                                @csrf
                                @method('PATCH')
                                
                                <div class="position-relative mb-3 d-inline-block">
                                    <div class="shadow-sm border" style="width: 140px; height: 140px; border-radius: 50%; overflow: hidden; border: 4px solid #fff;">
                                        {{-- FIX: Jalur src disamakan dengan navbar agar tidak pecah/broken link --}}
                                        <img id="avatarPreview" src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?background=FFB800&color=fff&name=' . urlencode(auth()->user()->name) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-danger text-white rounded-circle d-flex align-items-center justify-content-center shadow cursor-pointer" style="width: 38px; height: 38px; border: 3px solid #fff;">
                                        <i class="fas fa-camera small"></i>
                                    </label>
                                    <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </div>
                                
                                <h5 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h5>
                                <p class="text-muted small mb-3 text-uppercase fw-bold opacity-75" style="letter-spacing: 0.5px;">{{ auth()->user()->role }}</p>
                                
                                <button type="submit" class="btn btn-danger rounded-pill btn-sm px-4 py-2 fw-bold shadow-sm d-none" id="saveAvatarBtn" style="background-color: #A81C1C;">Simpan Foto</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 bg-white h-100 border">
                        <div class="card-body p-4 p-md-5">
                            
                            <form action="{{ route('profile.update') }}" method="POST" class="mb-5">
                                @csrf
                                @method('PATCH')
                                
                                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="fas fa-id-card text-muted me-2"></i> Ubah Biodata</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control bg-light border-0 p-3 rounded-3 focus-ring" value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted">Alamat Email</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 p-3 rounded-3 focus-ring" value="{{ auth()->user()->email }}" required>
                                </div>
                                
                                <button type="submit" class="btn text-white rounded-pill px-4 py-2.5 fw-bold shadow-sm" style="background-color: #A81C1C;">Simpan Perubahan</button>
                            </form>

                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="fas fa-key text-muted me-2"></i> Perbarui Kata Sandi</h5>
                                
                                @if($errors->any())
                                    <div class="alert alert-danger border-0 small rounded-3 p-2 mb-3">
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Password Sekarang</label>
                                    <input type="password" name="current_password" class="form-control bg-light border-0 p-3 rounded-3 focus-ring" placeholder="••••••••" required>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-bold text-muted">Password Baru</label>
                                        <input type="password" name="password" class="form-control bg-light border-0 p-3 rounded-3 focus-ring" placeholder="Min. 8 karakter" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-bold text-muted">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control bg-light border-0 p-3 rounded-3 focus-ring" placeholder="Ketik ulang password" required>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-dark rounded-pill px-4 py-2.5 fw-bold shadow-sm">Ganti Password</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .fw-black { font-weight: 900; }
    .cursor-pointer { cursor: pointer; }
    .focus-ring:focus {
        border-color: #A81C1C !important;
        box-shadow: 0 0 0 0.25rem rgba(168, 28, 28, 0.15) !important;
        background-color: #fff !important;
    }
    .transition-all { transition: all 0.2s ease; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { opacity: 0; animation: fadeInUp 0.5s ease forwards; }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
                var saveBtn = document.getElementById('saveAvatarBtn');
                saveBtn.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection