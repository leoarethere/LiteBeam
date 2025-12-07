<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardPrestasiController extends Controller
{
    public function index(Request $request): View
    {
        // [PERBAIKAN LOGIKA] Menambahkan fitur Search & Filter
        $query = Prestasi::query();

        // 1. Logika Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('award_name', 'like', '%' . $search . '%');
            });
        }

        // 2. Logika Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 3. Sorting Default (Tahun Terbaru)
        // Kita gunakan withQueryString() agar parameter search/category tidak hilang saat pindah halaman
        $prestasis = $query->orderBy('year', 'desc')
                           ->latest()
                           ->paginate(10)
                           ->withQueryString();

        return view('backend.prestasi.index', compact('prestasis'));
    }

    public function create(): View
    {
        return view('backend.prestasi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'award_name'  => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'category'    => 'required|string|max:100',
            'year'        => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            // 'is_active' tidak perlu divalidasi disini karena diambil manual
        ]);

        // Proses Upload Gambar
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = 'prestasi/' . Str::random(40) . '.jpg';

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($filename, (string) $encoded);
                $validated['image'] = $filename;

            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal memproses gambar: ' . $e->getMessage()])->withInput();
            }
        }

        // Logika Checkbox: Jika dicentang return true (1), jika tidak ada return false (0)
        $validated['is_active'] = $request->has('is_active');

        Prestasi::create($validated);

        return redirect()->route('dashboard.prestasi.index')
            ->with('success', 'Data Prestasi berhasil ditambahkan!');
    }

    public function edit(Prestasi $prestasi): View
    {
        return view('backend.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, Prestasi $prestasi): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'award_name'  => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'category'    => 'required|string|max:100',
            'year'        => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // [PERBAIKAN LOGIKA] Ambil status aktif
        $validated['is_active'] = $request->has('is_active');

        // [PERBAIKAN LOGIKA] Handle Update Image Lebih Aman
        // Kita proses upload dulu, baru hapus yang lama jika upload sukses.
        // Sebelumnya: Hapus dulu -> Upload (Kalau upload gagal, gambar lama hilang tapi DB masih nyatat nama file lama)
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = 'prestasi/' . Str::random(40) . '.jpg';

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                // 1. Simpan gambar baru
                Storage::disk('public')->put($filename, (string) $encoded);
                
                // 2. Hapus gambar lama (Hanya jika upload baru sukses)
                if ($prestasi->image && Storage::disk('public')->exists($prestasi->image)) {
                    Storage::disk('public')->delete($prestasi->image);
                }

                // 3. Masukkan nama file baru ke data validasi
                $validated['image'] = $filename;

            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal memproses gambar: ' . $e->getMessage()])->withInput();
            }
        }

        $prestasi->update($validated);

        return redirect()->route('dashboard.prestasi.index')
            ->with('success', 'Data Prestasi berhasil diperbarui!');
    }

    public function destroy(Prestasi $prestasi): RedirectResponse
    {
        if ($prestasi->image && Storage::disk('public')->exists($prestasi->image)) {
            Storage::disk('public')->delete($prestasi->image);
        }

        $prestasi->delete();

        return redirect()->route('dashboard.prestasi.index')
            ->with('success', 'Data Prestasi berhasil dihapus!');
    }
}