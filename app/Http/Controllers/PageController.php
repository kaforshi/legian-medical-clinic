<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\ContentPage;
use App\Models\Faq;


class PageController extends Controller
{
    public function index($section = null)
    {
        // Handle language switching dari session
        if (session('locale')) {
            app()->setLocale(session('locale'));
        }

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

                        // Ambil data dari database yang dikelola melalui admin panel
                $data = [
                    'sections' => $sections,
                    'prioritizedSection' => $section,
                    'doctors' => Doctor::where('is_active', true)->get(),
                    'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
                    'faqs' => Faq::active()->ordered()->get(),
                    'content' => $this->getContentPages(),
                ];

        // Kirim data ke view
        return view('index', $data);
    }

    private function getContentPages()
    {
        $locale = app()->getLocale();
        $pages = ['about_us', 'faq', 'contact'];
        $content = [];

        foreach ($pages as $page) {
            $content[$page] = ContentPage::where('page_key', $page)
                                        ->where('locale', $locale)
                                        ->first();
        }

        return $content;
    }
}