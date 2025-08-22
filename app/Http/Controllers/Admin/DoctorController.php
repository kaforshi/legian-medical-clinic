<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\ActivityLog;
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
            $data['photo'] = $photoPath;
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
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $oldValues = $doctor->toArray();
        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($doctor->photo) {
                Storage::disk('public')->delete($doctor->photo);
            }
            
            $photoPath = $request->file('photo')->store('doctors', 'public');
            $data['photo'] = $photoPath;
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

