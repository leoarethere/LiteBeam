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
        // Mengambil data history, diurutkan dari yang terbaru (atau terlama sesuai kebutuhan)
        // Kita gunakan 'oldest()' agar urut kronologis sejarah (Masa lalu -> Masa kini)
        $histories = History::oldest()->get(); 

        // Pointing ke resources/views/frontend/tentang/sejarah.blade.php
        return view('frontend.tentang.sejarah', [
            'title'     => 'Sejarah TVRI Yogyakarta',
            'histories' => $histories
        ]);
    }
}