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
        // Validasi sederhana
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|file|max:20480',
            'cover_image' => 'nullable|image|max:5120',
            'is_active' => 'nullable',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ];

        // Upload file dokumen
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            
            // Simpan ke storage/app/public/ppid-docs
            $file->move(public_path('storage/ppid-docs'), $filename);
            $data['file_path'] = 'ppid-docs/' . $filename;
        }

        // Upload cover image
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time() . '_' . uniqid() . '.jpg';
            
            try {
                $manager = new ImageManager(new Driver());
                $imgProcessed = $manager->read($image);
                $imgProcessed->scale(width: 800);
                $encoded = $imgProcessed->toJpeg(quality: 80);
                
                // Simpan ke storage/app/public/ppid-covers
                if (!file_exists(public_path('storage/ppid-covers'))) {
                    mkdir(public_path('storage/ppid-covers'), 0755, true);
                }
                
                file_put_contents(public_path('storage/ppid-covers/' . $imageName), $encoded);
                $data['cover_image'] = 'ppid-covers/' . $imageName;
            } catch (\Exception $e) {
                // Jika gagal, simpan original
                $image->move(public_path('storage/ppid-covers'), $imageName);
                $data['cover_image'] = 'ppid-covers/' . $imageName;
            }
        }

        Ppid::create($data);

        return redirect()->route('dashboard.ppid.index')
            ->with('success', 'Dokumen PPID berhasil ditambahkan!');
    }

    public function edit(Ppid $ppid): View
    {
        return view('backend.ppid.edit', compact('ppid'));
    }

    public function update(Request $request, Ppid $ppid): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|max:20480',
            'cover_image' => 'nullable|image|max:5120',
            'is_active' => 'nullable',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ];

        // Update file dokumen jika ada
        if ($request->hasFile('file_path')) {
            // Hapus file lama
            if ($ppid->file_path && file_exists(public_path('storage/' . $ppid->file_path))) {
                unlink(public_path('storage/' . $ppid->file_path));
            }

            $file = $request->file('file_path');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            
            if (!file_exists(public_path('storage/ppid-docs'))) {
                mkdir(public_path('storage/ppid-docs'), 0755, true);
            }
            
            $file->move(public_path('storage/ppid-docs'), $filename);
            $data['file_path'] = 'ppid-docs/' . $filename;
        }

        // Update cover image jika ada
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            if ($ppid->cover_image && file_exists(public_path('storage/' . $ppid->cover_image))) {
                unlink(public_path('storage/' . $ppid->cover_image));
            }

            $image = $request->file('cover_image');
            $imageName = time() . '_' . uniqid() . '.jpg';
            
            try {
                $manager = new ImageManager(new Driver());
                $imgProcessed = $manager->read($image);
                $imgProcessed->scale(width: 800);
                $encoded = $imgProcessed->toJpeg(quality: 80);
                
                if (!file_exists(public_path('storage/ppid-covers'))) {
                    mkdir(public_path('storage/ppid-covers'), 0755, true);
                }
                
                file_put_contents(public_path('storage/ppid-covers/' . $imageName), $encoded);
                $data['cover_image'] = 'ppid-covers/' . $imageName;
            } catch (\Exception $e) {
                $image->move(public_path('storage/ppid-covers'), $imageName);
                $data['cover_image'] = 'ppid-covers/' . $imageName;
            }
        }

        $ppid->update($data);

        return redirect()->route('dashboard.ppid.index')
            ->with('success', 'Data PPID berhasil diperbarui!');
    }

    public function destroy(Ppid $ppid): RedirectResponse
    {
        // Hapus file dokumen
        if ($ppid->file_path && file_exists(public_path('storage/' . $ppid->file_path))) {
            unlink(public_path('storage/' . $ppid->file_path));
        }

        // Hapus cover image
        if ($ppid->cover_image && file_exists(public_path('storage/' . $ppid->cover_image))) {
            unlink(public_path('storage/' . $ppid->cover_image));
        }

        $ppid->delete();

        return redirect()->route('dashboard.ppid.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}