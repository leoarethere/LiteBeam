<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Menampilkan daftar semua banner.
     */
    public function index(): View
    {
        $banners = Banner::latest()->paginate(10);
        return view('backend.banners.index', compact('banners'));
    }

    /**
     * Menampilkan form untuk membuat banner baru.
     */
    public function create(): View
    {
        return view('backend.banners.create');
    }

    /**
     * Menyimpan banner baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ PERBAIKAN: Validasi diubah untuk mengharapkan 'image_base64', bukan 'image'.
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'link' => 'required|url',
            'button_text' => 'nullable|string|max:50',
            'image_base64' => 'required|string', // Pastikan nama ini sesuai dengan form
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        // Proses dan simpan gambar dari base64
        $imageData = $validated['image_base64'];
        
        // Memisahkan metadata dari data base64
        @list($type, $imageData) = explode(';', $imageData);
        @list(, $imageData) = explode(',', $imageData);
        
        // Mendapatkan ekstensi file dari tipe mime
        $imageExtension = Str::of($type)->after('image/')->toString();
        $imageName = 'banners/' . Str::random(20) . '.' . $imageExtension;

        // Menyimpan file ke storage
        Storage::disk('public')->put($imageName, base64_decode($imageData));

        // Menyiapkan data untuk disimpan ke model Banner
        $bannerData = $validated;
        $bannerData['image_path'] = $imageName;
        unset($bannerData['image_base64']); // Hapus field base64 sebelum membuat record

        Banner::create($bannerData);

        return redirect()->route('banners.index')->with('success', 'Banner berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit banner.
     */
    public function edit(Banner $banner): View
    {
        return view('backend.banners.edit', compact('banner'));
    }

    /**
     * Mengupdate data banner di database.
     */
    public function update(Request $request, Banner $banner): RedirectResponse
    {
        // ✅ PERBAIKAN: Validasi update juga disesuaikan
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'link' => 'required|url',
            'button_text' => 'nullable|string|max:50',
            'image_base64' => 'nullable|string', // nullable karena gambar mungkin tidak diubah
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        $bannerData = $validated;

        if ($request->filled('image_base64')) {
            // Hapus gambar lama jika ada
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
            // Proses gambar baru
            $imageData = $validated['image_base64'];
            @list($type, $imageData) = explode(';', $imageData);
            @list(, $imageData) = explode(',', $imageData);
            $imageExtension = Str::of($type)->after('image/')->toString();
            $imageName = 'banners/' . Str::random(20) . '.' . $imageExtension;
            Storage::disk('public')->put($imageName, base64_decode($imageData));
            $bannerData['image_path'] = $imageName;
        }
        
        unset($bannerData['image_base64']);
        $banner->update($bannerData);

        return redirect()->route('banners.index')->with('success', 'Banner berhasil diperbarui!');
    }

    /**
     * Menghapus banner dari database.
     */
    public function destroy(Banner $banner): RedirectResponse
    {
        // Hapus gambar dari storage saat banner dihapus
        if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }
        
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner berhasil dihapus!');
    }
}