<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik Utama
        $totalPosts = Post::count();
        $totalUsers = User::count();

        // 2. Data Dummy/Kosong untuk Grafik (Agar tidak error)
        $visitorStats = [0, 0, 0, 0, 0, 0, 0, 0, 0]; 

        // 3. Aktivitas Terbaru
        $recentActivities = User::latest()->take(5)->get();

        return view('backend.dashboard.index', [
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'visitorStats' => $visitorStats,
            'recentActivities' => $recentActivities,
            // Kita hapus totalVisitors & uniqueVisitors agar view tidak bingung
        ]);
    }
}