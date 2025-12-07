<?php

namespace App\Http\Controllers;

use App\Models\JadwalAcara;
use Illuminate\Http\Request;
use App\Models\JadwalCategory;
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

        // Default sort: Berdasarkan Hari lalu Jam Tayang
        $jadwalAcaras = $query->select('jadwal_acaras.*')
                            ->join('jadwal_categories', 'jadwal_acaras.jadwal_category_id', '=', 'jadwal_categories.id')
                            ->orderBy('jadwal_categories.order', 'asc')
                            ->orderBy('jadwal_acaras.start_time', 'asc')
                            ->paginate(10)
                            ->withQueryString();

        $categories = BroadcastCategory::orderBy('name')->get();
        $jadwalCategories = JadwalCategory::orderBy('id')->get();

        return view('backend.jadwal-acara.index', compact('jadwalAcaras', 'categories', 'jadwalCategories'));
    }

    public function create()
    {
        $categories = BroadcastCategory::orderBy('name')->get();
        $jadwalCategories = JadwalCategory::orderBy('id')->get();
        
        return view('backend.jadwal-acara.create', compact('categories', 'jadwalCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:jadwal_acaras,slug',
            'start_time' => 'required',
            'end_time' => 'required', // ✅ TAMBAHAN: Validasi Waktu Selesai
            'broadcast_category_id' => 'required|exists:broadcast_categories,id',
            'jadwal_category_id' => 'required|exists:jadwal_categories,id',
            'is_active' => 'required|boolean',
        ]);

        JadwalAcara::create($validated);

        return redirect()->route('dashboard.jadwal-acara.index')
                         ->with('success', 'Jadwal acara berhasil ditambahkan!');
    }

    public function edit(JadwalAcara $jadwalAcara)
    {
        $jadwalCategories = JadwalCategory::orderBy('id')->get();
        $categories = BroadcastCategory::orderBy('name')->get();
        
        return view('backend.jadwal-acara.edit', compact('jadwalAcara', 'categories', 'jadwalCategories'));
    }

    public function update(Request $request, JadwalAcara $jadwalAcara)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('jadwal_acaras')->ignore($jadwalAcara->id)],
            'start_time' => 'required',
            'end_time' => 'required', // ✅ TAMBAHAN: Validasi Waktu Selesai
            'broadcast_category_id' => 'required|exists:broadcast_categories,id',
            'jadwal_category_id' => 'required|exists:jadwal_categories,id',
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