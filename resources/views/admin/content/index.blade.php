@extends('admin.layouts.app')

@section('title', 'Manajemen Konten')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Konten</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-5 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="fas fa-info-circle fa-3x text-primary mb-3"></i>
                <h5 class="card-title">About Us</h5>
                <p class="card-text">Kelola konten halaman About Us dalam bahasa Indonesia dan Inggris.</p>
                <a href="{{ route('admin.content.edit', 'about_us') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Konten
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-5 mb-4">
        <div class="card shadow h-100">
            <div class="card-body text-center">
                <i class="fas fa-envelope fa-3x text-info mb-3"></i>
                <h5 class="card-title">Contact</h5>
                <p class="card-text">Kelola informasi kontak dan form kontak dalam dua bahasa.</p>
                <a href="{{ route('admin.content.edit', 'contact') }}" class="btn btn-info">
                    <i class="fas fa-edit"></i> Edit Konten
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Status Konten</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Halaman</th>
                        <th>Bahasa Indonesia</th>
                        <th>Bahasa Inggris</th>
                        <th>Terakhir Diupdate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(['about_us', 'contact'] as $pageKey)
                    @php
                        $pageId = $pages[$pageKey]['id'];
                        $pageEn = $pages[$pageKey]['en'];
                    @endphp
                    <tr>
                        <td>
                            <strong>
                                @switch($pageKey)
                                    @case('about_us')
                                        About Us
                                        @break
                                    @case('contact')
                                        Contact
                                        @break
                                @endswitch
                            </strong>
                        </td>
                        <td>
                            @if($pageId)
                                <span class="badge bg-success">Tersedia</span>
                                <small class="d-block text-muted">{{ Str::limit($pageId->title, 50) }}</small>
                            @else
                                <span class="badge bg-warning">Belum Tersedia</span>
                            @endif
                        </td>
                        <td>
                            @if($pageEn)
                                <span class="badge bg-success">Available</span>
                                <small class="d-block text-muted">{{ Str::limit($pageEn->title, 50) }}</small>
                            @else
                                <span class="badge bg-warning">Not Available</span>
                            @endif
                        </td>
                        <td>
                            @if($pageId && $pageEn)
                                @if($pageId->updated_at->gt($pageEn->updated_at))
                                    {{ $pageId->updated_at->format('d/m/Y H:i') }}
                                @else
                                    {{ $pageEn->updated_at->format('d/m/Y H:i') }}
                                @endif
                            @elseif($pageId)
                                {{ $pageId->updated_at->format('d/m/Y H:i') }}
                            @elseif($pageEn)
                                {{ $pageEn->updated_at->format('d/m/Y H:i') }}
                            @else
                                -
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

