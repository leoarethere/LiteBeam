<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Banner;
use App\Models\Broadcast;
use App\Models\InfoMagang;
use App\Models\JadwalAcara;
use App\Models\InfoKunjungan;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil Statistik Data untuk Grid Kartu
        $stats = [
            'totalPosts'      => Post::count(),
            'totalBroadcasts' => Broadcast::count(),
            'totalJadwal'     => JadwalAcara::count(),
            'totalMagang'     => InfoMagang::count(),
            'totalKunjungan'  => InfoKunjungan::count(),
            'totalBanners'    => Banner::count(),
            'totalUsers'      => User::count(),
            
            // Statistik Tambahan
            'todayPosts'      => Post::whereDate('created_at', today())->count(),
        ];

        // 2. Mengambil Aktivitas Terbaru (5 User Terakhir)
        $recentActivities = User::latest()->take(5)->get();

        // 3. Mengirim semua data ke View
        return view('backend.dashboard.index', array_merge($stats, [
            'recentActivities' => $recentActivities,
        ]));
    }
}