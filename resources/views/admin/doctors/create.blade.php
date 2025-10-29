@extends('admin.layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Dokter</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Dokter</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="name_id" class="form-label">Nama Dokter <span class="text-danger">*</span></label>
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
                                <label for="specialization_id" class="form-label">Spesialisasi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('specialization_id') is-invalid @enderror" 
                                       id="specialization_id" 
                                       name="specialization_id" 
                                       value="{{ old('specialization_id') }}" 
                                       required
                                       maxlength="255">
                                @error('specialization_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Bahasa Inggris -->
                        <div class="col-md-6">
                            <h6 class="text-info mb-3">
                                <i class="fas fa-flag"></i> English
                            </h6>
                            
                            <div class="mb-3">
                                <label for="name_en" class="form-label">Doctor Name <span class="text-danger">*</span></label>
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
                                <label for="specialization_en" class="form-label">Specialization <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('specialization_en') is-invalid @enderror" 
                                       id="specialization_en" 
                                       name="specialization_en" 
                                       value="{{ old('specialization_en') }}" 
                                       required
                                       maxlength="255">
                                @error('specialization_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        <label for="photo" class="form-label">Foto Dokter</label>
                        <input type="file" 
                               class="form-control @error('photo') is-invalid @enderror" 
                               id="photo" 
                               name="photo" 
                               accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Format: JPG, PNG, GIF. Maksimal 2MB.
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <img id="photo-preview" 
                                     src="{{ asset('images/default-doctor.jpg') }}" 
                                     alt="Preview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px;">
                                <p class="mt-2 text-muted">Preview Foto</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary me-2">Batal</a>
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
// Initialize TinyMCE for doctor forms
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

// Photo preview
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photo-preview').src = e.target.result;
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

