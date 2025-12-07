<?php

namespace App\Http\Controllers;

use App\Models\Ppid;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardPpidController extends Controller
{
    public function index(): View
    {
        $ppids = Ppid::latest()->paginate(10);
        return view('backend.ppid.index', compact('ppids'));
    }

    public function create(): View
    {
        return view('backend.ppid.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'source_link' => 'required|url|max:500', // ✅ PERBAIKAN: Sesuai dengan database
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Upload cover image (opsional)
        if ($request->hasFile('cover_image')) {
            try {
                $image = $request->file('cover_image');
                $imageName = time() . '_' . uniqid() . '.jpg';
                
                $manager = new ImageManager(new Driver());
                $imgProcessed = $manager->read($image);
                $imgProcessed->scale(width: 800);
                $encoded = $imgProcessed->toJpeg(quality: 80);
                
                // Pastikan folder ada
                if (!file_exists(public_path('storage/ppid-covers'))) {
                    mkdir(public_path('storage/ppid-covers'), 0755, true);
                }
                
                file_put_contents(public_path('storage/ppid-covers/' . $imageName), $encoded);
                $validated['cover_image'] = 'ppid-covers/' . $imageName;
                
            } catch (\Exception $e) {
                return back()->withErrors(['cover_image' => 'Gagal upload gambar: ' . $e->getMessage()])->withInput();
            }
        }

        Ppid::create($validated);

        return redirect()->route('dashboard.ppid.index')
            ->with('success', 'Dokumen PPID berhasil ditambahkan!');
    }

    public function edit(Ppid $ppid): View
    {
        return view('backend.ppid.edit', compact('ppid'));
    }

    public function update(Request $request, Ppid $ppid): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'source_link' => 'required|url|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // [REFACTOR SAFE UPDATE & STANDARDIZE STORAGE]
        if ($request->hasFile('cover_image')) {
            try {
                $image = $request->file('cover_image');
                $imageName = time() . '_' . uniqid() . '.jpg';
                $path = 'ppid-covers/' . $imageName;
                
                $manager = new ImageManager(new Driver());
                $imgProcessed = $manager->read($image);
                $imgProcessed->scale(width: 800);
                $encoded = $imgProcessed->toJpeg(quality: 80);
                
                // 1. Simpan gambar baru menggunakan Storage Facade
                Storage::disk('public')->put($path, (string) $encoded);
                
                // 2. Hapus gambar lama jika upload sukses
                // Perhatikan: cek apakah path lama menggunakan prefix storage atau tidak
                if ($ppid->cover_image && Storage::disk('public')->exists($ppid->cover_image)) {
                    Storage::disk('public')->delete($ppid->cover_image);
                }

                $validated['cover_image'] = $path;
                
            } catch (\Exception $e) {
                return back()->withErrors(['cover_image' => 'Gagal upload gambar: ' . $e->getMessage()])->withInput();
            }
        }

        $ppid->update($validated);

        return redirect()->route('dashboard.ppid.index')
            ->with('success', 'Data PPID berhasil diperbarui!');
    }

    public function destroy(Ppid $ppid): RedirectResponse
    {
        // Hapus cover image jika ada
        if ($ppid->cover_image && file_exists(public_path('storage/' . $ppid->cover_image))) {
            unlink(public_path('storage/' . $ppid->cover_image));
        }

        $ppid->delete();

        return redirect()->route('dashboard.ppid.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}