@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">Selamat datang, {{ Auth::guard('admin')->user()->name }}!</span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Dokter</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_doctors'] }}</div>
                        <small class="text-muted">{{ $stats['active_doctors'] }} aktif</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-md fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Layanan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_services'] }}</div>
                        <small class="text-muted">{{ $stats['active_services'] }} aktif</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Halaman Konten</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['content_pages'] }}</div>
                        <small class="text-muted">Konten tersedia</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-edit fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Login Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['today_logins'] }}</div>
                        <small class="text-muted">Aktivitas login</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Tambah Dokter
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.services.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> Tambah Layanan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.content.edit', 'about_us') }}" class="btn btn-info w-100">
                            <i class="fas fa-edit"></i> Edit About Us
                        </a>
                    </div>

                    <div class="col-md-3 mb-3">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-secondary w-100">
                            <i class="fas fa-external-link-alt"></i> Lihat Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
            </div>
            <div class="card-body">
                @if($stats['recent_activities']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Admin</th>
                                    <th>Aktivitas</th>
                                    <th>Detail</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_activities'] as $activity)
                                <tr>
                                    <td>{{ $activity->adminUser->name ?? 'Unknown' }}</td>
                                    <td>
                                        @switch($activity->action)
                                            @case('login')
                                                <span class="badge bg-success">Login</span>
                                                @break
                                            @case('logout')
                                                <span class="badge bg-secondary">Logout</span>
                                                @break
                                            @case('create')
                                                <span class="badge bg-primary">Create</span>
                                                @break
                                            @case('update')
                                                <span class="badge bg-warning">Update</span>
                                                @break
                                            @case('delete')
                                                <span class="badge bg-danger">Delete</span>
                                                @break
                                            @default
                                                <span class="badge bg-info">{{ $activity->action }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada aktivitas</h5>
                        <p class="text-muted">Aktivitas admin akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
