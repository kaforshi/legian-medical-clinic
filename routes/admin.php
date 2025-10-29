<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\FaqController;





// Admin routes group
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Authentication routes (public)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    
    // Registration routes (public)
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
    
    // Password reset routes (public)
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    
    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Doctor management
        Route::resource('doctors', DoctorController::class);
        
        // Service management
        Route::resource('services', ServiceController::class);
        
                        // Content management
                Route::get('content', [ContentController::class, 'index'])->name('content.index');
                Route::get('content/{pageKey}/edit', [ContentController::class, 'edit'])->name('content.edit');
                Route::put('content/{pageKey}', [ContentController::class, 'update'])->name('content.update');
                
                // FAQ management
                Route::resource('faqs', FaqController::class);
                Route::patch('faqs/{faq}/toggle-status', [FaqController::class, 'toggleStatus'])->name('faqs.toggle-status');
        

    });
});
