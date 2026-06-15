<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- 1. PASTIKAN BARIS INI ADA

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
        // 2. TAMBAHKAN KODINGAN INI DI DALAM BOOT
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}