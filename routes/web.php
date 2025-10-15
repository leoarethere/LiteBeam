<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route; // Controller baru
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController; // <-- Tambahkan ini
use App\Http\Controllers\DashboardPostController;     // <-- Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == HALAMAN FRONTEND ==
Route::get('/', function () {
    return view('frontend.beranda.index', ['title' => 'Halaman Beranda']);
});
Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});
Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact']);
});

// Route untuk Blog (Postingan) yang ditangani oleh PostController
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::get('/categories/{category:slug}', [PostController::class, 'category']);
Route::get('/authors/{user:username}', [PostController::class, 'author']);


// == AUTENTIKASI ==
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});


// == HALAMAN BACKEND / DASHBOARD ==
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // DIPERBAIKI: Hanya gunakan Route::resource, hapus duplikat di bawahnya
    Route::resource('/dashboard/posts', DashboardPostController::class);
});

// KODE BERMASALAH DI BAWAH INI SUDAH DIHAPUS

// Route untuk menampilkan postingan berdasarkan kategori
Route::get('/category/{category:slug}', function (Category $category) {
    return view('frontend.postingan.kategori', [
        'title' => 'Postingan di Kategori: ' . $category->name,
        'posts' => $category->posts()->latest()->paginate(6)
    ]);
});

// Route untuk menampilkan postingan berdasarkan penulis
Route::get('/author/{user:username}', function (User $user) {
    return view('frontend.postingan.author', [
        'title' => 'Postingan oleh: ' . $user->name,
        'posts' => $user->posts()->latest()->paginate(6)
    ]);
});