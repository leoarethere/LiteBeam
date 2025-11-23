<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardVisiMisiController extends Controller
{
    public function index(): View
    {
        // [PERBAIKAN] Tambah pengecekan jika data kosong
        $visiMisis = VisiMisi::orderBy('type', 'desc')
                             ->orderBy('order', 'asc')
                             ->paginate(10);

        // [PERBAIKAN] Pastikan data dikirim dengan penanda khusus jika kosong
        $isEmpty = $visiMisis->isEmpty();

        return view('backend.visi-misi.index', compact('visiMisis', 'isEmpty'));
    }

    public function create(): View
    {
        return view('backend.visi-misi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:visi,misi',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'required|integer|min:0',
            'is_active' => 'required|in:0,1',
        ]);

        // Logika Upload & Kompresi Gambar
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = Str::random(40) . '.jpg';
                $path = 'visi-misi-images/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encodedImage = $image->toJpeg(quality: 70);

                Storage::disk('public')->put($path, (string) $encodedImage);
                $validated['image'] = $path;

            } catch (\Exception $e) {
                return back()->withErrors([
                    'image' => 'Gagal memproses gambar: ' . $e->getMessage()
                ])->withInput();
            }
        }

        VisiMisi::create($validated);

        return redirect()->route('dashboard.visi-misi.index')
                         ->with('success', 'Data Visi/Misi berhasil ditambahkan!');
    }

    public function edit(VisiMisi $visiMisi): View
    {
        return view('backend.visi-misi.edit', compact('visiMisi'));
    }

    public function update(Request $request, VisiMisi $visiMisi): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:visi,misi',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'required|integer|min:0',
            'is_active' => 'required|in:0,1',
        ]);

        // Logika Update Gambar
        if ($request->hasFile('image')) {
            try {
                // Hapus gambar lama jika ada
                if ($visiMisi->image && Storage::disk('public')->exists($visiMisi->image)) {
                    Storage::disk('public')->delete($visiMisi->image);
                }

                $file = $request->file('image');
                $filename = Str::random(40) . '.jpg';
                $path = 'visi-misi-images/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encodedImage = $image->toJpeg(quality: 70);
                
                Storage::disk('public')->put($path, (string) $encodedImage);
                $validated['image'] = $path;

            } catch (\Exception $e) {
                return back()->withErrors([
                    'image' => 'Gagal memproses gambar: ' . $e->getMessage()
                ])->withInput();
            }
        } else {
            // [PERBAIKAN] Pertahankan gambar lama jika tidak ada upload baru
            $validated['image'] = $visiMisi->image;
        }

        $visiMisi->update($validated);

        return redirect()->route('dashboard.visi-misi.index')
                         ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(VisiMisi $visiMisi): RedirectResponse
    {
        // Hapus file fisik gambar saat data dihapus
        if ($visiMisi->image && Storage::disk('public')->exists($visiMisi->image)) {
            Storage::disk('public')->delete($visiMisi->image);
        }

        $visiMisi->delete();

        return redirect()->route('dashboard.visi-misi.index')
                         ->with('success', 'Data berhasil dihapus!');
    }
}