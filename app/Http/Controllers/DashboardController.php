<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
// 👇 1. Import Model Visit dari package
use Shetabit\Visitor\Models\Visit;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Kartu Statistik
        $totalPosts = Post::count();
        $totalUsers = User::count();

        // 👇 2. AMBIL DATA PENGUNJUNG REAL DARI PACKAGE
        
        // Total semua kunjungan (Hits)
        $totalVisitors = Visit::count();
        
        // Pengunjung Unik (Berdasarkan IP)
        $uniqueVisitors = Visit::distinct('ip')->count('ip');

        // Opsional: Pengunjung online saat ini (dalam 3 menit terakhir)
        // $onlineVisitors = Visit::where('updated_at', '>=', now()->subMinutes(3))->count();

        // 3. Data untuk Aktivitas Terbaru (User baru daftar)
        $recentActivities = User::latest()->take(5)->get();

        // 4. Kirim data ke view
        return view('backend.dashboard.index', [
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            // Gunakan nama variabel yang sesuai dengan yang ada di Blade Anda
            // Jika di blade pakai $visitorStats untuk grafik, kita kirim data grafik sederhana:
            'visitorStats' => $this->getVisitorChartData(), 
            'recentActivities' => $recentActivities,
            
            // Kirim data tambahan ini untuk ditampilkan di kartu
            'totalVisitors' => $totalVisitors,
            'uniqueVisitors' => $uniqueVisitors,
        ]);
    }

    // Fungsi bantuan untuk membuat data grafik 9 bulan terakhir
    private function getVisitorChartData()
    {
        // Mengambil data jumlah kunjungan per bulan untuk 9 bulan terakhir
        $data = Visit::select(DB::raw('COUNT(id) as count'), DB::raw('MONTH(created_at) as month'))
            ->where('created_at', '>', now()->subMonths(9))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();
            
        // Jika data kosong (karena baru install), beri array dummy agar grafik tidak error
        return empty($data) ? [0, 0, 0, 0, 0, 0, 0, 0, 0] : $data;
    }
}