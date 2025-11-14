@extends('admin.layouts.app')

@section('title', 'Manajemen FAQ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Manajemen FAQ</h1>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah FAQ
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar FAQ</h5>
    </div>
    <div class="card-body">
        @if($faqs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Pertanyaan (ID)</th>
                            <th width="25%">Pertanyaan (EN)</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Urutan</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $index => $faq)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $faq->question_id }}">
                                        {{ $faq->question_id }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $faq->question_en }}">
                                        {{ $faq->question_en }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $faq->category ?: 'General' }}</span>
                                </td>
                                <td>{{ $faq->sort_order }}</td>
                                <td>
                                    @if($faq->trashed())
                                        <span class="badge bg-dark">Terhapus</span>
                                    @elseif($faq->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-{{ $faq->is_active ? 'warning' : 'success' }} toggle-status-btn" 
                                                title="{{ $faq->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                data-url="{{ route('admin.faqs.toggle-status', $faq) }}"
                                                data-is-active="{{ $faq->is_active ? '1' : '0' }}">
                                            <i class="fas fa-{{ $faq->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Hapus"
                                                onclick="deleteItemAjax('{{ route('admin.faqs.destroy', $faq) }}', {
                                                    confirmMessage: 'Yakin ingin menghapus FAQ ini?',
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
                {{ $faqs->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada FAQ</h5>
                <p class="text-muted">Mulai dengan menambahkan FAQ pertama Anda.</p>
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah FAQ Pertama
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle toggle status buttons
    document.querySelectorAll('.toggle-status-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const isActive = this.getAttribute('data-is-active') === '1';
            
            toggleStatusAjax(url, {
                button: this,
                onSuccess: function(data) {
                    // Update button appearance
                    if (data.is_active) {
                        btn.className = 'btn btn-sm btn-outline-warning toggle-status-btn';
                        btn.title = 'Nonaktifkan';
                        btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                        btn.setAttribute('data-is-active', '1');
                    } else {
                        btn.className = 'btn btn-sm btn-outline-success toggle-status-btn';
                        btn.title = 'Aktifkan';
                        btn.innerHTML = '<i class="fas fa-eye"></i>';
                        btn.setAttribute('data-is-active', '0');
                    }
                    // Update status badge in table
                    const row = btn.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(6)');
                    if (statusCell) {
                        if (data.is_active) {
                            statusCell.innerHTML = '<span class="badge bg-success">Aktif</span>';
                        } else {
                            statusCell.innerHTML = '<span class="badge bg-danger">Nonaktif</span>';
                        }
                    }
                }
            });
        });
    });
});
</script>
@endpush
@endsection

