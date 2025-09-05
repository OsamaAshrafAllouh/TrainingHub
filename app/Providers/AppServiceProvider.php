<?php

namespace App\Providers;

use App\Models\Advisor;
use App\Models\Notification;
use App\Models\Trainee;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure SSL CA bundle is set at runtime (covers cases where Apache uses a different php.ini)
//        $candidates = [];
//        if (function_exists('public_path')) {
//            $candidates[] = public_path('certs/cacert.pem');
//            $candidates[] = public_path('cacert.pem');
//        }
//        $candidates[] = 'C:\\php\\php-8.2.29-nts-Win32-vs16-x64\\extras\\ssl\\cacert.pem';
//
//        $caBundlePath = null;
//        foreach ($candidates as $candidate) {
//            if (is_string($candidate) && is_file($candidate)) {
//                $caBundlePath = $candidate;
//                break;
//            }
//        }
//
//        if (is_string($caBundlePath) && is_file($caBundlePath)) {
//            @ini_set('curl.cainfo', $caBundlePath);
//            @ini_set('openssl.cafile', $caBundlePath);
//        }
//
//        $notifications = Notification::where('status', 'unread')->orderByDesc('created_at')
//            ->get();
//        $count = Notification::where('status', 'unread')->count();
//
//        foreach ($notifications as $notification) {
//            $trainee = Trainee::where('notification_id', $notification->id)->first();
//            if ($trainee) {
//                $notification->link = 'http://127.0.0.1:8000/trainees/' . $trainee->id;
//            } else {
//                $advisor = Advisor::where('notification_id', $notification->id)->first();
//                if ($advisor) {
//                    $notification->link = 'http://127.0.0.1:8000/advisors/' . $advisor->id;
//                }
//            }
//
//        }
//
//        // Share the data with all views
//        View::share('notifications', $notifications);
//        View::share('count', $count);
    }
}
