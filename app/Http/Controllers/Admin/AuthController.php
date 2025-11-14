<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = AdminUser::where('username', $request->username)
                         ->where('is_active', true)
                         ->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'username' => ['Kredensial yang diberikan tidak cocok.'],
            ]);
        }

        Auth::guard('admin')->login($admin);
        
        // Update last login
        $admin->last_login_at = now();
        $admin->save();

        // Log activity
        ActivityLog::create([
            'admin_user_id' => $admin->id,
            'action' => 'login',
            'description' => 'Admin logged in successfully',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        if ($admin) {
            // Log activity
            ActivityLog::create([
                'admin_user_id' => $admin->id,
                'action' => 'logout',
                'description' => 'Admin logged out',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

