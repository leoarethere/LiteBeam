<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoKunjungan;
use Illuminate\Routing\Controller;

class InfoKunjunganController extends Controller
{
    /**
     * Menampilkan halaman publik informasi kunjungan.
     */
    public function index(Request $request)
    {
        // Ambil data yang aktif saja
        $query = InfoKunjungan::where('is_active', true);

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Urutkan dari yang terbaru
        $items = $query->latest()->paginate(10);

        return view('frontend.info-kunjungan.index', compact('items'));
    }
}