<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Mail\AdminResetPasswordMail;

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
        $admin->update(['last_login_at' => now()]);

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

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'username' => 'required|string|max:255|unique:admin_users',
            'password' => ['required', 'string', 'confirmed', PasswordRule::min(8)],
        ]);

        $admin = AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Log activity
        ActivityLog::create([
            'admin_user_id' => $admin->id,
            'action' => 'create',
            'model_type' => 'AdminUser',
            'model_id' => $admin->id,
            'description' => 'New admin account created: ' . $admin->username,
            'new_values' => [
                'name' => $admin->name,
                'email' => $admin->email,
                'username' => $admin->username,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Auto login after registration
        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Akun admin berhasil dibuat!');
    }

    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admin_users,email',
        ]);

        $admin = AdminUser::where('email', $request->email)
                         ->where('is_active', true)
                         ->first();

        if (!$admin) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan atau akun tidak aktif.',
            ])->withInput();
        }

        // Generate token
        $token = Str::random(64);
        
        // Delete existing tokens for this email
        DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Insert new token
        DB::table('admin_password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Send reset password email
        try {
            Mail::to($admin->email)->send(new AdminResetPasswordMail($admin, $token));
        } catch (\Exception $e) {
            // Log error but don't expose to user
            \Log::error('Failed to send reset password email: ' . $e->getMessage());
            // Fallback: redirect with token (for development/testing)
            if (config('app.debug')) {
                return redirect()->route('admin.password.reset', ['token' => $token, 'email' => $request->email])
                    ->with('warning', 'Email gagal dikirim. Link reset password:');
            }
        }
        
        return back()
            ->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox email Anda (termasuk folder spam).');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Link reset password tidak valid.');
        }

        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:admin_users,email',
            'password' => ['required', 'string', 'confirmed', PasswordRule::min(8)],
        ]);

        $passwordReset = DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token tidak valid.'])->withInput();
        }

        // Check if token is valid (within 60 minutes)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            DB::table('admin_password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token telah kadaluarsa. Silakan request ulang.'])->withInput();
        }

        // Verify token
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token tidak valid.'])->withInput();
        }

        // Update password
        $admin = AdminUser::where('email', $request->email)->first();
        
        if (!$admin || !$admin->is_active) {
            return back()->withErrors(['email' => 'Akun tidak ditemukan atau tidak aktif.'])->withInput();
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete used token
        DB::table('admin_password_reset_tokens')->where('email', $request->email)->delete();

        // Log activity
        ActivityLog::create([
            'admin_user_id' => $admin->id,
            'action' => 'update',
            'model_type' => 'AdminUser',
            'model_id' => $admin->id,
            'description' => 'Password reset successfully',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}

