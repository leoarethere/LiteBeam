<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PrestasiController extends Controller
{
    public function index()
    {
        // Ambil data prestasi yang AKTIF, urutkan dari tahun terbaru
        $prestasis = Prestasi::where('is_active', true)
                             ->orderBy('year', 'desc')
                             ->latest()
                             ->paginate(5); // 5 per halaman agar tidak terlalu panjang

        return view('frontend.tentang.prestasi', compact('prestasis'));
    }
}