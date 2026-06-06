<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --primary: #c92a2a;
            --primary-gradient: linear-gradient(135deg, #c92a2a 0%, #e67e22 100%);
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark-sidebar: #ffffff;
            --bg-admin: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: rgba(226, 232, 240, 0.8);
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -4px rgba(0, 0, 0, 0.04);
            --shadow-premium: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-admin);
            color: var(--text-main);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .fw-black, .fw-bold {
            font-family: 'Outfit', sans-serif;
        }

        /* Light Theme defaults */
        .text-dark { color: var(--text-main) !important; }
        .text-muted, .text-secondary { color: var(--text-muted) !important; }
        .text-primary { color: var(--primary) !important; }
        .bg-light { background-color: #f1f5f9 !important; color: var(--text-main) !important; }
        select option { background-color: #ffffff !important; color: var(--text-main) !important; }
        .modal-content { background-color: #ffffff !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* --- Sidebar Modern --- */
        .admin-sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--dark-sidebar);
            z-index: 1000;
            transition: var(--transition);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
        }

        .sidebar-brand {
            padding: 1.75rem 1.5rem;
            color: var(--text-main);
            font-weight: 800;
            font-size: 1.35rem;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991.98px) {
            .sidebar-brand {
                justify-content: space-between;
            }
        }

        .sidebar-brand span {
            color: #e67e22;
            background: linear-gradient(135deg, #c92a2a 0%, #e67e22 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        /* Styling Sidebar Links */
        .sidebar-link {
            display: flex;
            align-items: center;
            color: #475569;
            padding: 0.85rem 1.25rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.925rem;
            transition: var(--transition);
            margin: 0.25rem 1rem;
            border-radius: var(--radius-md);
            border: 1px solid transparent;
        }

        .sidebar-link i {
            width: 28px;
            font-size: 1.15rem;
            transition: var(--transition);
            opacity: 0.8;
        }

        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: var(--text-main);
            border-color: rgba(0, 0, 0, 0.01);
            transform: translateX(3px);
        }

        .sidebar-link.active {
            background: var(--primary-gradient);
            color: #fff;
            box-shadow: 0 8px 20px -6px rgba(201, 42, 42, 0.35);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-link.active i {
            opacity: 1;
        }

        .sidebar-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: #f8fafc;
        }

        /* --- Main Content Area --- */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        /* --- Topbar Modern --- */
        .admin-topbar {
            height: 75px;
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02), 0 1px 2px -1px rgba(0, 0, 0, 0.02);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .admin-content {
            padding: 2.25rem 2rem;
            flex-grow: 1;
        }

        /* --- GLOBAL MODERN COMPONENT OVERRIDES --- */

        /* Cards */
        .card {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-sm) !important;
            transition: var(--transition);
        }
        .card:hover {
            box-shadow: var(--shadow-md) !important;
        }

        /* Buttons styling overrides */
        .btn {
            border-radius: 9999px !important; /* Pill shape */
            font-weight: 600;
            padding: 0.55rem 1.5rem;
            font-size: 0.9rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: var(--primary-gradient) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(201, 42, 42, 0.2);
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background: linear-gradient(135deg, #a81c1c 0%, #d35400 100%) !important;
            box-shadow: 0 6px 16px rgba(201, 42, 42, 0.3);
            transform: translateY(-2px);
            color: #fff !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            color: #fff !important;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
            transform: translateY(-2px);
            color: #fff !important;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
            color: #fff !important;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
            transform: translateY(-2px);
            color: #fff !important;
        }

        .btn-outline-secondary {
            border: 1px solid var(--border-color) !important;
            background: #ffffff !important;
            color: var(--text-main) !important;
        }
        .btn-outline-secondary:hover {
            background: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            transform: translateY(-2px);
            color: var(--text-main) !important;
        }

        .btn-light {
            background: #f1f5f9 !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
        }
        .btn-light:hover {
            background: #e2e8f0 !important;
            transform: translateY(-2px);
        }

        /* Inputs & Form Controls */
        .form-control, .form-select {
            border-radius: var(--radius-md) !important;
            border: 1.5px solid var(--border-color) !important;
            padding: 0.65rem 1rem !important;
            font-size: 0.95rem !important;
            color: var(--text-main) !important;
            background-color: #ffffff !important;
            transition: var(--transition) !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(201, 42, 42, 0.12) !important;
            outline: 0 !important;
            background-color: #ffffff !important;
        }

        .form-control-lg, .form-select-lg {
            padding: 0.8rem 1.25rem !important;
            font-size: 1.05rem !important;
        }

        .form-label {
            font-weight: 600 !important;
            color: var(--text-muted) !important;
            margin-bottom: 0.5rem !important;
            font-size: 0.9rem !important;
        }

        /* Custom Modern Table */
        .table {
            --bs-table-bg: transparent !important;
            --bs-table-hover-bg: #f8fafc !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        .table thead th {
            font-weight: 700 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: var(--text-muted) !important;
            border-bottom: 2px solid var(--border-color) !important;
            padding: 1rem !important;
        }

        .table tbody td {
            padding: 1.15rem 1rem !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            vertical-align: middle !important;
        }

        .table-hover tbody tr {
            transition: var(--transition) !important;
        }
        .table-hover tbody tr:hover {
            background-color: var(--bs-table-hover-bg) !important;
        }

        /* Badges */
        .badge {
            font-weight: 700 !important;
            padding: 0.45em 0.85em !important;
            border-radius: 9999px !important;
            font-size: 0.725rem !important;
            letter-spacing: 0.3px !important;
        }

        /* Custom modern badges using translucent colors */
        .badge.bg-success {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #059669 !important;
            border: 1px solid rgba(16, 185, 129, 0.2) !important;
        }
        .badge.bg-success-subtle {
            background-color: rgba(16, 185, 129, 0.08) !important;
            color: #059669 !important;
            border: 1px solid rgba(16, 185, 129, 0.15) !important;
        }
        .badge.bg-warning {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #d97706 !important;
            border: 1px solid rgba(245, 158, 11, 0.2) !important;
        }
        .badge.bg-danger {
            background-color: rgba(239, 68, 68, 0.1) !important;
            color: #dc2626 !important;
            border: 1px solid rgba(239, 68, 68, 0.2) !important;
        }
        .badge.bg-danger-subtle {
            background-color: rgba(239, 68, 68, 0.08) !important;
            color: #dc2626 !important;
            border: 1px solid rgba(239, 68, 68, 0.15) !important;
        }
        .badge.bg-primary {
            background-color: rgba(13, 110, 253, 0.1) !important;
            color: #0b5ed7 !important;
            border: 1px solid rgba(13, 110, 253, 0.2) !important;
        }
        .badge.bg-info {
            background-color: rgba(59, 130, 246, 0.1) !important;
            color: #2563eb !important;
            border: 1px solid rgba(59, 130, 246, 0.2) !important;
        }
        .badge.bg-secondary {
            background-color: rgba(100, 116, 139, 0.1) !important;
            color: #475569 !important;
            border: 1px solid rgba(100, 116, 139, 0.2) !important;
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 998;
            transition: opacity 0.3s ease;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            opacity: 0;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Mobile responsive optimizations */
        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .sidebar-overlay.show {
                display: block !important;
            }
        }
        @media (max-width: 767.98px) {
            .admin-content {
                padding: 1.5rem 1rem;
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
                <i class="fas fa-fish me-2" style="color: #c92a2a;"></i>
                Marinasi<span>Admin</span>
            </div>
            <button class="btn text-white d-lg-none p-0 border-0" id="sidebarClose" type="button">
                <i class="fas fa-times fs-5 text-dark"></i>
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
            <a href="{{ route('admin.preview-site') }}" class="sidebar-link" target="_blank">
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
                <button class="btn btn-light d-lg-none shadow-none border-0 p-2" id="sidebarToggle" type="button" style="background: transparent !important;">
                    <i class="fas fa-bars fs-4 text-dark"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">@yield('title')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-md-block">
                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                    <p class="mb-0 text-muted" style="font-size: 0.75rem;">Administrator</p>
                </div>
                
                {{-- 👑 PERBAIKAN FITUR FOTO PROFIL ADMIN REAL-TIME 👑 --}}
                <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm overflow-hidden" style="width: 40px; height: 40px; background-color: #c92a2a;">
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