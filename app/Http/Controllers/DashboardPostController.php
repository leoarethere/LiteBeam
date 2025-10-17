<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder untuk posts
        $query = Post::with(['author', 'category'])->latest();

        // Filter pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter berdasarkan kategori jika ada
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter berdasarkan penulis jika ada
        if ($request->filled('author')) {
            $query->whereHas('author', function($q) use ($request) {
                $q->where('username', $request->author);
            });
        }

        // Pagination dengan query string
        $posts = $query->paginate(10)->withQueryString();

        return view('backend.postingan.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implementasi untuk menampilkan form create
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Implementasi untuk menyimpan post baru
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Biasanya tidak digunakan di dashboard
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Implementasi untuk menampilkan form edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Implementasi untuk update post
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Hapus post
        $post->delete();

        // ✅ PERBAIKAN: Redirect kembali ke halaman daftar postingan di dashboard
        return redirect()->route('dashboard.posts.index')
                         ->with('success', 'Postingan "' . $post->title . '" berhasil dihapus!');
    }
}
