<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class DashboardNewsCategoryController extends Controller
{
    /**
     * Simpan kategori berita baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news_categories,slug',
            // Kita asumsikan ada kolom color seperti di kategori postingan, 
            // jika di migrasi NewsCategory belum ada kolom color, hapus baris ini atau tambahkan kolomnya.
            // Untuk aman, kita bisa simpan name & slug saja dulu jika ragu.
            'color' => 'nullable|string|max:20', 
        ]);

        NewsCategory::create($validated);

        return back()->with('success', 'Kategori berita berhasil ditambahkan!');
    }

    /**
     * Update kategori berita.
     */
    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('news_categories')->ignore($newsCategory->id)
            ],
            'color' => 'nullable|string|max:20',
        ]);

        $newsCategory->update($validated);

        return back()->with('success', 'Kategori berita berhasil diperbarui!');
    }

    /**
     * Hapus kategori berita.
     */
    public function destroy(NewsCategory $newsCategory)
    {
        // Cek apakah kategori masih dipakai di berita
        if ($newsCategory->news()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Kategori ini masih digunakan oleh beberapa berita.');
        }

        $newsCategory->delete();

        return back()->with('success', 'Kategori berita berhasil dihapus!');
    }
}