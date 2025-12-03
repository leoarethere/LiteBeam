<?php

namespace App\Http\Controllers;

use App\Models\HymneTvri;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HymneTvriController extends Controller
{
    /**
     * Menampilkan daftar himne untuk frontend publik.
     */
    public function index()
    {
        // Ambil data yang aktif, urutkan terbaru
        $hymnes = HymneTvri::where('is_active', true)
                           ->latest()
                           ->paginate(5);

        return view('frontend.tentang.hymne-tvri', compact('hymnes'));
    }
}