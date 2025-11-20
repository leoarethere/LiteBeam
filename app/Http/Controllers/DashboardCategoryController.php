<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class DashboardCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'color' => 'required|string|max:50',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori dengan nama ini sudah ada.',
            'slug.required' => 'Slug kategori wajib diisi.',
            'slug.unique' => 'Slug ini sudah digunakan.',
        ]);

        Category::create($validated);

        return redirect()->route('dashboard.posts.index')
            ->with('category_success', 'Kategori "' . $validated['name'] . '" berhasil ditambahkan! 🎉');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'color' => 'required|string|max:50',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori dengan nama ini sudah ada.',
            'slug.required' => 'Slug kategori wajib diisi.',
            'slug.unique' => 'Slug ini sudah digunakan.',
        ]);

        $category->update($validated);

        return redirect()->route('dashboard.posts.index')
            ->with('category_success', 'Kategori "' . $validated['name'] . '" berhasil diperbarui! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category) // 👈 Hapus type hint ": RedirectResponse"
    {
        // 1. Cek apakah kategori masih dipakai
        $postCount = $category->posts()->count();
        
        if ($postCount > 0) {
            $errorMsg = '❌ Kategori "' . $category->name . '" tidak dapat dihapus karena masih memiliki ' . $postCount . ' postingan terkait.';

            // Jika Turbo, tampilkan Error dalam Modal Popup
            if ($request->wantsTurboStream()) {
                return response()
                    ->view('components.stream-modal', [
                        'type' => 'error',
                        'title' => 'Gagal Menghapus',
                        'message' => $errorMsg
                    ])
                    ->header('Content-Type', 'text/vnd.turbo-stream.html');
            }

            // Fallback
            return redirect()->route('dashboard.posts.index')
                ->with('modal_error', $errorMsg);
        }

        try {
            $categoryName = $category->name;
            $category->delete();

            $message = 'Kategori "' . $categoryName . '" berhasil dihapus! 🗑️';

            // Jika Turbo, tampilkan Sukses dalam Modal Popup
            if ($request->wantsTurboStream()) {
                return response()
                    ->view('components.stream-modal', [
                        'type' => 'success',
                        'title' => 'Berhasil Dihapus',
                        'message' => $message
                    ])
                    ->header('Content-Type', 'text/vnd.turbo-stream.html');
            }

            return redirect()->route('dashboard.posts.index')
                ->with('modal_success', $message);

        } catch (\Exception $e) {
            $errorMsg = 'Terjadi kesalahan: ' . $e->getMessage();

            if ($request->wantsTurboStream()) {
                return response()
                    ->view('components.stream-modal', [
                        'type' => 'error',
                        'title' => 'Error Sistem',
                        'message' => $errorMsg
                    ])
                    ->header('Content-Type', 'text/vnd.turbo-stream.html');
            }

            return redirect()->route('dashboard.posts.index')
                ->with('modal_error', $errorMsg);
        }
    }
}