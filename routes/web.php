<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// == HALAMAN FRONTEND ==

// Rute Beranda (menunjuk ke HomeController yang berisi semua data)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute Statis
Route::view('/about', 'about', ['title' => 'About'])->name('about');
Route::view('/contact', 'contact', ['title' => 'Contact'])->name('contact');

// Rute untuk Blog (Postingan) yang ditangani oleh PostController
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Rute untuk Kategori dan Penulis
Route::get('/categories/{category:slug}', [PostController::class, 'category'])->name('categories.show');
Route::get('/authors/{user:username}', [PostController::class, 'author'])->name('authors.show');


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

    // Resource routes untuk manajemen banner dan postingan
    Route::resource('/banners', BannerController::class)->except(['show']);
    Route::resource('/posts', DashboardPostController::class)->names('dashboard.posts');
});
