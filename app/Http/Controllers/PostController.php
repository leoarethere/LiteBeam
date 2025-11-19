<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Semua Postingan Blog';
        $categories = Category::all(); // Untuk dropdown kategori

        // Penyesuaian judul berdasarkan filter
        if ($request->filled('category')) {
            $category = Category::firstWhere('slug', $request->category);
            if ($category) {
                $title = 'Postingan di Kategori: ' . $category->name;
            }
        }

        if ($request->filled('author')) {
            $author = User::firstWhere('username', $request->author);
            if ($author) {
                $title = 'Postingan oleh: ' . $author->name;
            }
        }

        // Query dasar
        $query = Post::with(['user', 'category'])
                    ->where('status', 'published');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('body', 'like', '%' . $search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter penulis
        if ($request->filled('author')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('username', $request->author);
            });
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc'); // Asumsi ada kolom 'views'
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('frontend.postingan.posts', compact('title', 'posts', 'categories'));
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
            'posts' => $category->posts()->where('status', 'published')->latest()->paginate(6)
        ]);
    }

    // Menampilkan postingan berdasarkan penulis
    public function author(User $user)
    {
        return view('frontend.postingan.author', [
            'title' => 'Postingan oleh: ' . $user->name,
            'posts' => $user->posts()->where('status', 'published')->latest()->paginate(6)
        ]);
    }
}