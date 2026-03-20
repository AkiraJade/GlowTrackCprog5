<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user) {
                $unreadCount = $user->notifications()->unread()->count();
                $recentNotifications = $user->notifications()->latest()->take(5)->get();
                $view->with(compact('unreadCount', 'recentNotifications'));
            } else {
                $view->with(['unreadCount' => 0, 'recentNotifications' => collect()]);
            }
        });
    }
}
