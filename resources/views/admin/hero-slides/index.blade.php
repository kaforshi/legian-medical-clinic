@extends('admin.layouts.app')

@section('title', 'Manajemen Hero Slides')
@section('page-title', 'Manajemen Hero Slides')

@section('content')
<div class="card-modern mb-4">
    <div class="card-modern-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Daftar Hero Slides</h5>
        <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Slide
        </a>
    </div>
    <div class="card-modern-body">
        @if($heroSlides->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 120px;">Gambar</th>
                            <th>Judul</th>
                            <th>Subtitle</th>
                            <th style="width: 80px;">Urutan</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heroSlides as $slide)
                        <tr>
                            <td>
                                <img src="{{ $slide->image_url }}" 
                                     alt="{{ $slide->title_id }}" 
                                     class="img-thumbnail" 
                                     style="width: 100px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-medium">{{ $slide->title_id }}</div>
                                @if($slide->title_en && $slide->title_en !== $slide->title_id)
                                    <small class="text-muted">{{ $slide->title_en }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;">{{ Str::limit($slide->subtitle_id, 80) }}</div>
                                @if($slide->subtitle_en && $slide->subtitle_en !== $slide->subtitle_id)
                                    <small class="text-muted text-truncate d-block" style="max-width: 300px;">{{ Str::limit($slide->subtitle_en, 80) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $slide->sort_order }}</span>
                            </td>
                            <td>
                                @if($slide->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.hero-slides.edit', $slide) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger"
                                            title="Hapus"
                                            onclick="deleteItemAjax('{{ route('admin.hero-slides.destroy', $slide) }}', {
                                                confirmMessage: 'Apakah Anda yakin ingin menghapus slide ini?',
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
                {{ $heroSlides->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada hero slide</h5>
                <p class="text-muted">Mulai dengan menambahkan slide pertama Anda.</p>
                <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Slide
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

