<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik Utama
        $totalPosts = Post::count();
        $totalUsers = User::count();
        
        // 2. Data untuk kartu tambahan (opsional, bisa dihapus jika tidak digunakan)
        $todayPosts = Post::whereDate('created_at', today())->count();
        $monthlyUsers = User::whereMonth('created_at', now())
                            ->whereYear('created_at', now())
                            ->count();

        // 3. Aktivitas Terbaru (5 pengguna terakhir)
        $recentActivities = User::latest()->take(5)->get();

        return view('backend.dashboard.index', [
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'todayPosts' => $todayPosts,
            'monthlyUsers' => $monthlyUsers,
            'recentActivities' => $recentActivities,
        ]);
    }
}