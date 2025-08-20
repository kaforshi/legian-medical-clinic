{{-- Menggunakan layout utama app.blade.php --}}
@extends('layouts.app')

{{-- Mendefinisikan bagian konten --}}
@section('content')

    {{-- Selalu tampilkan hero section di paling atas --}}
    @include('partials._hero')

    {{-- Loop melalui array $sections yang dikirim dari PageController
         dan memuat partial view sesuai urutan --}}
    @foreach ($sections as $section)
        @include('partials._' . $section)
    @endforeach

@endsection