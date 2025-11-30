<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        // Clear cache sementara untuk debugging (opsional, bisa dihapus nanti)
        // Cache::forget('homepage.slides');
        // Cache::forget('homepage.data');

        // ... (Kode $heroSlides biarkan saja jika masih dipakai untuk slider lain) ...
        $heroSlides = Cache::remember('homepage.slides', 3600, function () {
            return Banner::where('is_active', true)
                ->orderBy('order')
                ->get()
                ->map(fn($banner) => [
                    'image'       => Storage::url($banner->image_path),
                    'title'       => $banner->title,
                    'subtitle'    => $banner->subtitle,
                    'link'        => $banner->link,
                    'button_text' => $banner->button_text,
                ])
                ->toArray();
        });

        $data = Cache::remember('homepage.data', 3600, function () {
            return [
                // 1. TAMBAHKAN INI: Data Khusus untuk Hero Slider Postingan
                // Mengambil 5 postingan terbaru yang PUNYA GAMBAR
                'heroPosts' => Post::with(['user', 'category'])
                    ->where('status', 'published')
                    ->whereNotNull('featured_image') // Wajib ada gambar
                    ->latest('published_at')
                    ->take(5)
                    ->get(),

                // Data postingan list biasa (di bawah slider)
                'latestPosts' => Post::with(['user', 'category'])
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->take(6)
                    ->get(),
                
                'categories' => Category::withCount('posts')
                    ->having('posts_count', '>', 0)
                    ->orderByDesc('posts_count')
                    ->take(8)
                    ->get(),
                    
                'stats' => [
                    'posts' => Post::where('status', 'published')->count(),
                    'categories' => Category::count(),
                    'users' => User::count(),
                ]
            ];
        });
        
        // Menggabungkan semua data untuk dikirim ke View
        return view('frontend.beranda.index', array_merge([
            'title'      => 'Beranda - TVRI Yogyakarta',
            'heroSlides' => $heroSlides,
        ], $data));
    }
}