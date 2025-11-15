<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\ActivityLog;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HeroSlideController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.hero-slides.index', compact('heroSlides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request, TranslationService $translationService)
    {
        try {
            // Basic validation for required fields (only Indonesian)
            $request->validate([
                'title_id' => 'required|string|max:255',
                'subtitle_id' => 'required|string',
                'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5120', // Max 5MB
                'button_text_id' => 'nullable|string|max:255',
                'button_text_en' => 'nullable|string|max:255',
                'button_link' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ], [], [
                'title_id' => 'Judul (Indonesia)',
                'subtitle_id' => 'Subtitle (Indonesia)',
                'image' => 'Gambar',
            ]);
            
            // Auto translate to English
            $titleEn = $translationService->translateToEnglish($request->title_id);
            $subtitleEn = $translationService->translateToEnglish($request->subtitle_id);
            
            // Manual image validation to avoid fileinfo issue
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('image', 'Format file harus JPG, PNG, atau GIF.')
                    );
                }
                
                if ($file->getSize() > 5120 * 1024) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('image', 'Ukuran file maksimal 5MB.')
                    );
                }
            }

            $data = [
                'title_id' => $request->title_id,
                'title_en' => $titleEn,
                'subtitle_id' => $request->subtitle_id,
                'subtitle_en' => $subtitleEn,
                'button_text_id' => $request->button_text_id ?? 'Buat Janji Temu',
                'button_text_en' => $request->button_text_en ?? 'Book Appointment',
                'button_link' => $request->button_link ?? '#contact',
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active') ? 1 : 0
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                
                // Store file using Storage facade
                $imagePath = $file->store('hero-slides', 'public');
                $data['image'] = $imagePath;
                
                // Ensure directory exists in public/storage
                $publicPath = public_path('storage/' . dirname($imagePath));
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                
                // Copy file to public/storage for direct access
                $source = storage_path('app/public/' . $imagePath);
                $destination = public_path('storage/' . $imagePath);
                
                if (file_exists($source)) {
                    $copied = @copy($source, $destination);
                    if (!$copied) {
                        \Log::error('Failed to copy hero slide image', [
                            'source' => $source,
                            'destination' => $destination,
                        ]);
                    }
                }
            }

            $heroSlide = HeroSlide::create($data);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action' => 'create',
                'model_type' => 'HeroSlide',
                'model_id' => $heroSlide->id,
                'description' => "Created hero slide: {$heroSlide->title_id}",
                'new_values' => $heroSlide->toArray(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Hero slide berhasil ditambahkan.',
                    'redirect' => route('admin.hero-slides.index')
                ]);
            }
            
            return redirect()->route('admin.hero-slides.index')
                            ->with('success', 'Hero slide berhasil ditambahkan.');
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
            \Log::error('Error creating hero slide: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide, TranslationService $translationService)
    {
        try {
            // Basic validation for required fields (only Indonesian)
            $request->validate([
                'title_id' => 'required|string|max:255',
                'subtitle_id' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120', // Max 5MB
                'button_text_id' => 'nullable|string|max:255',
                'button_text_en' => 'nullable|string|max:255',
                'button_link' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ], [], [
                'title_id' => 'Judul (Indonesia)',
                'subtitle_id' => 'Subtitle (Indonesia)',
                'image' => 'Gambar',
            ]);
            
            // Auto translate to English
            $titleEn = $translationService->translateToEnglish($request->title_id);
            $subtitleEn = $translationService->translateToEnglish($request->subtitle_id);
            
            // Manual image validation to avoid fileinfo issue
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('image', 'Format file harus JPG, PNG, atau GIF.')
                    );
                }
                
                if ($file->getSize() > 5120 * 1024) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('image', 'Ukuran file maksimal 5MB.')
                    );
                }
            }

            $oldValues = $heroSlide->toArray();
            $data = [
                'title_id' => $request->title_id,
                'title_en' => $titleEn,
                'subtitle_id' => $request->subtitle_id,
                'subtitle_en' => $subtitleEn,
                'button_text_id' => $request->button_text_id ?? 'Buat Janji Temu',
                'button_text_en' => $request->button_text_en ?? 'Book Appointment',
                'button_link' => $request->button_link ?? '#contact',
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active') ? 1 : 0
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                
                // Delete old image
                if ($heroSlide->image) {
                    Storage::disk('public')->delete($heroSlide->image);
                    $oldFile = public_path('storage/' . $heroSlide->image);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                
                // Store new image
                $imagePath = $file->store('hero-slides', 'public');
                $data['image'] = $imagePath;
                
                // Ensure directory exists in public/storage
                $publicPath = public_path('storage/' . dirname($imagePath));
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                
                // Copy file to public/storage for direct access
                $source = storage_path('app/public/' . $imagePath);
                $destination = public_path('storage/' . $imagePath);
                
                if (file_exists($source)) {
                    copy($source, $destination);
                }
            }

            $heroSlide->update($data);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action' => 'update',
                'model_type' => 'HeroSlide',
                'model_id' => $heroSlide->id,
                'description' => "Updated hero slide: {$heroSlide->title_id}",
                'old_values' => $oldValues,
                'new_values' => $heroSlide->toArray(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Hero slide berhasil diperbarui.',
                    'redirect' => route('admin.hero-slides.index')
                ]);
            }
            
            return redirect()->route('admin.hero-slides.index')
                            ->with('success', 'Hero slide berhasil diperbarui.');
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
            \Log::error('Error updating hero slide: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Request $request, HeroSlide $heroSlide)
    {
        // Delete image
        if ($heroSlide->image) {
            Storage::disk('public')->delete($heroSlide->image);
            $oldFile = public_path('storage/' . $heroSlide->image);
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }

        $titleId = $heroSlide->title_id;
        $heroSlide->delete();

        // Log activity
        ActivityLog::create([
            'admin_user_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'model_type' => 'HeroSlide',
            'model_id' => $heroSlide->id,
            'description' => "Deleted hero slide: {$titleId}",
            'old_values' => $heroSlide->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hero slide berhasil dihapus.',
                'redirect' => route('admin.hero-slides.index')
            ]);
        }
        
        return redirect()->route('admin.hero-slides.index')
                        ->with('success', 'Hero slide berhasil dihapus.');
    }
}
