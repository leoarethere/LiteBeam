<?php

namespace App\Http\Controllers;

use App\Models\InfoMagang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InfoMagangController extends Controller
{
    /**
     * Menampilkan halaman publik informasi magang.
     */
    public function index(Request $request)
    {
        // Ambil data yang aktif saja
        $query = InfoMagang::where('is_active', true);

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Urutkan dari yang terbaru
        $items = $query->latest()->paginate(10);

        return view('frontend.info-magang.index', compact('items'));
    }
}