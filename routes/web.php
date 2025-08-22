<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;

// Include admin routes
require __DIR__.'/admin.php';

// Route untuk mengganti bahasa (harus di atas route lain)
Route::get('lang/{locale}', [LanguageController::class, 'swap'])->name('lang.swap')->where('locale', 'id|en');

// Route test sederhana untuk memverifikasi locale
Route::get('test-locale', function() {
    return response()->json([
        'current_locale' => app()->getLocale(),
        'session_locale' => session('locale'),
        'available_locales' => ['en', 'id'],
        'test_translation' => [
            'en' => __('messages.navHome'),
            'id' => app('translator')->getFromJson('messages.navHome', [], 'id')
        ]
    ]);
});

// Route untuk halaman utama, dengan parameter {section} yang opsional
// Parameter ini digunakan untuk menentukan section mana yang akan diprioritaskan
Route::get('/{section?}', [PageController::class, 'index'])->name('home');