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
            abort(400, 'Invalid locale');
        }

        // Set locale baru
        App::setLocale($locale);
        Session::put('locale', $locale);

        // Redirect kembali ke halaman sebelumnya atau home
        return redirect()->back()->with('success', 'Language changed successfully');
    }
}