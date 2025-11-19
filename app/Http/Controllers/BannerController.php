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
        // Validasi untuk file upload biasa
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'link' => 'required|url',
            'button_text' => 'nullable|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // max 5MB
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        // Proses upload gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'banners/' . Str::random(20) . '.' . $image->getClientOriginalExtension();
            
            // Simpan gambar
            Storage::disk('public')->put($imageName, file_get_contents($image));
            
            $validated['image_path'] = $imageName;
        }

        // Hapus field image dari validated data karena sudah diproses
        unset($validated['image']);

        Banner::create($validated);

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
        // Validasi untuk file upload biasa
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'link' => 'required|url',
            'button_text' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // max 5MB, nullable
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        // Proses upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
            
            // Upload gambar baru
            $image = $request->file('image');
            $imageName = 'banners/' . Str::random(20) . '.' . $image->getClientOriginalExtension();
            
            Storage::disk('public')->put($imageName, file_get_contents($image));
            
            $validated['image_path'] = $imageName;
        }

        // Hapus field image dari validated data karena sudah diproses
        unset($validated['image']);

        $banner->update($validated);

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