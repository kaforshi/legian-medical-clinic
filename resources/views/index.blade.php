{{-- Menggunakan layout utama app.blade.php --}}
@extends('layouts.app')

{{-- Mendefinisikan bagian konten --}}
@section('content')

    {{-- Debug info untuk troubleshooting --}}
    <!-- DEBUG: prioritizedSection = {{ $prioritizedSection ?? 'NULL' }} -->
    <!-- DEBUG: questionnaireAnswered = {{ session('questionnaireAnswered') ? 'true' : 'false' }} -->
    <!-- DEBUG: questionnaireSection = {{ session('questionnaireSection') ?? 'NULL' }} -->

    {{-- Tampilkan section yang diprioritaskan TEPAT di atas hero jika ada --}}
    @if(isset($prioritizedSection) && $prioritizedSection && (session('questionnaireAnswered') || session()->has('questionnaireSection')))
        <div class="prioritized-section-above-hero">
            <div style="background: red; color: white; padding: 10px; text-align: center;">
                🎯 PRIORITY SECTION: {{ strtoupper($prioritizedSection) }} - DI ATAS HERO
            </div>
            @include('partials._' . $prioritizedSection)
        </div>
    @else
        <!-- DEBUG: Condition not met for priority section -->
        <!-- prioritizedSection exists: {{ isset($prioritizedSection) ? 'YES' : 'NO' }} -->
        <!-- prioritizedSection has value: {{ $prioritizedSection ? 'YES' : 'NO' }} -->
        <!-- questionnaireAnswered: {{ session('questionnaireAnswered') ? 'YES' : 'NO' }} -->
        <!-- has questionnaireSection: {{ session()->has('questionnaireSection') ? 'YES' : 'NO' }} -->
    @endif

    {{-- Selalu tampilkan hero section --}}
    @include('partials._hero')

    {{-- Loop melalui array $sections yang dikirim dari PageController
         dan memuat partial view sesuai urutan (tanpa section yang sudah diprioritaskan) --}}
    @foreach ($sections as $index => $section)
        @php
            // Skip section yang sudah ditampilkan di atas hero
            $isPrioritized = $section === $prioritizedSection && session('questionnaireAnswered');
            $sectionClass = $isPrioritized ? 'prioritized-section' : '';
        @endphp
        @if(!$isPrioritized)
            <div class="{{ $sectionClass }}">
                @include('partials._' . $section)
            </div>
        @endif
    @endforeach

@endsection