<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\ActivityLog;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index()
    {
        // Include soft-deleted FAQs in admin panel
        $faqs = Faq::withTrashed()->orderBy('sort_order')->paginate(10);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request, TranslationService $translationService)
    {
        try {
            $request->validate([
                'question_id' => 'required|string|max:500',
                'answer_id' => 'required|string',
                'category' => 'nullable|string|max:100',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ]);

            // Auto translate to English
            $questionEn = $translationService->translateToEnglish($request->question_id);
            $answerEn = $translationService->translateToEnglish($request->answer_id);

            $data = [
                'question_id' => $request->question_id,
                'question_en' => $questionEn,
                'answer_id' => $request->answer_id,
                'answer_en' => $answerEn,
                'category' => $request->category,
                'sort_order' => $request->sort_order ?? 0,
            ];
            $data['is_active'] = $request->has('is_active');
            
            $faq = Faq::create($data);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action' => 'created',
                'model_type' => 'Faq',
                'model_id' => $faq->id,
                'description' => 'Created new FAQ: ' . $faq->question_id
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'FAQ berhasil ditambahkan!',
                    'redirect' => route('admin.faqs.index')
                ]);
            }
            
            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating FAQ: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq, TranslationService $translationService)
    {
        try {
            $request->validate([
                'question_id' => 'required|string|max:500',
                'answer_id' => 'required|string',
                'category' => 'nullable|string|max:100',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ]);

        // Auto translate to English
        $questionEn = $translationService->translateToEnglish($request->question_id);
        $answerEn = $translationService->translateToEnglish($request->answer_id);

        $data = [
            'question_id' => $request->question_id,
            'question_en' => $questionEn,
            'answer_id' => $request->answer_id,
            'answer_en' => $answerEn,
            'category' => $request->category,
            'sort_order' => $request->sort_order ?? 0,
        ];
        $data['is_active'] = $request->has('is_active');
        
        $faq->update($data);

        // Log activity
        ActivityLog::create([
            'admin_user_id' => Auth::guard('admin')->id(),
            'action' => 'updated',
            'model_type' => 'Faq',
            'model_id' => $faq->id,
            'description' => 'Updated FAQ: ' . $faq->question_id
        ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'FAQ berhasil diperbarui!',
                    'redirect' => route('admin.faqs.index')
                ]);
            }
            
            return redirect()->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating FAQ: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Faq $faq)
    {
        $question = $faq->question_id;
        $faq->delete();

        // Log activity
        ActivityLog::create([
            'admin_user_id' => Auth::guard('admin')->id(),
            'action' => 'deleted',
            'model_type' => 'Faq',
            'model_id' => $faq->id,
            'description' => 'Deleted FAQ: ' . $question
        ]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil dihapus!',
                'redirect' => route('admin.faqs.index')
            ]);
        }
        
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }

    public function toggleStatus(Request $request, Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);

        $status = $faq->is_active ? 'diaktifkan' : 'dinonaktifkan';

        // Log activity
        ActivityLog::create([
            'admin_user_id' => Auth::guard('admin')->id(),
            'action' => 'updated',
            'model_type' => 'Faq',
            'model_id' => $faq->id,
            'description' => 'FAQ ' . $status . ': ' . $faq->question_id
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status FAQ berhasil ' . $status . '!',
                'is_active' => $faq->is_active,
                'redirect' => route('admin.faqs.index')
            ]);
        }

        return redirect()->route('admin.faqs.index')
            ->with('success', 'Status FAQ berhasil ' . $status . '!');
    }
}

