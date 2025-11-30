<?php

namespace App\Http\Controllers;

use App\Models\HymneTvri;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardHymneTvriController extends Controller
{
    public function index(): View
    {
        $hymnes = HymneTvri::latest()->paginate(10);
        return view('backend.hymne-tvri.index', compact('hymnes'));
    }

    public function create(): View
    {
        return view('backend.hymne-tvri.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'info'      => 'nullable|string|max:255',
            'poster'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'synopsis'  => 'required|string',
            'link'      => 'required|url', // Link Youtube/Streaming
            'is_active' => 'nullable|boolean',
        ]);

        // Handle Upload Poster
        if ($request->hasFile('poster')) {
            try {
                $file = $request->file('poster');
                $filename = 'hymne/' . Str::random(40) . '.jpg';

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                // Poster biasanya vertikal atau kotak, kita resize lebar 600px cukup
                $image->scale(width: 600); 
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($filename, (string) $encoded);
                $validated['poster'] = $filename;

            } catch (\Exception $e) {
                return back()->withErrors(['poster' => 'Gagal memproses gambar: ' . $e->getMessage()])->withInput();
            }
        }

        $validated['is_active'] = $request->has('is_active');

        HymneTvri::create($validated);

        return redirect()->route('dashboard.hymne-tvri.index')
            ->with('success', 'Data Himne berhasil ditambahkan!');
    }

    public function edit(HymneTvri $hymneTvri): View
    {
        return view('backend.hymne-tvri.edit', compact('hymneTvri'));
    }

    public function update(Request $request, HymneTvri $hymneTvri): RedirectResponse
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'info'      => 'nullable|string|max:255',
            'poster'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'synopsis'  => 'required|string',
            'link'      => 'required|url',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle Update Poster
        if ($request->hasFile('poster')) {
            if ($hymneTvri->poster && Storage::disk('public')->exists($hymneTvri->poster)) {
                Storage::disk('public')->delete($hymneTvri->poster);
            }

            try {
                $file = $request->file('poster');
                $filename = 'hymne/' . Str::random(40) . '.jpg';

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 600);
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($filename, (string) $encoded);
                $validated['poster'] = $filename;

            } catch (\Exception $e) {
                return back()->withErrors(['poster' => 'Gagal memproses gambar: ' . $e->getMessage()])->withInput();
            }
        }

        $hymneTvri->update($validated);

        return redirect()->route('dashboard.hymne-tvri.index')
            ->with('success', 'Data Himne berhasil diperbarui!');
    }

    public function destroy(HymneTvri $hymneTvri): RedirectResponse
    {
        if ($hymneTvri->poster && Storage::disk('public')->exists($hymneTvri->poster)) {
            Storage::disk('public')->delete($hymneTvri->poster);
        }

        $hymneTvri->delete();

        return redirect()->route('dashboard.hymne-tvri.index')
            ->with('success', 'Data Himne berhasil dihapus!');
    }
}