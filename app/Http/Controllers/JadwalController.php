<?php

namespace App\Http\Controllers;

use App\Models\JadwalAcara;
use Illuminate\Http\Request;
use App\Models\JadwalCategory;
use Illuminate\Routing\Controller; // Import Model Hari

class JadwalController extends Controller
{
    /**
     * Menampilkan jadwal acara untuk publik.
     */
    public function index(Request $request)
    {
        // Eager load relasi hari dan jenis acara
        $query = JadwalAcara::with(['jadwalCategory', 'broadcastCategory'])
                            ->where('is_active', true);

        // 1. Filter Pencarian (Judul)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Hari (JadwalCategory) - INI YANG BARU
        if ($request->filled('day')) {
            $query->whereHas('jadwalCategory', function ($q) use ($request) {
                $q->where('slug', $request->day);
            });
        }

        // 3. Sorting: Urutkan berdasarkan Hari (ID) lalu Jam Tayang
        // Asumsi: ID 1=Senin, 2=Selasa, dst. (Sesuai urutan input)
        $jadwalAcaras = $query->orderBy('jadwal_category_id', 'asc')
                              ->orderBy('start_time', 'asc')
                              ->paginate(12) // 12 item per halaman
                              ->withQueryString();

        // Ambil daftar hari yang memiliki jadwal aktif untuk dropdown
        $days = JadwalCategory::whereHas('jadwalAcaras', function($q) {
            $q->where('is_active', true);
        })->orderBy('id')->get();

        return view('frontend.publikasi.jadwal', compact('jadwalAcaras', 'days'));
    }
}