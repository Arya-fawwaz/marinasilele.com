@extends('layouts.app')

@section('title', 'Testimoni Pelanggan')

@section('content')
<div class="container py-5 animate-fade-in" style="animation-delay: 0.1s;">
    
    <div class="text-center mb-5">
        <span class="badge bg-warning-subtle text-warning-dark px-3 py-2 rounded-pill fw-bold text-uppercase tracking-wide mb-2">Suara Konsumen</span>
        <h2 class="fw-black text-dark display-6">Apa Kata <span style="color: #A81C1C;">Mereka?</span></h2>
        <p class="text-muted max-w-600 mx-auto mt-3">Lihat ulasan jujur dari pelanggan setia yang sudah menikmati kelezatan Lauk Marinasi Lele kami, atau bagikan pengalaman Anda sendiri!</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            @if(session('success'))
                <div class="alert alert-success rounded-4 shadow-sm border-0 mb-4 px-4 py-3 d-flex align-items-center">
                    <i class="fas fa-check-circle fs-4 me-3 text-success"></i>
                    <p class="mb-0 fw-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @auth
                <div class="card border-0 shadow-sm rounded-4 mb-5" style="border-top: 5px solid #FFB800;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold text-dark mb-4 text-center">Bagikan Pengalaman Anda</h5>
                        
                        <form action="{{ route('testimonials.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4 text-center">
                                <label class="form-label text-muted fw-semibold mb-2">Seberapa puas Anda?</label>
                                <div class="rating-stars-input justify-content-center">
                                    <input type="radio" name="rating" id="star5" value="5" required>
                                    <label for="star5" title="5 Bintang"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" id="star4" value="4">
                                    <label for="star4" title="4 Bintang"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" id="star3" value="3">
                                    <label for="star3" title="3 Bintang"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" id="star2" value="2">
                                    <label for="star2" title="2 Bintang"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" id="star1" value="1">
                                    <label for="star1" title="1 Bintang"><i class="fas fa-star"></i></label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <textarea name="comment" class="form-control form-control-lg rounded-3 bg-light border-0 focus-ring" rows="4" placeholder="Tuliskan ulasan jujur Anda di sini..." required></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-brand rounded-pill px-5 py-2.5 fw-bold shadow-sm">
                                    Kirim Ulasan <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert bg-light border-0 shadow-sm rounded-4 text-center p-4 mb-5">
                    <p class="mb-3 text-muted">Ingin membagikan pengalaman Anda?</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill px-4 fw-bold">Login untuk Memberikan Ulasan</a>
                </div>
            @endauth

            <h5 class="fw-bold text-dark mb-4">Ulasan Terbaru ({{ $testimonials->count() }})</h5>
            
            <div class="d-flex flex-column gap-4">
                @forelse($testimonials as $testi)
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center fw-bold text-danger me-3 overflow-hidden flex-shrink-0" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                    @if(optional($testi->user)->avatar)
                                        <img src="{{ asset($testi->user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr(optional($testi->user)->name ?? 'G', 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">{{ optional($testi->user)->name ?? 'Pengguna Anonim' }}</h6>
                                    <small class="text-muted">{{ $testi->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="ms-auto text-warning">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fas fa-star {{ $i <= $testi->rating ? '' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-secondary mb-0 lh-lg">"{{ $testi->comment }}"</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="far fa-comments fa-3x mb-3 opacity-50"></i>
                        <h6>Belum ada ulasan yang diberikan.</h6>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .max-w-600 { max-width: 600px; }
    .tracking-wide { letter-spacing: 1px; }
    .btn-brand { background: linear-gradient(135deg, #A81C1C, #8B1515); color: white; transition: all 0.3s; }
    .btn-brand:hover { background: linear-gradient(135deg, #8B1515, #A81C1C); transform: translateY(-2px); color: #FFB800; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .text-warning-dark { color: #856404 !important; }

    /* CSS Untuk Bintang Interaktif (Trik Flex Row-Reverse) */
    .rating-stars-input {
        display: flex;
        flex-direction: row-reverse;
        gap: 0.5rem;
    }
    .rating-stars-input input {
        display: none;
    }
    .rating-stars-input label {
        cursor: pointer;
        font-size: 2.5rem;
        color: #e4e5e9; /* Warna abu-abu redup */
        transition: color 0.2s ease-in-out, transform 0.2s ease;
    }
    /* Saat di-hover, bintang itu dan bintang sebelumnya (karena row-reverse) menyala */
    .rating-stars-input label:hover,
    .rating-stars-input label:hover ~ label,
    .rating-stars-input input:checked ~ label {
        color: #FFB800; /* Warna kuning emas */
    }
    .rating-stars-input label:hover {
        transform: scale(1.1);
    }
</style>
@endpush
@endsection