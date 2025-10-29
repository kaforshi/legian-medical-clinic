@extends('admin.layouts.app')

@section('title', 'Edit Konten')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        Edit Konten - 
        @switch($pageKey)
            @case('about_us')
                About Us
                @break
            @case('faq')
                FAQ
                @break
            @case('contact')
                Contact
                @break
            @default
                {{ ucfirst(str_replace('_', ' ', $pageKey)) }}
        @endswitch
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Konten</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.content.update', $pageKey) }}" method="POST">
            @csrf
            @method('PUT')
            
            <ul class="nav nav-tabs" id="contentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="indonesian-tab" data-bs-toggle="tab" data-bs-target="#indonesian" type="button" role="tab">
                        <i class="fas fa-flag"></i> Bahasa Indonesia
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab">
                        <i class="fas fa-flag"></i> English
                    </button>
                </li>
            </ul>
            
            <div class="tab-content mt-3" id="contentTabsContent">
                <!-- Indonesian Content -->
                <div class="tab-pane fade show active" id="indonesian" role="tabpanel">
                    <div class="mb-3">
                        <label for="title_id" class="form-label">Judul (Bahasa Indonesia) <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title_id') is-invalid @enderror" 
                               id="title_id" 
                               name="title_id" 
                               value="{{ old('title_id', $pageId->title ?? '') }}" 
                               required>
                        @error('title_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="content_id" class="form-label">Konten (Bahasa Indonesia) <span class="text-danger">*</span></label>
                        <textarea class="form-control wysiwyg-editor @error('content_id') is-invalid @enderror" 
                                  id="content_id" 
                                  name="content_id" 
                                  rows="15" 
                                  required>{{ old('content_id', $pageId->content ?? '') }}</textarea>
                        @error('content_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Gunakan toolbar di atas untuk formatting teks. Anda tidak perlu mengetahui HTML.
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description_id" class="form-label">Meta Description (Bahasa Indonesia)</label>
                        <textarea class="form-control" 
                                  id="meta_description_id" 
                                  name="meta_description_id" 
                                  rows="3">{{ old('meta_description_id', $pageId->meta_description ?? '') }}</textarea>
                        <small class="form-text text-muted">
                            Deskripsi singkat untuk SEO (maksimal 500 karakter).
                        </small>
                    </div>
                </div>
                
                <!-- English Content -->
                <div class="tab-pane fade" id="english" role="tabpanel">
                    <div class="mb-3">
                        <label for="title_en" class="form-label">Title (English) <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title_en') is-invalid @enderror" 
                               id="title_en" 
                               name="title_en" 
                               value="{{ old('title_en', $pageEn->title ?? '') }}" 
                               required>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="content_en" class="form-label">Content (English) <span class="text-danger">*</span></label>
                        <textarea class="form-control wysiwyg-editor @error('content_en') is-invalid @enderror" 
                                  id="content_en" 
                                  name="content_en" 
                                  rows="15" 
                                  required>{{ old('content_en', $pageEn->content ?? '') }}</textarea>
                        @error('content_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Use the toolbar above for text formatting. No HTML knowledge required.
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description_en" class="form-label">Meta Description (English)</label>
                        <textarea class="form-control" 
                                  id="meta_description_en" 
                                  name="meta_description_en" 
                                  rows="3">{{ old('meta_description_en', $pageEn->meta_description ?? '') }}</textarea>
                        <small class="form-text text-muted">
                            Brief description for SEO (maximum 500 characters).
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Meta Data for Contact Page -->
            @if($pageKey === 'contact')
            <div class="mt-4">
                <h5>Informasi Kontak Tambahan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address', $pageId?->getMetaDataValue('address') ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $pageId?->getMetaDataValue('phone') ?? '') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $pageId?->getMetaDataValue('email') ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="working_hours" class="form-label">Jam Operasional</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="working_hours" 
                                   name="working_hours" 
                                   value="{{ old('working_hours', $pageId?->getMetaDataValue('working_hours') ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.content.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Konten
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize TinyMCE WYSIWYG Editor
tinymce.init({
    selector: '.wysiwyg-editor',
    height: 400,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
    branding: false,
    promotion: false,
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    },
    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6;',
    formats: {
        alignleft: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-start' },
        aligncenter: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-center' },
        alignright: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-end' },
        alignjustify: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-justify' }
    }
});

// Auto-resize other textareas (non-wysiwyg)
document.querySelectorAll('textarea:not(.wysiwyg-editor)').forEach(function(textarea) {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
});

// Initialize textarea heights for non-wysiwyg
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('textarea:not(.wysiwyg-editor)').forEach(function(textarea) {
        textarea.style.height = textarea.scrollHeight + 'px';
    });
});

// Form submission handler
document.querySelector('form').addEventListener('submit', function(e) {
    // Trigger TinyMCE to save content to textareas
    tinymce.triggerSave();
});
</script>
@endpush

