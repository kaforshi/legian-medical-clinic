<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\ContentPage;
use App\Models\ActivityLog;
use App\Models\AdminUser;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Handle language switching
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            if (in_array($locale, ['id', 'en'])) {
                app()->setLocale($locale);
                session(['locale' => $locale]);
            }
        }

        $stats = [
            'total_doctors' => Doctor::count(),
            'active_doctors' => Doctor::where('is_active', true)->count(),
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),

            'content_pages' => ContentPage::count(),
            'recent_activities' => ActivityLog::with('adminUser')
                                              ->latest()
                                              ->take(10)
                                              ->get(),
            'admin_users' => AdminUser::count(),
            'today_logins' => ActivityLog::where('action', 'login')
                                        ->whereDate('created_at', today())
                                        ->count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}

