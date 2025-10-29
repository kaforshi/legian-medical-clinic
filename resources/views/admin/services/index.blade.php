@extends('admin.layouts.app')

@section('title', 'Manajemen Layanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Layanan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Layanan
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Layanan</h6>
    </div>
    <div class="card-body">
        @if($services->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td>
                                <img src="{{ $service->icon_url }}" 
                                     alt="{{ $service->name }}" 
                                     class="img-thumbnail" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>
                                @if($service->name_id || $service->name_en)
                                    <strong>ID:</strong> {{ $service->name_id ?: '-' }}<br>
                                    <strong>EN:</strong> {{ $service->name_en ?: '-' }}
                                @else
                                    {{ $service->name ?: '-' }}
                                @endif
                            </td>
                            <td>
                                @if($service->description_id || $service->description_en)
                                    <strong>ID:</strong> {{ \Illuminate\Support\Str::limit(strip_tags($service->description_id ?: ''), 50) ?: '-' }}<br>
                                    <strong>EN:</strong> {{ \Illuminate\Support\Str::limit(strip_tags($service->description_en ?: ''), 50) ?: '-' }}
                                @else
                                    {{ \Illuminate\Support\Str::limit(strip_tags($service->description ?: ''), 100) ?: '-' }}
                                @endif
                            </td>
                            <td>
                                @if($service->price)
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $service->sort_order }}</td>
                            <td>
                                @if($service->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.services.edit', $service) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $services->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-stethoscope fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data layanan</h5>
                <p class="text-muted">Mulai dengan menambahkan layanan pertama Anda.</p>
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Layanan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

