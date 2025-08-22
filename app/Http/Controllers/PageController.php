<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\ContentPage;
use App\Models\Faq;


class PageController extends Controller
{
    public function index(Request $request, $section = null)
    {
        // Handle language switching dari session
        if (session('locale')) {
            app()->setLocale(session('locale'));
        }

        // Handle questionnaire submission
        if ($request->has('section')) {
            $section = $request->section;
            // Set session untuk menandai kuesioner sudah dijawab
            session(['questionnaireAnswered' => true]);
            session(['questionnaireSection' => $section]);
            
            // Log untuk debugging
            \Log::info('Questionnaire answered', [
                'section' => $section,
                'session_answered' => session('questionnaireAnswered')
            ]);
            
            // Redirect ke halaman yang sama tanpa parameter untuk menghindari refresh yang berulang
            return redirect()->route('home')->with([
                'questionnaireSection' => $section,
                'questionnaireAnswered' => true
            ]);
        }

        // Ambil section yang diprioritaskan dari session atau flash data
        $prioritizedSection = session('questionnaireSection') ?? $request->session()->get('questionnaireSection');

        // Urutan default section
        $sections = ['about', 'services', 'doctors', 'contact', 'faq'];

        // Jika ada section yang dipilih dari kuesioner,
        // hapus section tersebut dari array dan tambahkan kembali ke posisi paling awal.
        if ($prioritizedSection && in_array($prioritizedSection, $sections)) {
            // Hapus section dari array
            $sections = array_diff($sections, [$prioritizedSection]);
            // Tambahkan section tersebut ke paling depan
            array_unshift($sections, $prioritizedSection);
        }

        // Ambil data dari database yang dikelola melalui admin panel
        $data = [
            'sections' => $sections,
            'prioritizedSection' => $prioritizedSection,
            'doctors' => Doctor::where('is_active', true)->get(),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'faqs' => Faq::active()->ordered()->get(),
            'content' => $this->getContentPages(),
        ];

        // Kirim data ke view
        return view('index', $data);
    }

    public function clearPriority(Request $request)
    {
        // Clear questionnaire session data
        session()->forget(['questionnaireAnswered', 'questionnaireSection']);
        
        // Clear flash data if exists
        session()->flash('questionnaireClear', true);
        
        return response()->json(['success' => true]);
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