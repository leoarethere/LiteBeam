<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TugasFungsiController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\DashboardPpidController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardHistoryController;
use App\Http\Controllers\DashboardPrestasiController;
use App\Http\Controllers\DashboardVisiMisiController;
use App\Http\Controllers\DashboardBroadcastController;
use App\Http\Controllers\DashboardHymneTvriController;
use App\Http\Controllers\DashboardInfoMagangController;
use App\Http\Controllers\DashboardJadwalAcaraController;
use App\Http\Controllers\DashboardReformasiRbController;
use App\Http\Controllers\DashboardTugasFungsiController;
use App\Http\Controllers\DashboardPostCategoryController;
use App\Http\Controllers\DashboardInfoKunjunganController;
use App\Http\Controllers\DashboardBroadcastCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == HALAMAN FRONTEND (Publik) ==
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
Route::get('/tugas-fungsi', [\App\Http\Controllers\TugasFungsiController::class, 'index'])->name('tugas-fungsi');
Route::get('/sejarah', [HistoryController::class, 'index'])->name('sejarah');

// == AUTENTIKASI ==
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    
    // ✅ ROUTES LUPA PASSWORD
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

// == HALAMAN BACKEND / DASHBOARD ==
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::resource('/broadcasts', DashboardBroadcastController::class)->names('dashboard.broadcasts');
    Route::resource('/banners', BannerController::class)->except(['show']);
    Route::resource('/posts', DashboardPostController::class)->names('dashboard.posts');
    Route::resource('/visi-misi', DashboardVisiMisiController::class)->names('dashboard.visi-misi');
    Route::resource('/sejarah', DashboardHistoryController::class)->names('dashboard.sejarah')->parameters(['sejarah' => 'history']);
    
    Route::post('/broadcast-categories', [DashboardBroadcastCategoryController::class, 'store'])->name('dashboard.broadcast-categories.store');
    Route::put('/broadcast-categories/{broadcastCategory}', [DashboardBroadcastCategoryController::class, 'update'])->name('dashboard.broadcast-categories.update');
    Route::delete('/broadcast-categories/{broadcastCategory}', [DashboardBroadcastCategoryController::class, 'destroy'])->name('dashboard.broadcast-categories.destroy');
    
    Route::post('/categories', [DashboardPostCategoryController::class, 'store'])->name('dashboard.categories.store');
    Route::put('/categories/{category}', [DashboardPostCategoryController::class, 'update'])->name('dashboard.categories.update');
    Route::delete('/categories/{category}', [DashboardPostCategoryController::class, 'destroy'])->name('dashboard.categories.destroy');

    Route::resource('/tugas-fungsi', DashboardTugasFungsiController::class)->names('dashboard.tugas-fungsi')->parameters(['tugas-fungsi' => 'tugasFungsi']);
    Route::resource('/ppid', \App\Http\Controllers\DashboardPpidController::class)->names('dashboard.ppid')->parameters(['ppid' => 'ppid']);
    Route::resource('/jadwal-acara', \App\Http\Controllers\DashboardJadwalAcaraController::class)->names('dashboard.jadwal-acara')->parameters(['jadwal-acara' => 'jadwalAcara']);
    Route::resource('/prestasi', \App\Http\Controllers\DashboardPrestasiController::class)->names('dashboard.prestasi')->parameters(['prestasi' => 'prestasi']);
    Route::resource('/himne-tvri', \App\Http\Controllers\DashboardHymneTvriController::class)->names('dashboard.hymne-tvri')->parameters(['himne-tvri' => 'hymneTvri']);
    Route::resource('/info-rb', \App\Http\Controllers\DashboardReformasiRbController::class)->names('dashboard.reformasi-rb')->parameters(['info-rb' => 'reformasiRb']);
    Route::resource('/info-magang', \App\Http\Controllers\DashboardInfoMagangController::class)->names('dashboard.info-magang')->parameters(['info-magang' => 'infoMagang']);
    Route::resource('/info-kunjungan', \App\Http\Controllers\DashboardInfoKunjunganController::class)->names('dashboard.info-kunjungan')->parameters(['info-kunjungan' => 'infoKunjungan']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');

Route::get('/cek-php', function () {
    phpinfo();
});