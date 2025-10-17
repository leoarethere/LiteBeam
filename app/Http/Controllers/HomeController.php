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
    /**
     * Menampilkan halaman beranda dengan semua data yang diperlukan.
     */
    public function index()
    {
        // Ambil data slides dari cache, atau dari database jika cache kosong
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

        // Ambil data lain untuk halaman beranda (postingan, kategori, statistik)
        $data = Cache::remember('homepage.data', 3600, function () {
            return [
                'latestPosts' => Post::with(['author:id,name', 'category:id,name,slug'])->latest()->take(6)->get(),
                'categories' => Category::withCount('posts')->having('posts_count', '>', 0)->orderByDesc('posts_count')->take(8)->get(),
                'stats' => [
                    'posts' => Post::count(),
                    'categories' => Category::count(),
                    'users' => User::count(),
                ]
            ];
        });
        
        // Kirim semua data ke view
        return view('frontend.beranda.index', array_merge([
            'title'      => 'Beranda - TVRI Yogyakarta',
            'heroSlides' => $heroSlides,
        ], $data));
    }
}