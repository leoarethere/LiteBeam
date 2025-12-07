<?php

namespace App\Http\Controllers;

use App\Models\HymneTvri;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HymneTvriController extends Controller
{
    public function index()
    {
        // HAPUS where('is_active', true)
        $hymnes = HymneTvri::latest()->paginate(5);

        return view('frontend.tentang.hymne-tvri', compact('hymnes'));
    }
}   