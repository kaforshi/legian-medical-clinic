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
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.25rem 0;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card-header {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="text-white">Admin Panel</h5>
                        <small class="text-white-50">Legian Medical Clinic</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}" 
                               href="{{ route('admin.doctors.index') }}">
                                <i class="fas fa-user-md"></i>
                                Manajemen Dokter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" 
                               href="{{ route('admin.services.index') }}">
                                <i class="fas fa-stethoscope"></i>
                                Manajemen Layanan
                            </a>
                        </li>
                                                 <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}" 
                                href="{{ route('admin.content.index') }}">
                                 <i class="fas fa-edit"></i>
                                 Manajemen Konten
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" 
                                href="{{ route('admin.faqs.index') }}">
                                 <i class="fas fa-question-circle"></i>
                                 Manajemen FAQ
                             </a>
                         </li>

                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="ms-auto d-flex align-items-center">
                            <!-- Language Switcher -->
                            <div class="dropdown me-3">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" 
                                        data-bs-toggle="dropdown">
                                    <i class="fas fa-globe"></i>
                                    {{ app()->getLocale() === 'id' ? 'ID' : 'EN' }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}?lang=id">
                                            <i class="fas fa-flag"></i> Bahasa Indonesia
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}?lang=en">
                                            <i class="fas fa-flag"></i> English
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- User Menu -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                        data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i>
                                    {{ Auth::guard('admin')->user()->name }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page content -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
            <!-- TinyMCE WYSIWYG Editor -->
        <script src="https://cdn.tiny.cloud/1/m7i7n4eozehb6qki7xbf1sh0fyahr4r9op1f5sqth0mnq1mh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    
    @stack('scripts')
</body>
</html>

