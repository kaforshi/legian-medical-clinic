{{-- Menggunakan layout utama app.blade.php --}}
@extends('layouts.app')

{{-- Mendefinisikan bagian konten --}}
@section('content')

    {{-- Debug info untuk troubleshooting --}}
    <!-- DEBUG: prioritizedSection = {{ $prioritizedSection ?? 'NULL' }} -->
    <!-- DEBUG: questionnaireAnswered = {{ session('questionnaireAnswered') ? 'true' : 'false' }} -->
    <!-- DEBUG: questionnaireSection = {{ session('questionnaireSection') ?? 'NULL' }} -->

    {{-- Tampilkan section yang diprioritaskan TEPAT di atas hero jika ada --}}
    @if(isset($prioritizedSection) && $prioritizedSection)
        <div class="prioritized-section-above-hero">
            @include('partials._' . $prioritizedSection)
        </div>
    @endif

    {{-- Selalu tampilkan hero section --}}
    @include('partials._hero')

    {{-- Loop melalui array $sections yang dikirim dari PageController
         dan memuat partial view sesuai urutan (tanpa section yang sudah diprioritaskan) --}}
    @foreach ($sections as $index => $section)
        @php
            // Skip section yang sudah ditampilkan di atas hero
            $isPrioritized = $section === $prioritizedSection;
            $sectionClass = $isPrioritized ? 'prioritized-section' : '';
        @endphp
        @if(!$isPrioritized)
            <div class="{{ $sectionClass }}">
                @include('partials._' . $section)
            </div>
        @endif
    @endforeach

@endsection