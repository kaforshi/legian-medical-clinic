<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        // Skip localization for admin routes
        if ($request->is('admin*')) {
            return $next($request);
        }
        
        // Jika ada data 'locale' di session, atur bahasa aplikasi sesuai session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            // Pastikan locale valid
            if (in_array($locale, ['id', 'en'])) {
                App::setLocale($locale);
                Log::debug("Locale set from session: " . $locale);
            } else {
                Log::warning("Invalid locale in session: " . $locale);
                // Reset ke default jika tidak valid
                Session::forget('locale');
                App::setLocale('en');
            }
        } else {
            // Set default locale jika tidak ada di session
            App::setLocale('en');
            Log::debug("Default locale set: en");
        }
        
        // Lanjutkan request
        return $next($request);
    }
}