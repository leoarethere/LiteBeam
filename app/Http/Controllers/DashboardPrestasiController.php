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
    public function index(): View
    {
        // Urutkan dari tahun terbaru
        $prestasis = Prestasi::orderBy('year', 'desc')->latest()->paginate(10);
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'is_active'   => 'nullable|boolean',
        ]);

        // Handle Image Upload dengan Kompresi
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = 'prestasi/' . Str::random(40) . '.jpg';

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800); // Resize lebar max 800px
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($filename, (string) $encoded);
                $validated['image'] = $filename;

            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal memproses gambar: ' . $e->getMessage()])->withInput();
            }
        }

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
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle Update Image
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($prestasi->image && Storage::disk('public')->exists($prestasi->image)) {
                Storage::disk('public')->delete($prestasi->image);
            }

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