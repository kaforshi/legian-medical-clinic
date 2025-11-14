@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Tambah FAQ Baru</h1>
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah FAQ</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle"></i> 
                <strong>Info:</strong> Hanya perlu mengisi dalam bahasa Indonesia. 
                Terjemahan ke bahasa Inggris akan dilakukan secara otomatis.
            </div>
            
            <div class="mb-3">
                <label for="question_id" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('question_id') is-invalid @enderror" 
                       id="question_id" 
                       name="question_id" 
                       value="{{ old('question_id') }}" 
                       required 
                       maxlength="500">
                @error('question_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Maksimal 500 karakter
                </small>
            </div>
            
            <div class="mb-3">
                <label for="answer_id" class="form-label">Jawaban <span class="text-danger">*</span></label>
                <textarea class="form-control wysiwyg-editor @error('answer_id') is-invalid @enderror" 
                          id="answer_id" 
                          name="answer_id" 
                          rows="8" 
                          required>{{ old('answer_id') }}</textarea>
                @error('answer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Gunakan toolbar di atas untuk formatting teks.
                </small>
            </div>
            
            <!-- Pengaturan Umum -->
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" 
                                name="category">
                            <option value="">Pilih Kategori</option>
                            <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Umum</option>
                            <option value="medical" {{ old('category') == 'medical' ? 'selected' : '' }}>Medis</option>
                            <option value="appointment" {{ old('category') == 'appointment' ? 'selected' : '' }}>Janji Temu</option>
                            <option value="payment" {{ old('category') == 'payment' ? 'selected' : '' }}>Pembayaran</option>
                            <option value="facility" {{ old('category') == 'facility' ? 'selected' : '' }}>Fasilitas</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Urutan</label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', 0) }}" 
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Angka kecil akan ditampilkan terlebih dahulu
                        </small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            FAQ aktif akan ditampilkan di website
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan FAQ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize TinyMCE for FAQ forms
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

// Form submission handler
document.querySelector('form').addEventListener('submit', function(e) {
    tinymce.triggerSave();
});
</script>
@endpush

