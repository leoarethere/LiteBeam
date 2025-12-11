<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PpidController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HymneTvriController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\InfoMagangController;
use App\Http\Controllers\ReformasiRbController;
use App\Http\Controllers\TugasFungsiController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\DashboardPpidController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\InfoKunjunganController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardHistoryController;
use App\Http\Controllers\DashboardPrestasiController;
use App\Http\Controllers\DashboardVisiMisiController;
use App\Http\Controllers\DashboardBroadcastController;
use App\Http\Controllers\DashboardHymneTvriController;
use App\Http\Controllers\DashboardInfoMagangController;
use App\Http\Controllers\DashboardContactInfoController;
use App\Http\Controllers\DashboardJadwalAcaraController;
use App\Http\Controllers\DashboardReformasiRbController;
use App\Http\Controllers\DashboardSocialMediaController;
use App\Http\Controllers\DashboardTugasFungsiController;
use App\Http\Controllers\DashboardPostCategoryController;
use App\Http\Controllers\DashboardInfoKunjunganController;
use App\Http\Controllers\DashboardJadwalCategoryController;
use App\Http\Controllers\DashboardBroadcastCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Definisi semua route aplikasi, baik untuk frontend (publik) maupun
| backend (dashboard/admin).
|
*/

// ================= FRONTEND =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about', ['title' => 'About'])->name('about');
Route::view('/contact', 'contact', ['title' => 'Contact'])->name('contact');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/penyiaran', [BroadcastController::class, 'index'])->name('broadcasts.index');
Route::get('/penyiaran/{broadcast:slug}', [BroadcastController::class, 'show'])->name('broadcasts.show');

Route::get('/categories/{category:slug}', [PostController::class, 'category'])->name('categories.show');
Route::get('/authors/{user:username}', [PostController::class, 'author'])->name('authors.show');

Route::get('/visi-misi', [VisiMisiController::class, 'visiMisi'])->name('visi-misi');
Route::get('/tugas-fungsi', [TugasFungsiController::class, 'index'])->name('tugas-fungsi');
Route::get('/sejarah', [HistoryController::class, 'index'])->name('sejarah');
Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');

Route::get('/jadwal-acara', [JadwalController::class, 'index'])->name('publikasi.jadwal');
Route::get('/publikasi/jadwal', [JadwalController::class, 'index'])->name('publikasi.jadwal');
Route::get('/ppid', [PpidController::class, 'index'])->name('ppid.index');
Route::get('/himne-tvri', [HymneTvriController::class, 'index'])->name('himne-tvri.index');
Route::get('/info-rb', [ReformasiRbController::class, 'index'])->name('info-rb.index');

Route::get('/info-magang', [InfoMagangController::class, 'index'])->name('info-magang.index');
Route::get('/info-kunjungan', [InfoKunjunganController::class, 'index'])->name('info-kunjungan.index');

Route::get('/streaming', [StreamingController::class, 'index'])->name('streaming');

// ================= AUTENTIKASI =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    // Lupa Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

// ================= DASHBOARD =================
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('/broadcasts', DashboardBroadcastController::class)->names('dashboard.broadcasts');
    Route::resource('/banners', BannerController::class)->except(['show']);
    Route::resource('/posts', DashboardPostController::class)->names('dashboard.posts');
    Route::resource('/visi-misi', DashboardVisiMisiController::class)->names('dashboard.visi-misi');
    Route::resource('/sejarah', DashboardHistoryController::class)->names('dashboard.sejarah')->parameters(['sejarah' => 'history']);

    // Kategori Broadcast
    Route::post('/broadcast-categories', [DashboardBroadcastCategoryController::class, 'store'])->name('dashboard.broadcast-categories.store');
    Route::put('/broadcast-categories/{broadcastCategory}', [DashboardBroadcastCategoryController::class, 'update'])->name('dashboard.broadcast-categories.update');
    Route::delete('/broadcast-categories/{broadcastCategory}', [DashboardBroadcastCategoryController::class, 'destroy'])->name('dashboard.broadcast-categories.destroy');

    // Kategori Post
    Route::post('/categories', [DashboardPostCategoryController::class, 'store'])->name('dashboard.categories.store');
    Route::put('/categories/{category}', [DashboardPostCategoryController::class, 'update'])->name('dashboard.categories.update');
    Route::delete('/categories/{category}', [DashboardPostCategoryController::class, 'destroy'])->name('dashboard.categories.destroy');

    Route::resource('/tugas-fungsi', DashboardTugasFungsiController::class)->names('dashboard.tugas-fungsi')->parameters(['tugas-fungsi' => 'tugasFungsi']);
    Route::resource('/ppid', DashboardPpidController::class)->names('dashboard.ppid')->parameters(['ppid' => 'ppid']);
    Route::resource('/jadwal-acara', DashboardJadwalAcaraController::class)->names('dashboard.jadwal-acara')->parameters(['jadwal-acara' => 'jadwalAcara']);
    Route::resource('/prestasi', DashboardPrestasiController::class)->names('dashboard.prestasi')->parameters(['prestasi' => 'prestasi']);
    Route::resource('/himne-tvri', DashboardHymneTvriController::class)->names('dashboard.hymne-tvri')->parameters(['himne-tvri' => 'hymneTvri']);
    Route::resource('/info-rb', DashboardReformasiRbController::class)->names('dashboard.reformasi-rb')->parameters(['info-rb' => 'reformasiRb']);
    Route::resource('/info-magang', DashboardInfoMagangController::class)->names('dashboard.info-magang')->parameters(['info-magang' => 'infoMagang']);
    Route::resource('/info-kunjungan', DashboardInfoKunjunganController::class)->names('dashboard.info-kunjungan')->parameters(['info-kunjungan' => 'infoKunjungan']);
    Route::resource('/users', DashboardUserController::class)->names('dashboard.users')->parameters(['users' => 'user']);

    // Social Media
    Route::resource('social-media', DashboardSocialMediaController::class)->names('dashboard.social-media')->parameters(['social-media' => 'id'])->only(['index', 'edit', 'update']);

    // Kategori Jadwal
    Route::post('/jadwal-categories', [\App\Http\Controllers\DashboardJadwalCategoryController::class, 'store'])->name('dashboard.jadwal-categories.store');
    Route::put('/jadwal-categories/{jadwalCategory}', [\App\Http\Controllers\DashboardJadwalCategoryController::class, 'update'])->name('dashboard.jadwal-categories.update');
    Route::delete('/jadwal-categories/{jadwalCategory}', [\App\Http\Controllers\DashboardJadwalCategoryController::class, 'destroy'])->name('dashboard.jadwal-categories.destroy');

    // Informasi Kontak
    Route::resource('contact-info', DashboardContactInfoController::class)->names('dashboard.contact-info')->parameters(['contact-info' => 'id'])->only(['index', 'edit', 'update']);

    // FAQ Info Magang
    Route::resource('/info-magang-faq', \App\Http\Controllers\DashboardInfoMagangFaqController::class)->names('dashboard.info-magang-faq')->parameters(['info-magang-faq' => 'id']);

    // FAQ Info Kunjungan
    Route::resource('/info-kunjungan-faq', \App\Http\Controllers\DashboardInfoKunjunganFaqController::class)->names('dashboard.info-kunjungan-faq')->parameters(['info-kunjungan-faq' => 'id']);
});

// ================= UTILITAS =================
Route::get('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');
Route::get('/cek-php', fn() => phpinfo());

Route::get('/symlink', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Symlink berhasil dibuat! Silakan cek folder public/storage.';
    } catch (\Exception $e) {
        return 'Gagal membuat symlink: ' . $e->getMessage();
    }
});