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

    public function destroy(Category $category)
    {
        $postCount = $category->posts()->count();
        
        if ($postCount > 0) {
            return redirect()->route('dashboard.posts.index')
                ->with('category_error', '❌ Kategori "' . $category->name . '" tidak dapat dihapus karena masih memiliki ' . $postCount . ' postingan terkait.');
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()->route('dashboard.posts.index')
            ->with('category_success', 'Kategori "' . $categoryName . '" berhasil dihapus! 🗑️');
    }
}