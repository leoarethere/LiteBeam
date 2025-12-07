<?php

namespace App\Providers;

use App\Models\SocialMedia; // <--- Import View
use Illuminate\Support\Facades\View; // <--- Import Schema
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider; // <--- Import Model SocialMedia


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
        // 1. Bagikan data SocialMedia ke SEMUA view
        // Menggunakan closure agar query hanya dijalankan saat view dirender
        View::composer('*', function ($view) {
            // Cache sederhana bisa ditambahkan di sini jika perlu
            $socialMedia = SocialMedia::first() ?? new SocialMedia();
            $view->with('socialMedia', $socialMedia);
        });

        // 2. (Opsional) Jika pakai Pagination Custom (misal Tailwind)
        // Paginator::useTailwind(); 
    }
}