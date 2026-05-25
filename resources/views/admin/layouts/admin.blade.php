<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6; /* Warna abu-abu terang yang modern */
            overflow-x: hidden;
        }

        /* --- Sidebar Modern --- */
        .admin-sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #1e1e2d; /* Dark theme elegan */
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem;
            color: #fff;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991.98px) {
            .sidebar-brand {
                justify-content: space-between;
            }
        }

        .sidebar-brand span { color: #e67e22; }

        .sidebar-menu {
            padding: 1rem 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            color: #9899ac;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0.2rem 1rem;
            border-radius: 0.5rem;
        }

        .sidebar-link i {
            width: 30px;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sidebar-link.active {
            background-color: #e67e22;
            color: #fff;
            box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* --- Main Content Area --- */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- Topbar Modern --- */
        .admin-topbar {
            height: 70px;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            z-index: 999;
        }

        .admin-content {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Responsive Behavior */
        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 998;
                transition: opacity 0.3s ease;
            }
            .sidebar-overlay.show {
                display: block !important;
            }
        }
        @media (max-width: 767.98px) {
            .admin-content {
                padding: 1rem;
            }
            .admin-topbar {
                padding: 0 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <div>
                <i class="fas fa-fish me-2" style="color: #e67e22;"></i>
                Marinasi<span>Admin</span>
            </div>
            <button class="btn text-white d-lg-none p-0 border-0" id="sidebarClose" type="button">
                <i class="fas fa-times fs-5"></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <p class="text-uppercase text-muted small fw-bold px-4 mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i> Kelola Produk
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Pesanan Masuk
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data Pengguna
            </a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> Laporan
            </a>

            <p class="text-uppercase text-muted small fw-bold px-4 mt-4 mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Situs</p>
            <a href="{{ route('home') }}?view=user" target="_blank" class="sidebar-link">
                <i class="fas fa-external-link-alt"></i> Lihat Website
            </a>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-light d-lg-none shadow-none border-0 p-2" id="sidebarToggle" type="button">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">@yield('title')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                    <p class="mb-0 text-muted" style="font-size: 0.75rem;">Administrator</p>
                </div>
                
                {{-- 👑 PERBAIKAN FITUR FOTO PROFIL ADMIN REAL-TIME 👑 --}}
                <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm overflow-hidden" style="width: 40px; height: 40px; background-color: #e67e22;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Foto Admin" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
            </div>
        </header>

        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.querySelector(".admin-sidebar");
            const toggleBtn = document.getElementById("sidebarToggle");
            const closeBtn = document.getElementById("sidebarClose");
            const overlay = document.getElementById("sidebarOverlay");

            function toggleSidebar() {
                sidebar.classList.toggle("show");
                overlay.classList.toggle("show");
            }

            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener("click", toggleSidebar);
            }
            if (closeBtn) {
                closeBtn.addEventListener("click", toggleSidebar);
            }
            if (overlay) {
                overlay.addEventListener("click", toggleSidebar);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>