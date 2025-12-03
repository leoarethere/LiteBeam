<?php

namespace App\Http\Controllers;

use App\Models\ReformasiRb;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReformasiRbController extends Controller
{
    public function index(Request $request)
    {
        $query = ReformasiRb::where('is_active', true);

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $items = $query->latest()->paginate(10);

        return view('frontend.reformasi-rb.index', compact('items'));
    }
}