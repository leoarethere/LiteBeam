<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

// ✅ GUNAKAN GD DRIVER - Lebih universal dan tersedia di hampir semua server
use Intervention\Image\Drivers\Gd\Driver;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Post::with(['user', 'category']);

        // Filter pencarian
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where('title', 'like', '%' . $search . '%');
        });

        // Filter kategori
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereHas('category', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->category);
            });
        });

        // Filter urutan (sort)
        if ($request->input('sort') === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->latest(); // Default adalah 'latest'
        }

        $posts = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('backend.postingan.index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    /**
     * Menampilkan form untuk membuat postingan baru.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.postingan.create', compact('categories'));
    }

    /**
     * Menyimpan postingan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi (Biarkan seperti semula)
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:posts,slug',
                'category_id' => 'required|exists:categories,id',
                'body' => 'required|string',
                'link_postingan' => 'nullable|url|max:255',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
                'excerpt' => 'nullable|string|max:300',
                'published_at' => 'nullable|date',
                'action' => 'required|in:draft,publish',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }

        $validated['user_id'] = Auth::id();

        // Process Image (Biarkan seperti semula)
        if ($request->hasFile('featured_image')) {
            try {
                $file = $request->file('featured_image');
                $filename = Str::random(40) . '.jpg';
                $path = 'post-images/' . $filename;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 1200);
                $encodedImage = $image->toJpeg(quality: 70);
                Storage::disk('public')->put($path, (string) $encodedImage);
                $validated['featured_image'] = $path;
            } catch (\Exception $e) {
                \Log::error('Image processing error: ' . $e->getMessage());
                // Gunakan modal_error untuk error fatal
                return back()->with('modal_error', 'Gagal memproses gambar: ' . $e->getMessage())->withInput();
            }
        }

        // Auto-excerpt & Status logic (Biarkan seperti semula)
        if (empty($validated['excerpt'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 150);
        }

        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
            $validated['published_at'] = $request->filled('published_at') ? $request->published_at : now();
        } else {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        // Simpan
        try {
            Post::create($validated);
        } catch (\Exception $e) {
            \Log::error('Post creation error: ' . $e->getMessage());
            // Gunakan modal_error
            return back()->with('modal_error', 'Gagal menyimpan postingan: ' . $e->getMessage())->withInput();
        }

        $message = $validated['status'] === 'published' 
            ? 'Postingan berhasil dipublikasikan!' 
            : 'Postingan berhasil disimpan sebagai draft!';

        // 👇 [PERUBAHAN UTAMA] Gunakan 'modal_success' agar muncul Popup
        return redirect()->route('dashboard.posts.index')
            ->with('modal_success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return redirect()->route('posts.show', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.postingan.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        // Validasi
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => ['required', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
                'category_id' => 'required|exists:categories,id',
                'body' => 'required|string',
                'link_postingan' => 'nullable|url|max:255',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
                'excerpt' => 'nullable|string|max:300',
                'published_at' => 'nullable|date',
                'action' => 'required|in:draft,publish',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }

        // Image Processing
        if ($request->hasFile('featured_image')) {
            try {
                if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                    Storage::disk('public')->delete($post->featured_image);
                }
                $file = $request->file('featured_image');
                $filename = Str::random(40) . '.jpg';
                $path = 'post-images/' . $filename;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 1200);
                $encodedImage = $image->toJpeg(quality: 70);
                Storage::disk('public')->put($path, (string) $encodedImage);
                $validated['featured_image'] = $path;
            } catch (\Exception $e) {
                \Log::error('Image processing error: ' . $e->getMessage());
                return back()->with('modal_error', 'Gagal memproses gambar: ' . $e->getMessage())->withInput();
            }
        }

        // Logic Excerpt & Status
        if (empty($validated['excerpt'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 150);
        }

        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
            $validated['published_at'] = $request->filled('published_at') 
                ? $request->published_at 
                : ($post->published_at ?? now());
        } else {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        // Update
        try {
            $post->update($validated);
        } catch (\Exception $e) {
            \Log::error('Post update error: ' . $e->getMessage());
            return back()->with('modal_error', 'Gagal memperbarui postingan: ' . $e->getMessage())->withInput();
        }

        $message = $validated['status'] === 'published' 
            ? 'Postingan berhasil diperbarui!' 
            : 'Perubahan berhasil disimpan sebagai draft!';

        // 👇 [PERUBAHAN UTAMA] Gunakan 'modal_success'
        return redirect()->route('dashboard.posts.index')
            ->with('modal_success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post) // 👈 Hapus return type hint ": RedirectResponse" agar fleksibel
    {
        try {
            $postTitle = $post->title;

            // 1. Hapus Gambar (Jika ada)
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }

            // 2. Hapus Postingan
            $post->delete();

            $message = 'Postingan "' . $postTitle . '" berhasil dihapus! 🗑️';

            // 👇 [LOGIKA BARU] Cek apakah request ini dari Turbo Stream?
            if ($request->wantsTurboStream()) {
                // Kirim potongan HTML khusus untuk di-inject ke <div id="flash-container">
                return response()
                    ->view('components.stream-modal', [
                        'type' => 'success',
                        'title' => 'Berhasil Dihapus',
                        'message' => $message
                    ])
                    ->header('Content-Type', 'text/vnd.turbo-stream.html');
            }

            // Fallback: Redirect biasa untuk browser non-Turbo
            return redirect()->route('dashboard.posts.index')
                ->with('modal_success', $message);

        } catch (\Exception $e) {
            $errorMsg = 'Gagal menghapus postingan: ' . $e->getMessage();
            \Log::error($errorMsg);

            if ($request->wantsTurboStream()) {
                return response()
                    ->view('components.stream-modal', [
                        'type' => 'error',
                        'title' => 'Terjadi Kesalahan',
                        'message' => $errorMsg
                    ])
                    ->header('Content-Type', 'text/vnd.turbo-stream.html');
            }
            
            return redirect()->route('dashboard.posts.index')
                ->with('modal_error', $errorMsg);
        }
    }
}