<?php

namespace App\Http\Controllers;

use App\Models\Ppid;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PpidController extends Controller
{
    public function index(Request $request)
    {
        $query = Ppid::where('is_active', true);

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $ppids = $query->latest()->paginate(10);

        // PERUBAHAN DI SINI: Arahkan ke view 'frontend.ppid.ppid'
        return view('frontend.ppid.ppid', compact('ppids'));
    }
}