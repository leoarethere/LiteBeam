<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use Illuminate\Http\Request;
use App\Models\BroadcastCategory;
use Illuminate\Routing\Controller;

class BroadcastController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Program Penyiaran';
        $activeCategory = null; // [IMPROVISASI] Variabel untuk kategori aktif
        
        // [IMPROVISASI] Hanya ambil kategori yang punya program 'published'
        $categories = BroadcastCategory::whereHas('broadcasts', function ($query) {
            $query->where('status', 'published');
        })->orderBy('name')->get();

        // Query dasar
        $query = Broadcast::with('broadcastCategory')
                          ->where('status', 'published');

        // Filter berdasarkan Kategori
        if ($request->filled('category')) {
            // [IMPROVISASI] Gunakan data kategori yang sudah kita ambil
            $activeCategory = $categories->firstWhere('slug', $request->category);
            
            if ($activeCategory) {
                $title = 'Penyiaran di Kategori: ' . $activeCategory->name;
                $query->where('broadcast_category_id', $activeCategory->id);
            } else {
                // Jika slug kategori tidak valid, jangan tampilkan apa-apa
                $query->where('id', -1); // Trik untuk mengembalikan koleksi kosong
            }
        }

        // Urutkan dan Paginasi
        $broadcasts = $query->latest('published_at')
                            ->paginate(12) // [IMPROVISASI] Ubah ke 12 (6 kolom x 2 baris)
                            ->withQueryString();

        // Kirim data ke view
        return view('frontend.penyiaran.siaran', compact(
            'title', 
            'categories', 
            'broadcasts', 
            'activeCategory' // [IMPROVISASI] Kirim kategori aktif ke view
        ));
    }

    public function show(Broadcast $broadcast)
    {
        if ($broadcast->status !== 'published') {
            abort(404);
        }

        return view('frontend.penyiaran.detail', [
            'title' => $broadcast->title,
            'broadcast' => $broadcast
        ]);
    }
}