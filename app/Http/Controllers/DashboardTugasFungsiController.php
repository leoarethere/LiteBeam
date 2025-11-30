<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\TugasFungsi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardTugasFungsiController extends Controller
{
    public function index(): View
    {
        $tugasFungsi = TugasFungsi::orderBy('type', 'desc')
                             ->orderBy('order', 'asc')
                             ->get();

        return view('backend.tugas-fungsi.index', ['tugasFungsi' => $tugasFungsi]);
    }

    public function create(): View
    {
        return view('backend.tugas-fungsi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'      => 'required|in:tugas,fungsi',
            'order'     => 'required|integer',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'content'   => 'required|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = 'tf-' . Str::random(20) . '.jpg';
                $path = 'task-images/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($path, (string) $encoded);
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal upload gambar: ' . $e->getMessage()])->withInput();
            }
        }

        TugasFungsi::create($validated);

        return redirect()->route('dashboard.tugas-fungsi.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(TugasFungsi $tugasFungsi): View
    {
        return view('backend.tugas-fungsi.edit', ['tugasFungsi' => $tugasFungsi]);
    }

    public function update(Request $request, TugasFungsi $tugasFungsi): RedirectResponse
    {
        $validated = $request->validate([
            'type'      => 'required|in:tugas,fungsi',
            'order'     => 'required|integer',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'content'   => 'required|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($tugasFungsi->image && Storage::disk('public')->exists($tugasFungsi->image)) {
                Storage::disk('public')->delete($tugasFungsi->image);
            }

            try {
                $file = $request->file('image');
                $filename = 'tf-' . Str::random(20) . '.jpg';
                $path = 'task-images/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($path, (string) $encoded);
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal upload gambar: ' . $e->getMessage()])->withInput();
            }
        }

        $tugasFungsi->update($validated);

        return redirect()->route('dashboard.tugas-fungsi.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(TugasFungsi $tugasFungsi): RedirectResponse
    {
        if ($tugasFungsi->image && Storage::disk('public')->exists($tugasFungsi->image)) {
            Storage::disk('public')->delete($tugasFungsi->image);
        }

        $tugasFungsi->delete();

        return redirect()->route('dashboard.tugas-fungsi.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}