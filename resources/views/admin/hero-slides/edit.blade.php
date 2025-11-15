@extends('admin.layouts.app')

@section('title', 'Edit Hero Slide')
@section('page-title', 'Edit Hero Slide')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Hero Slide</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Hero Slide</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.hero-slides.update', $heroSlide) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Info:</strong> Hanya perlu mengisi dalam bahasa Indonesia. 
                        Terjemahan ke bahasa Inggris akan dilakukan secara otomatis saat menyimpan.
                    </div>
                    
                    <div class="mb-3">
                        <label for="title_id" class="form-label">Judul (Indonesia) <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title_id') is-invalid @enderror" 
                               id="title_id" 
                               name="title_id" 
                               value="{{ old('title_id', $heroSlide->title_id) }}" 
                               required
                               maxlength="255">
                        @error('title_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="subtitle_id" class="form-label">Subtitle (Indonesia) <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('subtitle_id') is-invalid @enderror" 
                                  id="subtitle_id" 
                                  name="subtitle_id" 
                                  rows="3" 
                                  required>{{ old('subtitle_id', $heroSlide->subtitle_id) }}</textarea>
                        @error('subtitle_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_text_id" class="form-label">Text Tombol (Indonesia)</label>
                                <input type="text" 
                                       class="form-control @error('button_text_id') is-invalid @enderror" 
                                       id="button_text_id" 
                                       name="button_text_id" 
                                       value="{{ old('button_text_id', $heroSlide->button_text_id) }}" 
                                       maxlength="255">
                                @error('button_text_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_text_en" class="form-label">Text Tombol (English)</label>
                                <input type="text" 
                                       class="form-control @error('button_text_en') is-invalid @enderror" 
                                       id="button_text_en" 
                                       name="button_text_en" 
                                       value="{{ old('button_text_en', $heroSlide->button_text_en) }}" 
                                       maxlength="255">
                                @error('button_text_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="button_link" class="form-label">Link Tombol</label>
                        <input type="text" 
                               class="form-control @error('button_link') is-invalid @enderror" 
                               id="button_link" 
                               name="button_link" 
                               value="{{ old('button_link', $heroSlide->button_link) }}" 
                               maxlength="255"
                               placeholder="#contact">
                        @error('button_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Contoh: #contact, #services, atau URL lengkap
                        </small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Urutan</label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', $heroSlide->sort_order) }}" 
                                       min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Semakin kecil angka, semakin awal ditampilkan
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $heroSlide->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Slide</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Format: JPG, PNG, GIF. Maksimal 5MB.
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <img id="image-preview" 
                                     src="{{ $heroSlide->image_url }}" 
                                     alt="Preview" 
                                     class="img-fluid rounded" 
                                     style="max-height: 300px; width: 100%; object-fit: cover;">
                                <p class="mt-2 text-muted">Preview Gambar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Form submission with AJAX
    const form = document.querySelector('form');
    if (form) {
        submitFormAjax(form, {
            onSuccess: function(data) {
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }
            }
        });
    }
});
</script>
@endpush

