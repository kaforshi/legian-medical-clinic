<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($section = null)
    {
        // Urutan default section
        $sections = ['about', 'services', 'doctors', 'contact', 'faq'];

        // Jika ada section yang dipilih dari kuesioner (melalui URL),
        // hapus section tersebut dari array dan tambahkan kembali ke posisi paling awal.
        if ($section && in_array($section, $sections)) {
            // Hapus section dari array
            $sections = array_diff($sections, [$section]);
            // Tambahkan section tersebut ke paling depan
            array_unshift($sections, $section);
        }

        // Kirim data urutan section dan section yang diprioritaskan ke view
        return view('index', [
            'sections' => $sections,
            'prioritizedSection' => $section
        ]);
    }
}