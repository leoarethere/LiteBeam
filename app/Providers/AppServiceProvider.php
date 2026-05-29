<?php

namespace App\Providers;

use App\Models\SocialMedia;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
    public function boot()
    {
        // Mengirim data social media hanya ke komponen yang membutuhkannya (Navbar & Footer)
        View::composer(['components.navbar', 'components.footer'], function ($view) {
            if (!array_key_exists('socialMedia', $view->getData())) {
                $socialMedia = \Illuminate\Support\Facades\Cache::remember('global_social_media', 3600, function () {
                    return \App\Models\SocialMedia::first();
                });
                
                $view->with('socialMedia', $socialMedia);
            }
        });
    }
}