@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Kartu Statistik -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <h3>Total Dokter</h3>
                <div class="stat-value">{{ $stats['total_doctors'] }}</div>
                <small class="text-muted">{{ $stats['active_doctors'] }} aktif</small>
            </div>
            <div class="stat-card-icon blue">
                <i class="fas fa-user-md"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <h3>Total Layanan</h3>
                <div class="stat-value">{{ $stats['total_services'] }}</div>
                <small class="text-muted">{{ $stats['active_services'] }} aktif</small>
            </div>
            <div class="stat-card-icon green">
                <i class="fas fa-stethoscope"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <h3>Halaman Konten</h3>
                <div class="stat-value">{{ $stats['content_pages'] }}</div>
            </div>
            <div class="stat-card-icon yellow">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-content">
                <h3>Login Hari Ini</h3>
                <div class="stat-value">{{ $stats['today_logins'] }}</div>
            </div>
            <div class="stat-card-icon purple">
                <i class="fas fa-sign-in-alt"></i>
            </div>
        </div>
    </div>
</div>

<!-- Grid Bawah: Aksi Cepat & Aktivitas Terbaru -->
<div class="row g-4">
    <!-- Aksi Cepat -->
    <div class="col-lg-6">
        <div class="card-modern">
            <div class="card-modern-header">
                <h5 class="mb-0 fw-semibold">Aksi Cepat</h5>
            </div>
            <div class="card-modern-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.doctors.create') }}" class="text-decoration-none">
                            <div class="card border-0 bg-light text-center p-4 h-100 hover-shadow" style="transition: all 0.3s; cursor: pointer;">
                                <div class="mb-3">
                                    <i class="fas fa-user-plus fa-2x text-primary"></i>
                                </div>
                                <div class="fw-medium text-dark">Tambah Dokter</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.services.create') }}" class="text-decoration-none">
                            <div class="card border-0 bg-light text-center p-4 h-100 hover-shadow" style="transition: all 0.3s; cursor: pointer;">
                                <div class="mb-3">
                                    <i class="fas fa-plus-circle fa-2x text-success"></i>
                                </div>
                                <div class="fw-medium text-dark">Tambah Layanan</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.content.edit', 'about_us') }}" class="text-decoration-none">
                            <div class="card border-0 bg-light text-center p-4 h-100 hover-shadow" style="transition: all 0.3s; cursor: pointer;">
                                <div class="mb-3">
                                    <i class="fas fa-edit fa-2x text-warning"></i>
                                </div>
                                <div class="fw-medium text-dark">Edit About Us</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('home') }}" target="_blank" class="text-decoration-none">
                            <div class="card border-0 bg-light text-center p-4 h-100 hover-shadow" style="transition: all 0.3s; cursor: pointer;">
                                <div class="mb-3">
                                    <i class="fas fa-external-link-alt fa-2x text-secondary"></i>
                                </div>
                                <div class="fw-medium text-dark">Lihat Website</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="col-lg-6">
        <div class="card-modern">
            <div class="card-modern-header">
                <h5 class="mb-0 fw-semibold">Aktivitas Terbaru</h5>
            </div>
            <div class="card-modern-body">
                <div style="max-height: 300px; overflow-y: auto;">
                    <ul class="list-unstyled mb-0">
                        @forelse($stats['recent_activities'] as $activity)
                            <li class="d-flex align-items-center py-3 border-bottom">
                                @php
                                    $iconClass = 'bg-primary text-white';
                                    $icon = 'fa-plus';
                                    if($activity->action == 'updated') {
                                        $iconClass = 'bg-warning text-white';
                                        $icon = 'fa-edit';
                                    } elseif($activity->action == 'deleted') {
                                        $iconClass = 'bg-danger text-white';
                                        $icon = 'fa-trash';
                                    }
                                @endphp
                                <div class="rounded-circle {{ $iconClass }} d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; margin-right: 12px;">
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ $activity->description }}</div>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                        @empty
                            <li class="text-center text-muted py-4">
                                <p>Tidak ada aktivitas terbaru</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
        transform: translateY(-2px);
    }
</style>
@endsection
