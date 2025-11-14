<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use App\Models\ContentPage;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function index()
    {
        $pageKeys = ['about_us', 'faq', 'contact'];
        $pages = collect($pageKeys)->mapWithKeys(function ($pageKey) {
            return [
                $pageKey => [
                    'id' => ContentPage::where('page_key', $pageKey)->where('locale', 'id')->first(),
                    'en' => ContentPage::where('page_key', $pageKey)->where('locale', 'en')->first(),
                    'title' => $this->getPageTitle($pageKey)
                ]
            ];
        });

        return view('admin.content.index', compact('pages'));
    }

    public function edit($pageKey)
    {
        $pageId = ContentPage::where('page_key', $pageKey)
            ->where('locale', 'id')
            ->first();
        
        $pageEn = ContentPage::where('page_key', $pageKey)
            ->where('locale', 'en')
            ->first();

        return view('admin.content.edit', compact('pageId', 'pageEn', 'pageKey'));
    }

    public function update(Request $request, $pageKey, TranslationService $translationService)
    {
        $request->validate([
            'title_id' => 'required|string|max:255',
            'content_id' => 'required|string',
            'meta_description_id' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'working_hours' => 'nullable|string|max:255'
        ]);

        // Auto translate to English
        $titleEn = $translationService->translateToEnglish($request->title_id);
        $contentEn = $translationService->translateToEnglish($request->content_id);
        $metaDescriptionEn = $request->meta_description_id 
            ? $translationService->translateToEnglish($request->meta_description_id) 
            : null;

        // Prepare meta_data for contact page
        $metaData = null;
        if ($pageKey === 'contact') {
            $metaData = [
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'working_hours' => $request->working_hours,
            ];
        }

        // Update Indonesian content
        $contentId = ContentPage::updateOrCreate(
            [
                'page_key' => $pageKey,
                'locale' => 'id'
            ],
            [
                'title' => $request->title_id,
                'content' => $request->content_id,
                'meta_data' => $metaData,
            ]
        );

        // Update English content (auto translated)
        $contentEnRecord = ContentPage::updateOrCreate(
            [
                'page_key' => $pageKey,
                'locale' => 'en'
            ],
            [
                'title' => $titleEn,
                'content' => $contentEn,
                'meta_data' => $metaData,
            ]
        );

        // Log activity
        Log::info('Content updated', [
            'admin_id' => auth()->id(),
            'page_key' => $pageKey,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil diperbarui',
                'redirect' => route('admin.content.index')
            ]);
        }
        
        return redirect()->route('admin.content.index')
            ->with('success', 'Konten berhasil diperbarui');
    }

    private function getPageTitle($pageKey)
    {
        $titles = [
            'about_us' => 'Tentang Kami',
            'faq' => 'Pertanyaan Umum',
            'contact' => 'Kontak'
        ];

        return $titles[$pageKey] ?? ucfirst(str_replace('_', ' ', $pageKey));
    }
}
