<?php

namespace App\Http\Controllers;

use App\Models\InfoMagang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class DashboardInfoMagangController extends Controller
{
    public function index(Request $request)
    {
        $query = InfoMagang::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Fitur Sorting
        if ($request->input('sort') === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $items = $query->paginate(10)->withQueryString();

        return view('backend.info-magang.index', compact('items'));
    }

    public function create()
    {
        return view('backend.info-magang.create');
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

        // Handle Upload Cover
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('magang-covers', 'public');
        }

        InfoMagang::create($data);

        return redirect()->route('dashboard.info-magang.index')
            ->with('success', 'Informasi Magang berhasil ditambahkan!');
    }

    public function edit(InfoMagang $infoMagang)
    {
        return view('backend.info-magang.edit', compact('infoMagang'));
    }

    public function update(Request $request, InfoMagang $infoMagang)
        {
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'source_link' => 'required|url',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'description' => 'required|string',
            ]);

            $data = $validated;
            
            // [PERBAIKAN SEO] Hapus logika perubahan slug otomatis.
            // Slug hanya dibuat sekali saat create agar link permanen.
            // if ($request->title !== $infoMagang->title) { ... } <--- DIHAPUS

            $data['is_active'] = $request->has('is_active');

            // [PERBAIKAN LOGIKA GAMBAR] Upload baru sukses -> Baru hapus lama
            if ($request->hasFile('cover_image')) {
                // 1. Simpan gambar baru
                $path = $request->file('cover_image')->store('magang-covers', 'public');
                
                // 2. Jika sukses, baru hapus yang lama
                if ($path) {
                    if ($infoMagang->cover_image && Storage::disk('public')->exists($infoMagang->cover_image)) {
                        Storage::disk('public')->delete($infoMagang->cover_image);
                    }
                    $data['cover_image'] = $path;
                }
            }

            $infoMagang->update($data);

            return redirect()->route('dashboard.info-magang.index')
                ->with('success', 'Informasi Magang berhasil diperbarui!');
        }

    public function destroy(InfoMagang $infoMagang)
    {
        // Hapus file gambar jika ada
        if ($infoMagang->cover_image && Storage::disk('public')->exists($infoMagang->cover_image)) {
            Storage::disk('public')->delete($infoMagang->cover_image);
        }

        $infoMagang->delete();

        return redirect()->route('dashboard.info-magang.index')
            ->with('success', 'Informasi Magang berhasil dihapus!');
    }
}