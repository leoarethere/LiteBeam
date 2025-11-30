<?php

namespace App\Http\Controllers;

use App\Models\JadwalAcara;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BroadcastCategory;
use Illuminate\Routing\Controller;

class DashboardJadwalAcaraController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalAcara::query();

        // Search
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%');
        });

        // Filter Kategori
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereHas('broadcastCategory', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->category);
            });
        });

        // Default sort: Berdasarkan Jam Tayang (Pagi ke Malam)
        $jadwalAcaras = $query->orderBy('start_time', 'asc')
                              ->paginate(10)
                              ->withQueryString();

        $categories = BroadcastCategory::orderBy('name')->get();

        return view('backend.jadwal-acara.index', compact('jadwalAcaras', 'categories'));
    }

    public function create()
    {
        $categories = BroadcastCategory::orderBy('name')->get();
        return view('backend.jadwal-acara.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:jadwal_acaras,slug',
            'start_time' => 'required',
            'broadcast_category_id' => 'required|exists:broadcast_categories,id',
            'is_active' => 'required|boolean',
        ]);

        JadwalAcara::create($validated);

        return redirect()->route('dashboard.jadwal-acara.index')
                         ->with('success', 'Jadwal acara berhasil ditambahkan!');
    }

    public function edit(JadwalAcara $jadwalAcara)
    {
        $categories = BroadcastCategory::orderBy('name')->get();
        return view('backend.jadwal-acara.edit', compact('jadwalAcara', 'categories'));
    }

    public function update(Request $request, JadwalAcara $jadwalAcara)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('jadwal_acaras')->ignore($jadwalAcara->id)],
            'start_time' => 'required',
            'broadcast_category_id' => 'required|exists:broadcast_categories,id',
            'is_active' => 'required|boolean',
        ]);

        $jadwalAcara->update($validated);

        return redirect()->route('dashboard.jadwal-acara.index')
                         ->with('success', 'Jadwal acara berhasil diperbarui!');
    }

    public function destroy(JadwalAcara $jadwalAcara)
    {
        $jadwalAcara->delete();
        return redirect()->route('dashboard.jadwal-acara.index')
                         ->with('success', 'Jadwal acara berhasil dihapus!');
    }
}