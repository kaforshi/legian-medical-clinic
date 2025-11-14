<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.account.index', compact('user'));
    }

    public function updateUsername(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();

            $request->validate([
                'username' => 'required|string|max:255|unique:admin_users,username,' . $user->id,
            ], [], [
                'username' => 'Username',
            ]);

            $oldValues = $user->toArray();
            $oldUsername = $user->username;

            $user->update([
                'username' => $request->username,
            ]);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => $user->id,
                'action' => 'update',
                'model_type' => 'AdminUser',
                'model_id' => $user->id,
                'description' => "Updated username from {$oldUsername} to {$user->username}",
                'old_values' => $oldValues,
                'new_values' => $user->toArray(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Logout user after username change
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                            ->with('success', 'Username berhasil diperbarui. Silakan login kembali dengan username baru.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating username: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();

            $request->validate([
                'current_password' => 'required|string',
                'password' => ['required', 'string', 'confirmed', PasswordRule::min(8)],
            ], [], [
                'current_password' => 'Password saat ini',
                'password' => 'Password baru',
                'password_confirmation' => 'Konfirmasi password',
            ]);

            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                                ->withErrors(['current_password' => 'Password saat ini tidak cocok.'])
                                ->withInput();
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            // Log activity
            ActivityLog::create([
                'admin_user_id' => $user->id,
                'action' => 'update',
                'model_type' => 'AdminUser',
                'model_id' => $user->id,
                'description' => 'Password updated',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Logout user after password change
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                            ->with('success', 'Password berhasil diperbarui. Silakan login kembali dengan password baru.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating password: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }
}

