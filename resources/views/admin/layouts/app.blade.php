<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Legian Medical Clinic</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background-color: #1f2937;
            color: #d1d5db;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
        }
        
        .sidebar-header {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #374151;
            padding: 0 20px;
        }
        
        .sidebar-header .logo {
            display: flex;
            align-items: center;
            color: white;
            font-size: 20px;
            font-weight: 700;
        }
        
        .sidebar-header .logo i {
            font-size: 32px;
            color: #3b82f6;
            margin-right: 12px;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #d1d5db;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            font-weight: 500;
            border-radius: 0;
        }
        
        .sidebar .nav-link:hover {
            background-color: #374151;
            color: #ffffff;
        }
        
        .sidebar .nav-link.active {
            background-color: #111827;
            color: #3b82f6;
            border-left-color: #3b82f6;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 18px;
        }
        
        /* Main Content */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }
        
        /* Header */
        .top-header {
            background-color: white;
            height: 80px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #6b7280;
            cursor: pointer;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-name {
            color: #6b7280;
            font-weight: 500;
            display: none;
        }
        
        @media (min-width: 640px) {
            .user-name {
                display: block;
            }
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-btn {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 8px;
        }
        
        .user-dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 8px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-width: 200px;
            padding: 8px 0;
            display: none;
            z-index: 1000;
        }
        
        .user-dropdown-menu.show {
            display: block;
        }
        
        .user-dropdown-item {
            display: block;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: background-color 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .user-dropdown-item:hover {
            background-color: #f3f4f6;
        }
        
        .user-dropdown-item i {
            margin-right: 8px;
            width: 16px;
        }
        
        /* Content Area */
        .content-area {
            padding: 24px;
        }
        
        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }
        
        .stat-card-content h3 {
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 8px;
        }
        
        .stat-card-content .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
        }
        
        .stat-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .stat-card-icon.blue {
            background-color: #dbeafe;
            color: #2563eb;
        }
        
        .stat-card-icon.green {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .stat-card-icon.yellow {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .stat-card-icon.purple {
            background-color: #e9d5ff;
            color: #9333ea;
        }
        
        /* Alert */
        .alert-modern {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .alert-modern.success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .alert-modern.error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .alert-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            margin-left: 16px;
        }
        
        /* Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        /* Card Modern */
        .card-modern {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: none;
        }
        
        .card-modern-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            background: white;
        }
        
        .card-modern-body {
            padding: 24px;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* TinyMCE WYSIWYG Editor Styles */
        .tox-tinymce {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }
        
        .tox-editor-header {
            border-bottom: 1px solid #ced4da !important;
        }
        
        .tox-toolbar {
            background: #f8f9fa !important;
        }
        
        .is-invalid + .tox-tinymce {
            border-color: #dc3545 !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
            }
            
            .hamburger-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-hospital"></i>
                <span>Admin Panel</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul class="nav flex-column list-unstyled mb-0">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.doctors.index') }}" class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
                        <i class="fas fa-user-md"></i>
                        <span>Manajemen Dokter</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="fas fa-stethoscope"></i>
                        <span>Manajemen Layanan</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.hero-slides.index') }}" class="nav-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <span>Hero Slides</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.content.index') }}" class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                        <i class="fas fa-edit"></i>
                        <span>Manajemen Konten</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle"></i>
                        <span>Manajemen FAQ</span>
                    </a>
                </li>
                
                @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isSuperAdmin())
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </aside>
    
    <!-- Overlay untuk Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Main Content -->
    <div class="main-wrapper" id="mainWrapper">
        <!-- Header -->
        <header class="top-header">
            <button class="hamburger-btn" id="hamburgerBtn">
                <i class="fas fa-bars"></i>
            </button>
            
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            
            <div class="user-menu">
                <span class="user-name">{{ Auth::guard('admin')->user()->name }}</span>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                </div>
                <div class="user-dropdown">
                    <button class="user-dropdown-btn" id="userMenuBtn">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="user-dropdown-menu" id="userMenu">
                        <a href="{{ route('admin.account.index') }}" class="user-dropdown-item">
                            <i class="fas fa-cog"></i>
                            Pengaturan Akun
                        </a>
                        <hr style="margin: 8px 0; border: none; border-top: 1px solid #e5e7eb;">
                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="user-dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content Area -->
        <main class="content-area">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert-modern success">
                    <span>{{ session('success') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-modern error">
                    <span>{{ session('error') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- AJAX Utilities -->
    <script src="{{ asset('js/ajax-utils.js') }}"></script>
    <!-- TinyMCE WYSIWYG Editor -->
    <script src="https://cdn.tiny.cloud/1/m7i7n4eozehb6qki7xbf1sh0fyahr4r9op1f5sqth0mnq1mh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    
    <script>
        // Sidebar toggle untuk mobile
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userMenu = document.getElementById('userMenu');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', toggleSidebar);
            }
            
            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }

            // User menu toggle
            if (userMenuBtn && userMenu) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!userMenu.contains(e.target) && !userMenuBtn.contains(e.target)) {
                        userMenu.classList.remove('show');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

