<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = AdminUser::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admin_users',
                'username' => 'required|string|max:255|unique:admin_users',
                'password' => ['required', 'string', 'confirmed', PasswordRule::min(8)],
                'role' => 'required|in:super_admin,admin',
                'is_active' => 'boolean'
            ], [], [
                'name' => 'Nama',
                'email' => 'Email',
                'username' => 'Username',
                'password' => 'Password',
                'role' => 'Role',
            ]);

            $user = AdminUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action' => 'create',
                'model_type' => 'AdminUser',
                'model_id' => $user->id,
                'description' => "Created admin user: {$user->username}",
                'new_values' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'role' => $user->role,
                    'is_active' => $user->is_active,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('admin.users.index')
                            ->with('success', 'User admin berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating admin user: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(AdminUser $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, AdminUser $user)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admin_users,email,' . $user->id,
                'username' => 'required|string|max:255|unique:admin_users,username,' . $user->id,
                'role' => 'required|in:super_admin,admin',
                'is_active' => 'boolean'
            ];

            // Only validate password if it's provided
            if ($request->filled('password')) {
                $rules['password'] = ['string', 'confirmed', PasswordRule::min(8)];
            }

            $request->validate($rules, [], [
                'name' => 'Nama',
                'email' => 'Email',
                'username' => 'Username',
                'password' => 'Password',
                'role' => 'Role',
            ]);

            $oldValues = $user->toArray();
            
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'role' => $request->role,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ];

            // Update password only if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => Auth::guard('admin')->id(),
                'action' => 'update',
                'model_type' => 'AdminUser',
                'model_id' => $user->id,
                'description' => "Updated admin user: {$user->username}",
                'old_values' => $oldValues,
                'new_values' => $user->toArray(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('admin.users.index')
                            ->with('success', 'Data user admin berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating admin user: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Request $request, AdminUser $user)
    {
        // Prevent deleting own account
        if ($user->id === Auth::guard('admin')->id()) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $userName = $user->username;
        $user->delete();

        // Log activity
        ActivityLog::create([
            'admin_user_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'model_type' => 'AdminUser',
            'model_id' => $user->id,
            'description' => "Deleted admin user: {$userName}",
            'old_values' => $user->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User admin berhasil dihapus.');
    }
}

