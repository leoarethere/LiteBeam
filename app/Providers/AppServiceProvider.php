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
    public function boot()
    {
        // Mengirim data social media ke semua view (Navbar & Footer butuh ini)
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $socialMedia = \Illuminate\Support\Facades\Cache::remember('global_social_media', 3600, function () {
                return \App\Models\SocialMedia::first() ?? new \App\Models\SocialMedia();
            });
            
            $view->with('socialMedia', $socialMedia);
        });
    }
}