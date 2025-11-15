<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\ContentPage;
use App\Models\Faq;
use App\Models\HeroSlide;


class PageController extends Controller
{
    public function index(Request $request, $section = null)
    {
        // Handle language switching dari session
        if (session('locale')) {
            app()->setLocale(session('locale'));
        }

        // Reset layout: Clear section yang diprioritaskan saat refresh (kecuali jika baru saja submit)
        // Cek apakah ini reload setelah submit (ada parameter answered)
        $isReloadAfterSubmit = $request->has('answered') && $request->get('answered') === '1';
        
        // Ambil section yang diprioritaskan dari session atau flash data
        // Hanya gunakan jika ini reload setelah submit, jika tidak reset ke null
        $prioritizedSection = null;
        if ($isReloadAfterSubmit) {
            $prioritizedSection = session('questionnaireSection') ?? $request->session()->get('questionnaireSection');
        } else {
            // Reset: clear session questionnaireSection saat refresh normal
            $request->session()->forget('questionnaireSection');
        }

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
            'heroSlides' => HeroSlide::active()->ordered()->get(),
            'doctors' => Doctor::where('is_active', true)->get(),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'faqs' => Faq::active()->ordered()->get(),
            'content' => $this->getContentPages(),
        ];

        // Kirim data ke view
        return view('index', $data);
    }

    public function submitQuestionnaire(Request $request)
    {
        try {
            $request->validate([
                'section' => 'required|string|in:about,services,doctors,contact,faq'
            ]);

            $section = $request->section;
            
            // Set session untuk section yang diprioritaskan (tidak menyimpan status "sudah dijawab")
            // Ini memungkinkan kuesioner muncul lagi saat refresh
            $request->session()->put('questionnaireSection', $section);
            
            // Simpan session secara eksplisit
            $request->session()->save();
            
            // Log untuk debugging
            \Log::info('Questionnaire answered', [
                'section' => $section,
                'session_id' => $request->session()->getId()
            ]);
            
            // Return JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => 'Kuesioner berhasil disubmit',
                'section' => $section
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error submitting questionnaire: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clearPriority(Request $request)
    {
        // Clear questionnaire session data
        session()->forget(['questionnaireAnswered', 'questionnaireSection']);
        
        // Clear flash data if exists
        session()->flash('questionnaireClear', true);
        
        return response()->json(['success' => true]);
    }



    public function getContentByLocale(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, ['id', 'en'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid locale'
            ], 400);
        }

        // Set locale temporarily
        $oldLocale = app()->getLocale();
        app()->setLocale($locale);

        try {
            // Get all content in the requested locale
            $messages = $this->getMessages($locale);
            
            // Debug: Log messages untuk memastikan bookAppointment ada
            \Log::debug('Messages for locale ' . $locale . ':', $messages);
            
            $data = [
                'messages' => $messages,
                'doctors' => Doctor::where('is_active', true)->get()->map(function($doctor) use ($locale) {
                    // Temporarily set locale to get correct localized values
                    $oldLocale = app()->getLocale();
                    app()->setLocale($locale);
                    $localizedName = $doctor->localized_name;
                    $localizedSpec = $doctor->localized_specialization;
                    app()->setLocale($oldLocale);
                    
                    return [
                        'id' => $doctor->id,
                        'name_id' => $doctor->name_id,
                        'name_en' => $doctor->name_en,
                        'localized_name' => $localizedName,
                        'specialization_id' => $doctor->specialization_id,
                        'specialization_en' => $doctor->specialization_en,
                        'localized_specialization' => $localizedSpec,
                    ];
                }),
                'services' => Service::where('is_active', true)->orderBy('sort_order')->get()->map(function($service) use ($locale) {
                    // Temporarily set locale to get correct localized values
                    $oldLocale = app()->getLocale();
                    app()->setLocale($locale);
                    $localizedName = $service->localized_name;
                    $localizedDesc = $service->localized_description;
                    app()->setLocale($oldLocale);
                    
                    return [
                        'id' => $service->id,
                        'name_id' => $service->name_id,
                        'name_en' => $service->name_en,
                        'localized_name' => $localizedName,
                        'description_id' => $service->description_id,
                        'description_en' => $service->description_en,
                        'localized_description' => $localizedDesc,
                    ];
                }),
                'faqs' => Faq::active()->ordered()->get()->map(function($faq) use ($locale) {
                    // Temporarily set locale to get correct localized values
                    $oldLocale = app()->getLocale();
                    app()->setLocale($locale);
                    $localizedQuestion = $faq->localized_question;
                    $localizedAnswer = $faq->localized_answer;
                    app()->setLocale($oldLocale);
                    
                    return [
                        'id' => $faq->id,
                        'question_id' => $faq->question_id,
                        'question_en' => $faq->question_en,
                        'localized_question' => $localizedQuestion,
                        'answer_id' => $faq->answer_id,
                        'answer_en' => $faq->answer_en,
                        'localized_answer' => $localizedAnswer,
                        'category' => $faq->category,
                    ];
                }),
                'content' => $this->getContentPagesForApi($locale),
                'heroSlides' => HeroSlide::active()->ordered()->get()->map(function($slide) use ($locale) {
                    // Temporarily set locale to get correct localized values
                    $oldLocale = app()->getLocale();
                    app()->setLocale($locale);
                    $localizedTitle = $slide->localized_title;
                    $localizedSubtitle = $slide->localized_subtitle;
                    $localizedButtonText = $slide->localized_button_text;
                    app()->setLocale($oldLocale);
                    
                    return [
                        'id' => $slide->id,
                        'title_id' => $slide->title_id,
                        'title_en' => $slide->title_en,
                        'localized_title' => $localizedTitle,
                        'subtitle_id' => $slide->subtitle_id,
                        'subtitle_en' => $slide->subtitle_en,
                        'localized_subtitle' => $localizedSubtitle,
                        'image_url' => $slide->image_url,
                        'button_text_id' => $slide->button_text_id,
                        'button_text_en' => $slide->button_text_en,
                        'localized_button_text' => $localizedButtonText,
                        'button_link' => $slide->button_link,
                    ];
                }),
            ];

            // Restore old locale
            app()->setLocale($oldLocale);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            app()->setLocale($oldLocale);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching content: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getMessages($locale)
    {
        // Prioritaskan resources/lang/ karena file lebih lengkap dengan struktur data
        $messagesPath = resource_path('lang/' . $locale . '/messages.php');
        
        // Fallback ke lang/ directory jika tidak ada di resources/lang/
        if (!file_exists($messagesPath)) {
            $messagesPath = lang_path($locale . '/messages.php');
        }
        
        if (file_exists($messagesPath)) {
            $messages = require $messagesPath;
            
            // Pastikan bookAppointment ada, jika tidak ada coba ambil dari lang/ directory
            if (!isset($messages['bookAppointment'])) {
                $fallbackPath = lang_path($locale . '/messages.php');
                if (file_exists($fallbackPath) && $fallbackPath !== $messagesPath) {
                    $fallbackMessages = require $fallbackPath;
                    if (isset($fallbackMessages['bookAppointment'])) {
                        $messages['bookAppointment'] = $fallbackMessages['bookAppointment'];
                    }
                }
                
                if (!isset($messages['bookAppointment'])) {
                    \Log::warning('bookAppointment not found in messages for locale: ' . $locale);
                }
            }
            
            return $messages;
        }
        
        \Log::warning('Messages file not found for locale: ' . $locale . ' at path: ' . $messagesPath);
        return [];
    }

    private function getContentPages($locale = null)
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }
        $pages = ['about_us', 'faq', 'contact'];
        $content = [];

        foreach ($pages as $page) {
            $content[$page] = ContentPage::where('page_key', $page)
                                        ->where('locale', $locale)
                                        ->first();
        }

        return $content;
    }

    private function getContentPagesForApi($locale)
    {
        $pages = ['about_us', 'faq', 'contact'];
        $content = [];

        foreach ($pages as $page) {
            $contentPage = ContentPage::where('page_key', $page)
                                        ->where('locale', $locale)
                                        ->first();
            if ($contentPage) {
                $content[$page] = [
                    'title' => $contentPage->title,
                    'content' => $contentPage->content,
                    'meta_data' => $contentPage->meta_data ?? [],
                ];
            } else {
                $content[$page] = null;
            }
        }

        return $content;
    }
}