@extends('admin.layouts.app')

@section('title', 'Manajemen Dokter')
@section('page-title', 'Manajemen Dokter')

@section('content')
<div class="card-modern mb-4">
    <div class="card-modern-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Daftar Dokter</h5>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Dokter
        </a>
    </div>
    <div class="card-modern-body">
        @if($doctors->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Foto</th>
                            <th>Nama</th>
                            <th>Spesialisasi</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>
                                <img src="{{ $doctor->photo_url }}" 
                                     alt="{{ $doctor->name_id ?: $doctor->name }}" 
                                     class="rounded-circle" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-medium">{{ $doctor->name_id ?: $doctor->name ?: '-' }}</div>
                            </td>
                            <td>
                                <div>{{ $doctor->specialization_id ?: '-' }}</div>
                                @if($doctor->specialization_en && $doctor->specialization_en !== $doctor->specialization_id)
                                    <small class="text-muted">{{ $doctor->specialization_en }}</small>
                                @endif
                            </td>
                            <td>
                                @if($doctor->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger"
                                            title="Hapus"
                                            onclick="deleteItemAjax('{{ route('admin.doctors.destroy', $doctor) }}', {
                                                confirmMessage: 'Apakah Anda yakin ingin menghapus dokter ini?',
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
                {{ $doctors->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data dokter</h5>
                <p class="text-muted">Mulai dengan menambahkan dokter pertama Anda.</p>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Dokter
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

