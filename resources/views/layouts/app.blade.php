<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Marinasi Lele - Lauk Praktis Nusantara')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --brand-primary: #A81C1C;    /* Merah Keraton */
            --brand-secondary: #FFB800;  /* Kuning Emas */
            --brand-dark: #1A1A1A;
            --text-muted: #6c757d;
            --bg-body: #FCF9F5;
            --shadow-smooth: 0 10px 30px rgba(0, 0, 0, 0.04);
            --shadow-premium: 0 15px 35px rgba(168, 28, 28, 0.06);
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #2D2D2D;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        main {
            flex: 1;
        }

        /* --- PREMIUM NAVBAR WITH BLUR EFFECT --- */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.8);
            padding: 0.85rem 0;
            transition: var(--transition-smooth);
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 1.5rem;
            color: var(--brand-dark) !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand .brand-icon {
            color: var(--brand-secondary);
            margin-right: 0.6rem;
            filter: drop-shadow(0 2px 5px rgba(255, 184, 0, 0.3));
        }

        .nav-link {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-muted) !important;
            margin: 0 0.6rem;
            padding: 0.5rem 0.2rem !important;
            position: relative;
            transition: var(--transition-smooth);
        }

        .nav-link:hover, .nav-link.active {
            color: var(--brand-primary) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -2px;
            left: 50%;
            background: linear-gradient(to right, var(--brand-primary), var(--brand-secondary));
            transition: var(--transition-smooth);
            transform: translateX(-50%);
            border-radius: 10px;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }

        /* Ikon Kantong Belanja Premium */
        .cart-icon-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background-color: #f7f7f7;
            border-radius: 14px;
            color: var(--brand-dark);
            transition: var(--transition-smooth);
            border: 1px solid rgba(0,0,0,0.02);
        }
        
        .cart-icon-wrapper:hover {
            background-color: var(--brand-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(168, 28, 28, 0.2);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.4em 0.6em;
            border: 2px solid white;
            box-shadow: 0 3px 8px rgba(220, 53, 69, 0.3);
        }

        /* --- DROPDOWN PROFIL SINGLE LINE --- */
        .dropdown-user-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            padding: 0.4rem 1.2rem 0.4rem 0.4rem;
            border-radius: 50px;
            transition: var(--transition-smooth);
            box-shadow: var(--shadow-smooth);
            flex-shrink: 0;
        }

        .dropdown-user-wrapper:hover {
            background: #fafafa;
            border-color: rgba(168, 28, 28, 0.2);
            transform: translateY(-1px);
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--brand-secondary), #E6A400);
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 6px rgba(255, 184, 0, 0.15);
            overflow: hidden;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info-text-single {
            font-weight: 700;
            font-size: 0.9rem;
            color: #2D2D2D;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dropdown-menu-custom {
            border: 1px solid rgba(0,0,0,0.03) !important;
            box-shadow: var(--shadow-premium) !important;
            padding: 0.5rem !important;
        }

        .dropdown-item-custom {
            border-radius: 10px;
            padding: 0.6rem 1rem !important;
            font-weight: 600;
            font-size: 0.9rem;
            color: #4A4A4A;
            transition: var(--transition-smooth);
        }

        .dropdown-item-custom:hover {
            background-color: rgba(168, 28, 28, 0.05) !important;
            color: var(--brand-primary) !important;
        }

        /* Tombol Otentikasi */
        .btn-login-outline {
            color: var(--brand-dark);
            border: 2px solid var(--brand-dark);
            font-weight: 700;
            border-radius: 50px;
            transition: var(--transition-smooth);
        }

        .btn-login-outline:hover {
            background-color: var(--brand-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-register-solid {
            background: linear-gradient(135deg, var(--brand-primary), #8B1515);
            color: white;
            font-weight: 700;
            border-radius: 50px;
            border: none;
            box-shadow: 0 5px 15px rgba(168, 28, 28, 0.2);
            transition: var(--transition-smooth);
        }

        .btn-register-solid:hover {
            background: linear-gradient(135deg, #8B1515, var(--brand-primary));
            color: var(--brand-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(168, 28, 28, 0.3);
        }

        /* --- FOOTER STYLING --- */
        .footer-custom {
            background: linear-gradient(180deg, #1A1A1A 0%, #111111 100%);
            color: #E0E0E0;
            padding: 4.5rem 0 2rem 0;
            margin-top: 5rem;
            position: relative;
            border-top: 4px solid var(--brand-primary);
        }

        .footer-custom::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(to right, transparent, var(--brand-secondary), transparent);
        }

        .footer-brand {
            font-weight: 900;
            font-size: 1.6rem;
            color: #ffffff;
        }

        .social-circle-btn {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition-smooth);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-circle-btn:hover {
            background: var(--brand-primary);
            color: var(--brand-secondary);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 10px 20px rgba(168, 28, 28, 0.4);
            border-color: transparent;
        }

        /* --- STYLING KHUSUS DROPDOWN WHATSAPP FOOTER --- */
        .dropdown-menu-wa {
            background-color: #1A1A1A;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            padding: 0.5rem;
        }
        
        .dropdown-menu-wa .dropdown-item {
            color: #E0E0E0;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: var(--transition-smooth);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .dropdown-menu-wa .dropdown-item:hover {
            background-color: rgba(255, 184, 0, 0.1);
            color: var(--brand-secondary);
        }
        @media (max-width: 991.98px) {
            .navbar-brand {
                font-size: 1.25rem;
            }
            .cart-icon-wrapper {
                width: 38px;
                height: 38px;
                border-radius: 10px;
            }
            .cart-icon-wrapper i {
                font-size: 0.95rem !important;
            }
            .dropdown-user-wrapper {
                padding: 0.3rem;
                gap: 0;
            }
            .user-avatar {
                width: 32px;
                height: 32px;
            }
        }

        /* --- MOBILE BOTTOM NAVIGATION BAR --- */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 1040;
            padding-bottom: safe;
            transition: var(--transition-smooth);
        }

        .mobile-bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            height: 100%;
            text-decoration: none;
            color: #8E8E93;
            font-size: 0.65rem;
            font-weight: 700;
            transition: var(--transition-smooth);
            position: relative;
        }

        .mobile-bottom-nav-item i {
            font-size: 1.2rem;
            margin-bottom: 2px;
            transition: var(--transition-smooth);
        }

        .mobile-bottom-nav-item.active {
            color: var(--brand-primary);
        }

        .mobile-bottom-nav-item.active i {
            color: var(--brand-primary);
        }

        .mobile-cart-badge {
            position: absolute;
            top: 4px;
            right: 25%;
            font-size: 0.6rem;
            padding: 0.2em 0.5em;
            border-radius: 50rem;
            background-color: var(--brand-primary);
            color: white;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 991.98px) {
            body {
                padding-bottom: 60px;
            }
            .navbar-collapse {
                background: white;
                border-radius: 15px;
                padding: 1rem;
                box-shadow: var(--shadow-smooth);
                margin-top: 0.5rem;
            }
            .container {
                padding-left: 16px;
                padding-right: 16px;
            }
            .row.g-4 {
                --bs-gutter-y: 1rem;
                --bs-gutter-x: 1rem;
            }
            .card {
                border-radius: 16px !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    @if(auth()->check() && auth()->user()->isAdmin() && session('admin_view_mode') === 'user')
        <div class="bg-warning text-dark text-center py-2 px-3 fw-bold d-flex justify-content-center align-items-center gap-2 border-bottom border-warning shadow-sm position-relative d-print-none" style="z-index: 1050; font-size: 0.9rem;">
            <i class="fas fa-user-shield"></i>
            <span>Mode Administrator: Anda sedang melihat tampilan website pengguna.</span>
            <a href="{{ route('home') }}?view=admin" class="btn btn-dark btn-sm rounded-pill px-3 py-1 fw-bold text-white border-0 transition-all hover-scale ms-2" style="background-color: #1a1a1a;">
                Kembali ke Admin Panel <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    @endif

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top d-print-none">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-fish brand-icon"></i>
                <span>Marinasi<span style="color: var(--brand-primary);">Lele</span></span>
            </a>

            <div class="d-flex align-items-center gap-2 gap-md-3 order-lg-3">
                @php
                    $cartCount = 0;
                    if(auth()->check()) {
                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                    }
                @endphp

                <a href="{{ route('cart.index') }}" class="cart-icon-wrapper text-decoration-none" title="Buka Keranjang">
                    <i class="fas fa-shopping-bag fs-5"></i>
                    @if($cartCount > 0)
                        <span class="badge bg-danger rounded-pill cart-badge shadow-sm">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <div class="dropdown user-dropdown">
                        <a class="text-decoration-none dropdown-user-wrapper text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar shadow-sm">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset(auth()->user()->avatar) }}" alt="Foto Profil">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="d-none d-md-block user-info-text-single">
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-muted" style="font-size: 0.65rem;"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 rounded-4 mt-3 dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2 text-muted"></i> Pengaturan Profil</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('orders.index') }}"><i class="fas fa-box me-2 text-muted"></i> Status Pesanan</a></li>
                            <li><hr class="dropdown-divider my-1 opacity-50"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item dropdown-item-custom fw-bold text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar Akun</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login-outline rounded-pill px-4 py-2 d-none d-md-block btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-register-solid rounded-pill px-4 py-2 d-none d-md-block btn-sm">Daftar</a>
                @endauth

                <button class="navbar-toggler border-0 shadow-none p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="bg-light p-2 rounded-3">
                        <i class="fas fa-bars fs-5 text-dark"></i>
                    </div>
                </button>
            </div>

            <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center text-lg-start mt-3 mt-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('testimonials.*') ? 'active' : '' }}" href="{{ route('testimonials.index') }}">Testimoni</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Riwayat Pesanan</a></li>
                    @guest
                        <li class="nav-item d-md-none mt-3">
                            <a href="{{ route('login') }}" class="btn btn-login-outline w-100 py-2.5 rounded-pill">Login</a>
                        </li>
                        <li class="nav-item d-md-none mt-2">
                            <a href="{{ route('register') }}" class="btn btn-register-solid w-100 py-2.5 text-white rounded-pill">Daftar</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-custom text-center d-print-none">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h4 class="footer-brand mb-3 d-flex justify-content-center align-items-center gap-2">
                        <i class="fas fa-fish text-warning"></i> Marinasi Lele Nusantara
                    </h4>
                    <p class="text-white-50 small mb-4 lh-lg">Pelopor produk lauk marinasi ikan segar higienis siap goreng. Dibumbui menggunakan resep warisan kuno Nusantara, meresap sempurna, tanpa bahan pengawet kimia berbahaya.</p>
                    
                    <div class="d-flex justify-content-center gap-3 mb-5">
                        
                        <div class="dropdown">
                            <a href="#" class="social-circle-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Hubungi via WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-center dropdown-menu-wa text-start mt-2">
                                <li><h6 class="dropdown-header text-warning fw-bold"><i class="fas fa-headset me-2"></i>Pilih Admin CS:</h6></li>
                                <li><hr class="dropdown-divider border-secondary opacity-25 mb-2"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="https://wa.me/6287824877346" target="_blank">
                                        <i class="fab fa-whatsapp fs-5 text-success me-3"></i> CS 1 (xxxx-7346)
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="https://wa.me/6285935120151" target="_blank">
                                        <i class="fab fa-whatsapp fs-5 text-success me-3"></i> CS 2 (xxxx-0151)
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="https://wa.me/6282211316507" target="_blank">
                                        <i class="fab fa-whatsapp fs-5 text-success me-3"></i> CS 3 (xxxx-6507)
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <a href="#" class="social-circle-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-circle-btn"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary border-opacity-20 pt-4 opacity-70" style="font-size: 0.8rem; font-weight: 500; letter-spacing: 0.5px;">
                &copy; {{ date('Y') }} Marinasi Lele by MarinasiNusantara. Seluruh Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>

    <!-- MOBILE BOTTOM NAVIGATION -->
    <div class="mobile-bottom-nav d-lg-none d-print-none">
        <a href="{{ route('home') }}" class="mobile-bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('products.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fas fa-fish"></i>
            <span>Produk</span>
        </a>
        <a href="{{ route('cart.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('cart.index') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i>
            @php
                $mobileCartCount = 0;
                if(auth()->check()) {
                    $mobileCartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                }
            @endphp
            @if($mobileCartCount > 0)
                <span class="mobile-cart-badge">{{ $mobileCartCount }}</span>
            @endif
            <span>Keranjang</span>
        </a>
        <a href="{{ route('orders.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Pesanan</span>
        </a>
        @auth
            <a href="{{ route('profile.edit') }}" class="mobile-bottom-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span>Profil</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="mobile-bottom-nav-item {{ request()->routeIs('login') || request()->routeIs('register') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span>Masuk</span>
            </a>
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>