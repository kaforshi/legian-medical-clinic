<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AdminUserController;





// Admin routes group
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Authentication routes (public)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    
    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Doctor management
        Route::resource('doctors', DoctorController::class)->except(['show']);
        
        // Service management
        Route::resource('services', ServiceController::class)->except(['show']);
        
                        // Content management
                Route::get('content', [ContentController::class, 'index'])->name('content.index');
                Route::get('content/{pageKey}/edit', [ContentController::class, 'edit'])->name('content.edit');
                Route::put('content/{pageKey}', [ContentController::class, 'update'])->name('content.update');
                
                // FAQ management
                Route::resource('faqs', FaqController::class)->except(['show']);
                Route::patch('faqs/{faq}/toggle-status', [FaqController::class, 'toggleStatus'])->name('faqs.toggle-status');
        
                // User management (only for super admin)
                Route::middleware('super_admin')->group(function () {
                    Route::resource('users', AdminUserController::class)->except(['show']);
                });

    });
});
