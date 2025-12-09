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

        // 1. Filter Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Sorting (Perbaikan disini)
        switch ($request->input('sort')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // 3. Eksekusi Pagination
        $items = $query->paginate(10)->withQueryString();

        return view('frontend.info-magang.index', compact('items'));
    }
}