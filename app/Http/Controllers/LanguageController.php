<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function swap($locale)
    {
        // Pastikan locale yang dipilih valid (id atau en)
        if (in_array($locale, ['id', 'en'])) {
            // Simpan locale ke session
            Session::put('locale', $locale);
        }
        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }
}