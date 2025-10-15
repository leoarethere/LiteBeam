<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    /**
     * Menampilkan semua postingan dengan filter dan judul dinamis.
     */
    public function index(Request $request)
    {
        // Default judul
        $title = 'Semua Postingan Blog';

        // Filter kategori
        if ($request->filled('category')) {
            $category = Category::firstWhere('slug', $request->category);
            if ($category) {
                $title = 'Postingan di Kategori: ' . $category->name;
            }
        }

        // Filter author
        if ($request->filled('author')) {
            $author = User::firstWhere('username', $request->author);
            if ($author) {
                $title = 'Postingan oleh: ' . $author->name;
            }
        }

        // Query postingan dengan filter
        $posts = Post::latest()
            ->filter($request->only(['search', 'category', 'author']))
            ->paginate(6)
            ->withQueryString(); // <-- penting agar query tetap terbawa di pagination

        return view('frontend.postingan.posts', [
            'title' => $title,
            'posts' => $posts
        ]);
    }

    /**
     * Menampilkan satu postingan.
     */
    public function show(Post $post)
    {
        return view('frontend.postingan.detail', [
            'title' => $post->title,
            'post' => $post
        ]);
    }
    
    // Menampilkan postingan berdasarkan kategori
    public function category(Category $category)
    {
        return view('frontend.postingan.kategori', [
            'title' => 'Postingan di Kategori: ' . $category->name,
            // DIPERBAIKI: Menambahkan paginasi
            'posts' => $category->posts()->latest()->paginate(6)
        ]);
    }

    // Menampilkan postingan berdasarkan penulis
    public function author(User $user)
    {
        return view('frontend.postingan.author', [
            'title' => 'Postingan oleh: ' . $user->name,
            // DIPERBAIKI: Menambahkan paginasi
            'posts' => $user->posts()->latest()->paginate(6)
        ]);
    }
}