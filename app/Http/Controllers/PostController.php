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
        
        // Logika Judul Dinamis
        if ($request->filled('category')) {
            $category = Category::firstWhere('slug', $request->category);
            if ($category) $title = 'Postingan di Kategori: ' . $category->name;
        }

        if ($request->filled('author')) {
            $author = User::firstWhere('username', $request->author);
            if ($author) $title = 'Postingan oleh: ' . $author->name;
        }

        if ($request->filled('search')) {
            $title = 'Hasil Pencarian: "' . $request->search . '"';
        }

        // ✅ PERBAIKAN: Menggunakan ScopeFilter dari Model
        $query = Post::latest()
                    ->where('status', 'published') // Hanya yang published
                    ->filter(request(['search', 'category', 'author'])); // Panggil scopeFilter

        // Logika Sorting (Opsional, jika ingin ditambahkan di atas filter)
        switch ($request->input('sort')) {
            case 'oldest': $query->orderBy('published_at', 'asc'); break;
            case 'popular': $query->orderBy('views', 'desc'); break;
            case 'title_asc': $query->orderBy('title', 'asc'); break;
            case 'title_desc': $query->orderBy('title', 'desc'); break;
            default: $query->latest('published_at'); break;
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = Category::all();
        // Ambil author yang memiliki postingan saja
        $authors = User::has('posts')->orderBy('name')->get();

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
    
    // Method category() dan author() BISA DIHAPUS jika sudah menggunakan filter di index(),
    // Tapi jika ingin dipertahankan untuk rute khusus, kodenya sudah aman.
    public function category(Category $category)
    {
        return redirect()->route('posts.index', ['category' => $category->slug]);
    }

    public function author(User $user)
    {
        return redirect()->route('posts.index', ['author' => $user->username]);
    }
}