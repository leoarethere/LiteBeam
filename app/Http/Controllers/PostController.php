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
        $title = 'Semua Postingan';
        
        $category = null;
        $author = null;

        // Logika Judul Dinamis
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

        if ($request->filled('search')) {
            $title = 'Hasil Pencarian: "' . $request->search . '"';
            if ($category) $title .= ' dalam Kategori: ' . $category->name;
            if ($author) $title .= ' oleh: ' . $author->name;
        }

        $query = Post::with(['user', 'category'])
                    ->where('status', 'published');

        // ✅ PERBAIKAN: Filter Pencarian (Tags DIHAPUS Total)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('body', 'like', '%' . $search . '%')
                  // Tags dihapus dari sini agar tidak eror SQL
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('bio', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter Kategori & Author
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('author')) {
            $query->whereHas('user', fn($q) => $q->where('username', $request->author));
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest': $query->orderBy('published_at', 'asc'); break;
            case 'popular': $query->orderBy('views', 'desc'); break;
            case 'title_asc': $query->orderBy('title', 'asc'); break;
            case 'title_desc': $query->orderBy('title', 'desc'); break;
            case 'latest': 
            default: $query->latest('published_at'); break;
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = Category::all();
        $authors = User::has('posts')->withCount('posts')->orderBy('name')->get();

        return view('frontend.postingan.posts', compact('title', 'posts', 'categories', 'authors'));
    }

    public function show(Post $post)
    {
        // Perbaikan increment agar editor tidak merah
        $post->update([
            'views' => $post->views + 1
        ]);

        return view('frontend.postingan.detail', [
            'title' => $post->title,
            'post' => $post
        ]);
    }
    
    public function category(Category $category)
    {
        return view('frontend.postingan.kategori', [
            'title' => 'Postingan di Kategori: ' . $category->name,
            'posts' => $category->posts()->where('status', 'published')->latest()->paginate(6)
        ]);
    }

    public function author(User $user)
    {
        return view('frontend.postingan.author', [
            'title' => 'Postingan oleh: ' . $user->name,
            'posts' => $user->posts()->where('status', 'published')->latest()->paginate(6)
        ]);
    }
}