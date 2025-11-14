<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;

// Include admin routes
require __DIR__.'/admin.php';

// Route untuk mengganti bahasa (harus di atas route lain)
Route::get('lang/{locale}', [LanguageController::class, 'swap'])->name('lang.swap')->where('locale', 'id|en');

// Route untuk clear priority section
Route::post('/clear-priority', [PageController::class, 'clearPriority'])->name('clear.priority');

// Route untuk halaman utama, dengan parameter {section} yang opsional
// Parameter ini digunakan untuk menentukan section mana yang akan diprioritaskan
Route::get('/{section?}', [PageController::class, 'index'])->name('home');