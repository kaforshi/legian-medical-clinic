<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return redirect()->route('admin.services.edit', $service);
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        try {
            // Basic validation for required fields
            $request->validate([
                'name_id' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'description_id' => 'required|string',
                'description_en' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ], [], [
                'name_id' => 'Nama (Indonesia)',
                'name_en' => 'Nama (English)',
                'description_id' => 'Deskripsi (Indonesia)',
                'description_en' => 'Deskripsi (English)',
            ]);
            
            // Manual icon validation to avoid fileinfo issue
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('icon', 'Format file harus JPG, PNG, atau GIF.')
                    );
                }
                
                if ($file->getSize() > 2048 * 1024) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('icon', 'Ukuran file maksimal 2MB.')
                    );
                }
            }

            $data = [
                'name_id' => $request->name_id,
                'name_en' => $request->name_en,
                'name' => $request->name_id ?? $request->name_en, // Fallback for backward compatibility
                'description_id' => $request->description_id,
                'description_en' => $request->description_en,
                'description' => $request->description_id ?? $request->description_en, // Fallback for backward compatibility
                'price' => $request->price,
                'sort_order' => $request->sort_order,
                'is_active' => $request->has('is_active') ? 1 : 0
            ];

            // Handle icon upload
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $iconPath = $file->store('icons', 'public');
                $data['icon'] = $iconPath;
                
                // Ensure directory exists in public/storage
                $publicPath = public_path('storage/' . dirname($iconPath));
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                
                // Copy file to public/storage for direct access
                $source = storage_path('app/public/' . $iconPath);
                $destination = public_path('storage/' . $iconPath);
                
                if (file_exists($source)) {
                    $copied = @copy($source, $destination);
                    if (!$copied) {
                        \Log::error('Failed to copy service icon', [
                            'source' => $source,
                            'destination' => $destination,
                            'source_exists' => file_exists($source),
                            'dest_dir_exists' => file_exists(dirname($destination))
                        ]);
                    }
                } else {
                    \Log::error('Source file does not exist', ['source' => $source]);
                }
                
                \Log::info('Service icon uploaded successfully', [
                    'path' => $iconPath,
                    'source' => $source,
                    'destination' => $destination,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'exists_source' => file_exists($source),
                    'exists_destination' => file_exists($destination)
                ]);
            }

            Service::create($data);

            // Log activity
            Log::info('Service created', [
                'admin_id' => auth()->id(),
                'service_name' => $data['name'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('admin.services.index')
                ->with('success', 'Layanan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating service: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        try {
            // Basic validation for required fields
            $request->validate([
                'name_id' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'description_id' => 'required|string',
                'description_en' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ], [], [
                'name_id' => 'Nama (Indonesia)',
                'name_en' => 'Nama (English)',
                'description_id' => 'Deskripsi (Indonesia)',
                'description_en' => 'Deskripsi (English)',
            ]);
            
            // Manual icon validation to avoid fileinfo issue
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('icon', 'Format file harus JPG, PNG, atau GIF.')
                    );
                }
                
                if ($file->getSize() > 2048 * 1024) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], [])
                        ->errors()
                        ->add('icon', 'Ukuran file maksimal 2MB.')
                    );
                }
            }

            $data = [
                'name_id' => $request->name_id,
                'name_en' => $request->name_en,
                'name' => $request->name_id ?? $request->name_en, // Fallback for backward compatibility
                'description_id' => $request->description_id,
                'description_en' => $request->description_en,
                'description' => $request->description_id ?? $request->description_en, // Fallback for backward compatibility
                'price' => $request->price,
                'sort_order' => $request->sort_order,
                'is_active' => $request->has('is_active') ? 1 : 0
            ];

            // Handle icon upload
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                
                // Delete old icon if exists
                if ($service->icon) {
                    Storage::disk('public')->delete($service->icon);
                    $oldFile = public_path('storage/' . $service->icon);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                
                // Store new icon
                $iconPath = $file->store('icons', 'public');
                $data['icon'] = $iconPath;
                
                // Ensure directory exists in public/storage
                $publicPath = public_path('storage/' . dirname($iconPath));
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                
                // Copy file to public/storage for direct access
                $source = storage_path('app/public/' . $iconPath);
                $destination = public_path('storage/' . $iconPath);
                
                if (file_exists($source)) {
                    copy($source, $destination);
                }
                
                \Log::info('Service icon updated successfully', [
                    'service_id' => $service->id,
                    'path' => $iconPath,
                    'source' => $source,
                    'destination' => $destination,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'exists_source' => file_exists($source),
                    'exists_destination' => file_exists($destination)
                ]);
            }

            $service->update($data);

            // Log activity
            Log::info('Service updated', [
                'admin_id' => auth()->id(),
                'service_id' => $service->id,
                'service_name' => $data['name'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('admin.services.index')
                ->with('success', 'Layanan berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating service: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Service $service)
    {
        // Delete icon if exists
        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }

        $serviceName = $service->name;
        $service->delete();

        // Log activity
        Log::info('Service deleted', [
            'admin_id' => auth()->id(),
            'service_name' => $serviceName,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus');
    }
}
