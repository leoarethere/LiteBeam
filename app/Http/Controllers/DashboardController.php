<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; // Import DB Facade

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Kartu Statistik
        $totalPosts = Post::count();
        $totalUsers = User::count();

        // 2. Data untuk Grafik Statistik (Contoh: Pengunjung 9 bulan terakhir)
        // Ini adalah contoh query, sesuaikan dengan tabel dan logika Anda
        $visitorStats = DB::table('visitors')
                            ->select(DB::raw('COUNT(id) as count'))
                            ->where('created_at', '>', now()->subMonths(9))
                            ->groupBy(DB::raw('MONTH(created_at)'))
                            ->pluck('count') // ->pluck() untuk mendapatkan array langsung
                            ->toArray();

        // 3. Data untuk Aktivitas Terbaru (Contoh: 5 user terakhir yang mendaftar)
        $recentActivities = User::latest()->take(5)->get();

        // 4. Kirim semua data ke view
        return view('backend.dashboard.index', [
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'visitorStats' => $visitorStats,
            'recentActivities' => $recentActivities,
        ]);
    }
}