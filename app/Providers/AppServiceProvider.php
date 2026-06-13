<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Ye line add karni hai

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // <-- Ye 3 lines add karni hain
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // Sidebar mein Cafe dynamic data dikhane ke liye
        \Illuminate\Support\Facades\View::composer('layouts.sidebar', function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $currentCafe = \App\Models\Cafe::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
                $view->with('currentCafe', $currentCafe);
            }
        });
    }
}