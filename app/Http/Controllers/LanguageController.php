<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function swap($locale)
    {
        // Validasi locale yang diizinkan
        if (!in_array($locale, ['id', 'en'])) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Invalid locale'], 400);
            }
            abort(400, 'Invalid locale');
        }

        // Set locale baru
        App::setLocale($locale);
        Session::put('locale', $locale);

        // Jika request AJAX, return JSON response
        if (request()->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Language changed successfully',
                'locale' => $locale
            ]);
        }

        // Redirect kembali ke halaman sebelumnya atau home untuk non-AJAX request
        return redirect()->back()->with('success', 'Language changed successfully');
    }
}