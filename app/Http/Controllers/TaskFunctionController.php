<?php

namespace App\Http\Controllers;

use App\Models\TaskFunction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskFunctionController extends Controller
{
    public function index()
    {
        // Ambil data tugas (type = 'tugas') yang aktif, urutkan berdasarkan order
        $tugas = TaskFunction::where('type', 'tugas')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Ambil data fungsi (type = 'fungsi') yang aktif, urutkan berdasarkan order
        $fungsi = TaskFunction::where('type', 'fungsi')
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