<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HistoryController extends Controller
{
    /**
     * Menampilkan halaman Sejarah publik.
     */
    public function index()
    {
        // Mengambil data history yang sudah dipublikasikan, diurutkan kronologis
        $histories = History::where('status', 'published')->oldest()->get(); 

        return view('frontend.tentang.sejarah', [
            'title'     => 'Sejarah TVRI Stasiun D.I. Yogyakarta',
            'histories' => $histories
        ]);
    }
}