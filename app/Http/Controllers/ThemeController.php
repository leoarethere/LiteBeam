<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
// DIUBAH: Impor JsonResponse
use Illuminate\Routing\Controller;

class ThemeController extends Controller
{
    /**
     * Mengganti tema antara 'light' dan 'dark' dan menyimpannya di session.
     */
    // DIUBAH: Tipe return diubah ke JsonResponse
    public function toggle(): JsonResponse
    {
        // Ambil tema saat ini dari session, defaultnya 'light'
        $currentTheme = session('theme', 'light');

        // Ganti tema
        $newTheme = ($currentTheme === 'light') ? 'dark' : 'light';

        // Simpan tema baru ke dalam session
        session(['theme' => $newTheme]);

        // DIUBAH: Kembalikan respons JSON, bukan redirect
        return response()->json([
            'status' => 'success',
            'theme' => $newTheme
        ]);
    }
}