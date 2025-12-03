<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalCategory;
use Illuminate\Routing\Controller;

class DashboardJadwalCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:jadwal_categories,slug',
            'color' => 'required|string',
        ]);

        JadwalCategory::create($validated);
        return back()->with('success', 'Hari/Kategori baru berhasil ditambahkan!');
    }

    public function update(Request $request, JadwalCategory $jadwalCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:jadwal_categories,slug,' . $jadwalCategory->id,
            'color' => 'required|string',
        ]);

        $jadwalCategory->update($validated);
        return back()->with('success', 'Hari/Kategori berhasil diperbarui!');
    }

    public function destroy(JadwalCategory $jadwalCategory)
    {
        $jadwalCategory->delete();
        return back()->with('success', 'Hari/Kategori berhasil dihapus!');
    }
}