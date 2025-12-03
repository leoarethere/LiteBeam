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
        // Mengatur panjang string default database (opsional tapi disarankan)
        Schema::defaultStringLength(191);

        // Share data SocialMedia ke semua views jika tabelnya ada
        if (Schema::hasTable('social_medias')) {
            $socialMedia = SocialMedia::first();
            // Jika belum ada data, buat objek kosong agar tidak error di view
            View::share('socialMedia', $socialMedia ?? new SocialMedia());
        }
    }
}