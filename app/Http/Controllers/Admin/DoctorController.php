<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\ActivityLog;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request, TranslationService $translationService)
    {
        try {
            // Basic validation for required fields (only Indonesian)
            $request->validate([
                'name_id' => 'required|string|max:255',
                'specialization_id' => 'required|string|max:255',
                'is_active' => 'boolean'
            ], [], [
                'name_id' => 'Nama Dokter',
                'specialization_id' => 'Spesialisasi',
            ]);
            
            // Auto translate to English
            $nameEn = $translationService->translateToEnglish($request->name_id);
            $specializationEn = $translationService->translateToEnglish($request->specialization_id);
            
            $data = [
                'name_id' => $request->name_id,
                'name_en' => $nameEn,
                'name' => $request->name_id, // Fallback for backward compatibility
                'specialization_id' => $request->specialization_id,
                'specialization_en' => $specializationEn,
                'specialization' => $request->specialization_id, // Fallback for backward compatibility
                'is_active' => $request->has('is_active') ? 1 : 0
            ];
            
            // Manual photo validation to avoid fileinfo issue
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('photo', 'Format file harus JPG, PNG, atau GIF.')
                    );
                }
                
                if ($file->getSize() > 2048 * 1024) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('photo', 'Ukuran file maksimal 2MB.')
                    );
                }
            }

            $data = [
                'name_id' => $request->name_id,
                'name_en' => $request->name_en,
                'name' => $request->name_id ?? $request->name_en, // Fallback for backward compatibility
                'specialization_id' => $request->specialization_id,
                'specialization_en' => $request->specialization_en,
                'specialization' => $request->specialization_id ?? $request->specialization_en, // Fallback for backward compatibility
                'is_active' => $request->has('is_active') ? 1 : 0
            ];

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                
                // Store file using Storage facade
                $photoPath = $file->store('doctors', 'public');
                $data['photo'] = $photoPath;
                
                // Ensure directory exists in public/storage
                $publicPath = public_path('storage/' . dirname($photoPath));
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                
                // Copy file to public/storage for direct access
                $source = storage_path('app/public/' . $photoPath);
                $destination = public_path('storage/' . $photoPath);
                
                if (file_exists($source)) {
                    $copied = @copy($source, $destination);
                    if (!$copied) {
                        \Log::error('Failed to copy doctor photo', [
                            'source' => $source,
                            'destination' => $destination,
                            'source_exists' => file_exists($source),
                            'dest_dir_exists' => file_exists(dirname($destination))
                        ]);
                    }
                } else {
                    \Log::error('Source file does not exist', ['source' => $source]);
                }
                
                \Log::info('Doctor photo uploaded successfully', [
                    'path' => $photoPath,
                    'source' => $source,
                    'destination' => $destination,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'exists_source' => file_exists($source),
                    'exists_destination' => file_exists($destination)
                ]);
            }

            $doctor = Doctor::create($data);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action' => 'create',
                'model_type' => 'Doctor',
                'model_id' => $doctor->id,
                'description' => "Created doctor: {$doctor->name}",
                'new_values' => $doctor->toArray(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('admin.doctors.index')
                            ->with('success', 'Dokter berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating doctor: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor, TranslationService $translationService)
    {
        try {
            // Basic validation for required fields (only Indonesian)
            $request->validate([
                'name_id' => 'required|string|max:255',
                'specialization_id' => 'required|string|max:255',
                'is_active' => 'boolean'
            ], [], [
                'name_id' => 'Nama Dokter',
                'specialization_id' => 'Spesialisasi',
            ]);
            
            // Auto translate to English
            $nameEn = $translationService->translateToEnglish($request->name_id);
            $specializationEn = $translationService->translateToEnglish($request->specialization_id);
            
            // Manual photo validation to avoid fileinfo issue
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('photo', 'Format file harus JPG, PNG, atau GIF.')
                    );
                }
                
                if ($file->getSize() > 2048 * 1024) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('photo', 'Ukuran file maksimal 2MB.')
                    );
                }
            }

            $oldValues = $doctor->toArray();
            $data = [
                'name_id' => $request->name_id,
                'name_en' => $nameEn,
                'name' => $request->name_id, // Fallback for backward compatibility
                'specialization_id' => $request->specialization_id,
                'specialization_en' => $specializationEn,
                'specialization' => $request->specialization_id, // Fallback for backward compatibility
                'is_active' => $request->has('is_active') ? 1 : 0
            ];

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                
                // Delete old photo
                if ($doctor->photo) {
                    Storage::disk('public')->delete($doctor->photo);
                    $oldFile = public_path('storage/' . $doctor->photo);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                
                // Store new photo
                $photoPath = $file->store('doctors', 'public');
                $data['photo'] = $photoPath;
                
                // Ensure directory exists in public/storage
                $publicPath = public_path('storage/' . dirname($photoPath));
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                
                // Copy file to public/storage for direct access
                $source = storage_path('app/public/' . $photoPath);
                $destination = public_path('storage/' . $photoPath);
                
                if (file_exists($source)) {
                    copy($source, $destination);
                }
                
                \Log::info('Doctor photo updated successfully', [
                    'doctor_id' => $doctor->id,
                    'path' => $photoPath,
                    'source' => $source,
                    'destination' => $destination,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'exists_source' => file_exists($source),
                    'exists_destination' => file_exists($destination)
                ]);
            }

            $doctor->update($data);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action' => 'update',
                'model_type' => 'Doctor',
                'model_id' => $doctor->id,
                'description' => "Updated doctor: {$doctor->name}",
                'old_values' => $oldValues,
                'new_values' => $doctor->toArray(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('admin.doctors.index')
                            ->with('success', 'Data dokter berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating doctor: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Request $request, Doctor $doctor)
    {
        // Delete photo
        if ($doctor->photo) {
            Storage::disk('public')->delete($doctor->photo);
        }

        $doctorName = $doctor->name;
        $doctor->delete();

        // Log activity
        ActivityLog::create([
            'admin_user_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'model_type' => 'Doctor',
            'model_id' => $doctor->id,
            'description' => "Deleted doctor: {$doctorName}",
            'old_values' => $doctor->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.doctors.index')
                        ->with('success', 'Dokter berhasil dihapus.');
    }
}

