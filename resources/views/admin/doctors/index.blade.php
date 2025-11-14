@extends('admin.layouts.app')

@section('title', 'Manajemen Dokter')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Dokter</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Dokter
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Dokter</h6>
    </div>
    <div class="card-body">
        @if($doctors->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Spesialisasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>
                                <img src="{{ $doctor->photo_url }}" 
                                     alt="{{ $doctor->name }}" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                @if($doctor->name_id || $doctor->name_en)
                                    <strong>ID:</strong> {{ $doctor->name_id ?: '-' }}<br>
                                    <strong>EN:</strong> {{ $doctor->name_en ?: '-' }}
                                @else
                                    {{ $doctor->name ?: '-' }}
                                @endif
                            </td>
                            <td>
                                @if($doctor->specialization_id || $doctor->specialization_en)
                                    <strong>ID:</strong> {{ $doctor->specialization_id ?: '-' }}<br>
                                    <strong>EN:</strong> {{ $doctor->specialization_en ?: '-' }}
                                @else
                                    {{ $doctor->specialization ?: '-' }}
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
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger"
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
            
            <div class="d-flex justify-content-center">
                {{ $doctors->links() }}
            </div>
        @else
            <div class="text-center py-4">
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

