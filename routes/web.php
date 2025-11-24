<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\BroadcastController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\DashboardHistoryController;
use App\Http\Controllers\DashboardVisiMisiController;
use App\Http\Controllers\DashboardBroadcastController;
use App\Http\Controllers\DashboardPostCategoryController;
use App\Http\Controllers\DashboardBroadcastCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == HALAMAN FRONTEND (Publik) ==
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute Statis
Route::view('/about', 'about', ['title' => 'About'])->name('about');
Route::view('/contact', 'contact', ['title' => 'Contact'])->name('contact');

// Rute Blog (Postingan)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Rute Penyiaran (Publik)
Route::get('/penyiaran', [BroadcastController::class, 'index'])->name('broadcasts.index');
Route::get('/penyiaran/{broadcast:slug}', [BroadcastController::class, 'show'])->name('broadcasts.show');

// Rute Filter (Postingan)
Route::get('/categories/{category:slug}', [PostController::class, 'category'])->name('categories.show');
Route::get('/authors/{user:username}', [PostController::class, 'author'])->name('authors.show');

Route::get('/visi-misi', [VisiMisiController::class, 'visiMisi'])->name('visi-misi');

// == AUTENTIKASI ==
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// == HALAMAN BACKEND / DASHBOARD ==
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Resource routes
    Route::resource('/broadcasts', DashboardBroadcastController::class)->names('dashboard.broadcasts');
    Route::resource('/banners', BannerController::class)->except(['show']);
    Route::resource('/posts', DashboardPostController::class)->names('dashboard.posts');
    Route::resource('/visi-misi', DashboardVisiMisiController::class)->names('dashboard.visi-misi');
    
    // 👇 ROUTE SEJARAH (URL: /dashboard/sejarah)
    Route::resource('/sejarah', DashboardHistoryController::class)->names('dashboard.sejarah')->parameters(['sejarah' => 'history']); // <--- TAMBAHKAN BARIS INI

    // Rute Kategori Penyiaran (Modal)
    Route::post('/broadcast-categories', [DashboardBroadcastCategoryController::class, 'store'])->name('dashboard.broadcast-categories.store');
    Route::put('/broadcast-categories/{broadcastCategory}', [DashboardBroadcastCategoryController::class, 'update'])->name('dashboard.broadcast-categories.update');
    Route::delete('/broadcast-categories/{broadcastCategory}', [DashboardBroadcastCategoryController::class, 'destroy'])->name('dashboard.broadcast-categories.destroy');
    
    // Rute Kategori Postingan (Modal)
    Route::post('/categories', [DashboardPostCategoryController::class, 'store'])->name('dashboard.categories.store');
    Route::put('/categories/{category}', [DashboardPostCategoryController::class, 'update'])->name('dashboard.categories.update');
    Route::delete('/categories/{category}', [DashboardPostCategoryController::class, 'destroy'])->name('dashboard.categories.destroy');
});

// == FITUR UTILITAS ==
Route::get('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');

Route::get('/cek-php', function () {
    phpinfo();
});