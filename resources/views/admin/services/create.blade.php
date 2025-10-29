@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Layanan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Layanan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <!-- Bahasa Indonesia -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-flag"></i> Bahasa Indonesia
                            </h6>
                            
                            <div class="mb-3">
                                <label for="name_id" class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name_id') is-invalid @enderror" 
                                       id="name_id" 
                                       name="name_id" 
                                       value="{{ old('name_id') }}" 
                                       required
                                       maxlength="255">
                                @error('name_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description_id" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control wysiwyg-editor @error('description_id') is-invalid @enderror" 
                                          id="description_id" 
                                          name="description_id" 
                                          rows="8"
                                          required>{{ old('description_id') }}</textarea>
                                @error('description_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Gunakan toolbar di atas untuk formatting teks.
                                </small>
                            </div>
                        </div>
                        
                        <!-- Bahasa Inggris -->
                        <div class="col-md-6">
                            <h6 class="text-info mb-3">
                                <i class="fas fa-flag"></i> English
                            </h6>
                            
                            <div class="mb-3">
                                <label for="name_en" class="form-label">Service Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name_en') is-invalid @enderror" 
                                       id="name_en" 
                                       name="name_en" 
                                       value="{{ old('name_en') }}" 
                                       required
                                       maxlength="255">
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description_en" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control wysiwyg-editor @error('description_en') is-invalid @enderror" 
                                          id="description_en" 
                                          name="description_en" 
                                          rows="8"
                                          required>{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Use the toolbar above for text formatting.
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price') }}" 
                                           min="0" 
                                           step="1000">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Urutan Tampilan</label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', 0) }}" 
                                       min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Angka kecil akan ditampilkan terlebih dahulu</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon Layanan</label>
                        <input type="file" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" 
                               name="icon" 
                               accept="image/*">
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Format: JPG, PNG, GIF, SVG. Maksimal 2MB.
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <img id="icon-preview" 
                                     src="{{ asset('images/default-icon.png') }}" 
                                     alt="Preview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 150px;">
                                <p class="mt-2 text-muted">Preview Icon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize TinyMCE for service forms
tinymce.init({
    selector: '.wysiwyg-editor',
    height: 300,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
    branding: false,
    promotion: false,
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});

// Icon preview
document.getElementById('icon').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('icon-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Form submission handler
document.querySelector('form').addEventListener('submit', function(e) {
    tinymce.triggerSave();
});
</script>
@endpush

