@extends('admin.layouts.app')

@section('title', 'Manajemen Layanan')
@section('page-title', 'Manajemen Layanan')

@section('content')
<div class="card-modern mb-4">
    <div class="card-modern-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Daftar Layanan</h5>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Layanan
        </a>
    </div>
    <div class="card-modern-body">
        @if($services->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Icon</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th style="width: 120px;">Harga</th>
                            <th style="width: 80px;">Urutan</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td>
                                @if($service->icon && !Str::startsWith($service->icon, 'fas '))
                                    <img src="{{ $service->icon_url }}" 
                                         alt="{{ $service->name_id ?: $service->name }}" 
                                         class="rounded" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded bg-light" style="width: 50px; height: 50px;">
                                        <i class="fas {{ $service->icon ?? 'fa-stethoscope' }} fa-lg text-primary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium">{{ $service->name_id ?: $service->name ?: '-' }}</div>
                                @if($service->name_en && $service->name_en !== $service->name_id)
                                    <small class="text-muted">{{ $service->name_en }}</small>
                                @endif
                            </td>
                            <td>
                                <div>{!! \Illuminate\Support\Str::limit(strip_tags($service->description_id ?: ''), 60) ?: '-' !!}</div>
                                @if($service->description_en && $service->description_en !== $service->description_id)
                                    <small class="text-muted">{!! \Illuminate\Support\Str::limit(strip_tags($service->description_en), 60) !!}</small>
                                @endif
                            </td>
                            <td>
                                @if($service->price)
                                    <span class="fw-medium text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-muted">-</span>
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
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.services.edit', $service) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger"
                                            title="Hapus"
                                            onclick="deleteItemAjax('{{ route('admin.services.destroy', $service) }}', {
                                                confirmMessage: 'Apakah Anda yakin ingin menghapus layanan ini?',
                                                button: this
                                            })">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $services->links() }}
            </div>
        @else
            <div class="text-center py-5">
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

