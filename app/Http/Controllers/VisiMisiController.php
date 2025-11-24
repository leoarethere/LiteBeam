<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

// [PERUBAHAN] Nama Class Diubah dari PageController ke VisiMisiController
class VisiMisiController extends Controller
{
    public function visiMisi()
    {
        $title = 'Visi dan Misi';

        // Ambil Visi (Biasanya cuma 1 yang utama, ambil yang urutan pertama)
        $visi = VisiMisi::where('type', 'visi')
                        ->where('is_active', true)
                        ->orderBy('order', 'asc')
                        ->first();

        // Ambil semua Misi
        $misis = VisiMisi::where('type', 'misi')
                         ->where('is_active', true)
                         ->orderBy('order', 'asc')
                         ->get();

        return view('frontend.tentang.visi-misi', compact('title', 'visi', 'misis'));
    }
}