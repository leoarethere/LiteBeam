<?php

namespace App\Http\Controllers;

use App\Models\ReformasiRb;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

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

        // Handle Upload Cover
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('reformasi-covers', 'public');
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
        
        // Update Slug jika judul berubah (opsional, tapi baik untuk SEO)
        if ($request->title !== $reformasiRb->title) {
            $data['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $data['is_active'] = $request->has('is_active');

        // Handle Upload Cover Baru
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            if ($reformasiRb->cover_image && Storage::disk('public')->exists($reformasiRb->cover_image)) {
                Storage::disk('public')->delete($reformasiRb->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('reformasi-covers', 'public');
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