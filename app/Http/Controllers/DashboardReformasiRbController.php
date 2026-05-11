<?php

namespace App\Http\Controllers;

use App\Models\ReformasiRb;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardReformasiRbController extends Controller
{
    public function index(Request $request)
    {
        $query = ReformasiRb::query();

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

        return view('backend.reformasi-rb.index', compact('items'));
    }

    public function create()
    {
        return view('backend.reformasi-rb.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'file_link'   => 'required|url',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'description' => 'required|string',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $data['is_active'] = $request->has('is_active');

        // Handle Upload Cover (dengan kompresi)
        if ($request->hasFile('cover_image')) {
            try {
                $file = $request->file('cover_image');
                $filename = 'reformasi-covers/' . Str::random(40) . '.jpg';

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($filename, (string) $encoded);
                $data['cover_image'] = $filename;
            } catch (\Exception $e) {
                return back()->withErrors(['cover_image' => 'Gagal memproses gambar: ' . $e->getMessage()])->withInput();
            }
        }

        ReformasiRb::create($data);

        return redirect()->route('dashboard.reformasi-rb.index')
            ->with('success', 'Data Reformasi RB berhasil ditambahkan!');
    }

    public function edit(ReformasiRb $reformasiRb)
    {
        return view('backend.reformasi-rb.edit', compact('reformasiRb'));
    }

    public function update(Request $request, ReformasiRb $reformasiRb)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'file_link'   => 'required|url',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'description' => 'required|string',
        ]);

        $data = $validated;
        
        // [PERBAIKAN SEO] Slug dijaga tetap permanen
        
        $data['is_active'] = $request->has('is_active');

        // [PERBAIKAN LOGIKA GAMBAR] Safe Image Update (dengan kompresi)
        if ($request->hasFile('cover_image')) {
            try {
                $file = $request->file('cover_image');
                $filename = 'reformasi-covers/' . Str::random(40) . '.jpg';

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                // 1. Simpan gambar baru
                Storage::disk('public')->put($filename, (string) $encoded);

                // 2. Jika sukses, hapus gambar lama
                if ($reformasiRb->cover_image && Storage::disk('public')->exists($reformasiRb->cover_image)) {
                    Storage::disk('public')->delete($reformasiRb->cover_image);
                }
                $data['cover_image'] = $filename;
            } catch (\Exception $e) {
                return back()->withErrors(['cover_image' => 'Gagal memproses gambar: ' . $e->getMessage()])->withInput();
            }
        }

        $reformasiRb->update($data);

        return redirect()->route('dashboard.reformasi-rb.index')
            ->with('success', 'Data Reformasi RB berhasil diperbarui!');
    }

    public function destroy(ReformasiRb $reformasiRb)
    {
        // Hapus file gambar jika ada
        if ($reformasiRb->cover_image && Storage::disk('public')->exists($reformasiRb->cover_image)) {
            Storage::disk('public')->delete($reformasiRb->cover_image);
        }

        $reformasiRb->delete();

        return redirect()->route('dashboard.reformasi-rb.index')
            ->with('success', 'Data Reformasi RB berhasil dihapus!');
    }
}