@extends('admin.layouts.app')

@section('title', 'Manajemen Konten')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Konten</h1>
</div>

<div class="row">
    @foreach(['about_us', 'contact'] as $pageKey)
    @php
        $pageId = $pages[$pageKey]['id'];
        $pageEn = $pages[$pageKey]['en'];
        $pageTitle = $pages[$pageKey]['title'];
    @endphp
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    @if($pageKey === 'about_us')
                        <i class="fas fa-info-circle text-primary"></i> About Us
                    @else
                        <i class="fas fa-envelope text-info"></i> Contact
                    @endif
                </h5>
                <a href="{{ route('admin.content.edit', $pageKey) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
            <div class="card-body">
                @if($pageId || $pageEn)
                    <div class="mb-3">
                        <small class="text-muted">Bahasa Indonesia:</small>
                        @if($pageId)
                            <div class="mt-1">
                                <span class="badge bg-success">Tersedia</span>
                                <p class="mb-1 mt-2"><strong>{{ $pageId->title }}</strong></p>
                                <p class="text-muted small mb-0">{!! \Illuminate\Support\Str::limit(strip_tags($pageId->content), 150) !!}</p>
                            </div>
                        @else
                            <span class="badge bg-warning">Belum Tersedia</span>
                        @endif
                    </div>
                    
                    <div>
                        <small class="text-muted">English:</small>
                        @if($pageEn)
                            <div class="mt-1">
                                <span class="badge bg-success">Available</span>
                                <p class="mb-1 mt-2"><strong>{{ $pageEn->title }}</strong></p>
                                <p class="text-muted small mb-0">{!! Str::limit(strip_tags($pageEn->content), 150) !!}</p>
                            </div>
                        @else
                            <span class="badge bg-warning">Not Available</span>
                        @endif
                    </div>
                @else
                    <div class="text-center py-3">
                        <p class="text-muted">Konten belum tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-question-circle text-warning"></i> FAQ (Pertanyaan Umum)
        </h5>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-warning">
            <i class="fas fa-cog"></i> Kelola FAQ
        </a>
    </div>
    <div class="card-body">
        @php
            $faqCount = \App\Models\Faq::count();
            $activeFaqCount = \App\Models\Faq::where('is_active', true)->count();
        @endphp
        <div class="row">
            <div class="col-md-6">
                <p class="mb-1"><strong>Total FAQ:</strong> {{ $faqCount }}</p>
                <p class="mb-1"><strong>FAQ Aktif:</strong> {{ $activeFaqCount }}</p>
                <p class="mb-0"><strong>FAQ Non-Aktif:</strong> {{ $faqCount - $activeFaqCount }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1 text-muted">FAQ dikelola melalui halaman <strong>Manajemen FAQ</strong> yang terpisah.</p>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-arrow-right"></i> Buka Manajemen FAQ
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Detail Status Konten</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="15%">Halaman</th>
                        <th width="30%">Bahasa Indonesia</th>
                        <th width="30%">Bahasa Inggris</th>
                        <th width="15%">Terakhir Diupdate</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(['about_us', 'contact', 'faq'] as $pageKey)
                    @php
                        $pageId = $pages[$pageKey]['id'] ?? null;
                        $pageEn = $pages[$pageKey]['en'] ?? null;
                        $pageTitle = $pages[$pageKey]['title'] ?? '';
                    @endphp
                    <tr>
                        <td>
                            <strong>
                                @switch($pageKey)
                                    @case('about_us')
                                        <i class="fas fa-info-circle text-primary"></i> About Us
                                        @break
                                    @case('contact')
                                        <i class="fas fa-envelope text-info"></i> Contact
                                        @break
                                    @case('faq')
                                        <i class="fas fa-question-circle text-warning"></i> FAQ
                                        @break
                                @endswitch
                            </strong>
                        </td>
                        <td>
                            @if($pageId)
                                <span class="badge bg-success mb-2">Tersedia</span>
                                <p class="mb-1"><strong>{{ $pageId->title }}</strong></p>
                                <small class="text-muted">{!! \Illuminate\Support\Str::limit(strip_tags($pageId->content), 80) !!}</small>
                            @else
                                <span class="badge bg-warning">Belum Tersedia</span>
                                <p class="text-muted small mb-0 mt-1">Konten belum dibuat</p>
                            @endif
                        </td>
                        <td>
                            @if($pageEn)
                                <span class="badge bg-success mb-2">Available</span>
                                <p class="mb-1"><strong>{{ $pageEn->title }}</strong></p>
                                <small class="text-muted">{!! Str::limit(strip_tags($pageEn->content), 80) !!}</small>
                            @else
                                <span class="badge bg-warning">Not Available</span>
                                <p class="text-muted small mb-0 mt-1">Content not created</p>
                            @endif
                        </td>
                        <td>
                            @if($pageId && $pageEn)
                                @if($pageId->updated_at->gt($pageEn->updated_at))
                                    <small>{{ $pageId->updated_at->format('d/m/Y') }}</small>
                                    <br><small class="text-muted">{{ $pageId->updated_at->format('H:i') }}</small>
                                @else
                                    <small>{{ $pageEn->updated_at->format('d/m/Y') }}</small>
                                    <br><small class="text-muted">{{ $pageEn->updated_at->format('H:i') }}</small>
                                @endif
                            @elseif($pageId)
                                <small>{{ $pageId->updated_at->format('d/m/Y') }}</small>
                                <br><small class="text-muted">{{ $pageId->updated_at->format('H:i') }}</small>
                            @elseif($pageEn)
                                <small>{{ $pageEn->updated_at->format('d/m/Y') }}</small>
                                <br><small class="text-muted">{{ $pageEn->updated_at->format('H:i') }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($pageKey === 'faq')
                                <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-warning" title="FAQ dikelola di halaman terpisah">
                                    <i class="fas fa-cog"></i>
                                </a>
                            @else
                                <a href="{{ route('admin.content.edit', $pageKey) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

