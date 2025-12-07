<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InfoKunjungan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class DashboardInfoKunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = InfoKunjungan::query();

        // Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting
        if ($request->input('sort') === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $items = $query->paginate(10)->withQueryString();

        return view('backend.info-kunjungan.index', compact('items'));
    }

    public function create()
    {
        return view('backend.info-kunjungan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'source_link' => 'required|url',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'description' => 'required|string',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $data['is_active'] = $request->has('is_active');

        // Upload Cover
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('kunjungan-covers', 'public');
        }

        InfoKunjungan::create($data);

        return redirect()->route('dashboard.info-kunjungan.index')
            ->with('success', 'Informasi Kunjungan berhasil ditambahkan!');
    }

    public function edit(InfoKunjungan $infoKunjungan)
    {
        return view('backend.info-kunjungan.edit', compact('infoKunjungan'));
    }

    public function update(Request $request, InfoKunjungan $infoKunjungan)
        {
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'source_link' => 'required|url',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'description' => 'required|string',
            ]);

            $data = $validated;
            
            // [PERBAIKAN SEO] Slug tidak diubah saat update judul
            
            $data['is_active'] = $request->has('is_active');

            // [PERBAIKAN LOGIKA GAMBAR] Safe Image Update
            if ($request->hasFile('cover_image')) {
                // 1. Simpan gambar baru
                $path = $request->file('cover_image')->store('kunjungan-covers', 'public');
                
                // 2. Jika sukses, hapus gambar lama
                if ($path) {
                    if ($infoKunjungan->cover_image && Storage::disk('public')->exists($infoKunjungan->cover_image)) {
                        Storage::disk('public')->delete($infoKunjungan->cover_image);
                    }
                    $data['cover_image'] = $path;
                }
            }

            $infoKunjungan->update($data);

            return redirect()->route('dashboard.info-kunjungan.index')
                ->with('success', 'Informasi Kunjungan berhasil diperbarui!');
        }

    public function destroy(InfoKunjungan $infoKunjungan)
    {
        if ($infoKunjungan->cover_image && Storage::disk('public')->exists($infoKunjungan->cover_image)) {
            Storage::disk('public')->delete($infoKunjungan->cover_image);
        }

        $infoKunjungan->delete();

        return redirect()->route('dashboard.info-kunjungan.index')
            ->with('success', 'Informasi Kunjungan berhasil dihapus!');
    }
}