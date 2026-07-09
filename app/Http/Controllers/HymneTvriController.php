<?php

namespace App\Http\Controllers;

use App\Models\HymneTvri;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HymneTvriController extends Controller
{
    public function index()
    {
        // Only show active hymne records to public visitors
        $hymnes = HymneTvri::where('is_active', true)->latest()->paginate(5);

        return view('frontend.tentang.hymne-tvri', compact('hymnes'));
    }
}