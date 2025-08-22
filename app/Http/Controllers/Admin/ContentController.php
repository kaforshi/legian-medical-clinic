<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContentPage;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function index()
    {
        $pageKeys = ['about_us', 'contact'];
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

    public function update(Request $request, $pageKey)
    {
        $request->validate([
            'title_id' => 'required|string|max:255',
            'content_id' => 'required|string',
            'meta_description_id' => 'nullable|string|max:500',
            'title_en' => 'required|string|max:255',
            'content_en' => 'required|string',
            'meta_description_en' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'working_hours' => 'nullable|string|max:255'
        ]);

        // Update Indonesian content
        $contentId = ContentPage::updateOrCreate(
            [
                'page_key' => $pageKey,
                'locale' => 'id'
            ],
            [
                'title' => $request->title_id,
                'content' => $request->content_id,
                'meta_description' => $request->meta_description_id,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'working_hours' => $request->working_hours
            ]
        );

        // Update English content
        $contentEn = ContentPage::updateOrCreate(
            [
                'page_key' => $pageKey,
                'locale' => 'en'
            ],
            [
                'title' => $request->title_en,
                'content' => $request->content_en,
                'meta_description' => $request->meta_description_en,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'working_hours' => $request->working_hours
            ]
        );

        // Log activity
        Log::info('Content updated', [
            'admin_id' => auth()->id(),
            'page_key' => $pageKey,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('admin.content.index')
            ->with('success', 'Konten berhasil diperbarui');
    }

    private function getPageTitle($pageKey)
    {
        $titles = [
            'about_us' => 'Tentang Kami',
            'contact' => 'Kontak'
        ];

        return $titles[$pageKey] ?? ucfirst(str_replace('_', ' ', $pageKey));
    }
}
