<?php

namespace App\Http\Controllers;

use App\Models\TugasFungsi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TugasFungsiController extends Controller
{
    public function index()
    {
        // 3. Gunakan Model Baru
        $tugas = TugasFungsi::where('type', 'tugas')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $fungsi = TugasFungsi::where('type', 'fungsi')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('frontend.tentang.tugas-fungsi', [
            'title' => 'Tugas dan Fungsi',
            'tugas' => $tugas,
            'fungsi' => $fungsi
        ]);
    }
}