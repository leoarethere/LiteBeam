<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BroadcastCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse; 

// ▼▼▼ [UBAH DI SINI] Ganti Gd dengan Imagick ▼▼▼
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;

class DashboardBroadcastController extends Controller
{
    public function index(Request $request): View
    {
        $query = Broadcast::with(['user', 'broadcastCategory']);
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%')
                         ->orWhere('synopsis', 'like', '%' . $search . '%');
            });
        });
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereHas('broadcastCategory', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->category);
            });
        });
        if ($request->input('sort') === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->latest();
        }
        $broadcasts = $query->paginate(10)->withQueryString();
        $categories = BroadcastCategory::orderBy('name')->get();

        return view('backend.penyiaran.index', [
            'broadcasts' => $broadcasts,
            'categories' => $categories, 
            'broadcastCategories' => $categories, 
        ]);
    }

    // Tambahkan/Perbaiki method ini di DashboardBroadcastController.php

    public function create()
    {
        // Pastikan Anda mengirim data kategori ke view create
        $categories = BroadcastCategory::all(); 
        return view('backend.penyiaran.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:broadcasts,slug',
            'broadcast_category_id' => 'required|exists:broadcast_categories,id',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'youtube_link' => 'nullable|url', // ✅ DIPERBAIKI: dari 'link' jadi 'youtube_link'
            'synopsis' => 'nullable|string',
            'action' => 'required|in:draft,publish'
        ]);

        // 2. Handle Upload Gambar (Poster)
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = $path;
        }

        // 3. Tentukan Status & Tanggal Publish
        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
            $validated['published_at'] = now();
        } else {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        // 4. Tambahkan User ID
        $validated['user_id'] = Auth::id();

        // 5. Simpan ke Database
        Broadcast::create($validated);

        // 6. Redirect Sukses
        return redirect()->route('dashboard.broadcasts.index')
                        ->with('broadcast_success', 'Penyiaran berhasil ditambahkan!');
    }

    public function show(Broadcast $broadcast): RedirectResponse
    {
        return redirect()->route('dashboard.broadcasts.edit', $broadcast);
    }

    public function edit(Broadcast $broadcast): View
    {
        $categories = BroadcastCategory::orderBy('name')->get();
        return view('backend.penyiaran.edit', compact('broadcast', 'categories'));
    }

    public function update(Request $request, Broadcast $broadcast): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('broadcasts')->ignore($broadcast->id)], 
            'broadcast_category_id' => 'required|exists:broadcast_categories,id',
            'synopsis' => 'nullable|string',
            'youtube_link' => 'nullable|url|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'published_at' => 'nullable|date',
            'action' => 'required|in:draft,publish',
        ]);

        if ($request->hasFile('poster')) {
            try {
                if ($broadcast->poster && Storage::disk('public')->exists($broadcast->poster)) {
                    Storage::disk('public')->delete($broadcast->poster);
                }

                $file = $request->file('poster');
                $filename = Str::random(40) . '.jpg';
                $path = 'broadcast-posters/' . $filename;

                // Menggunakan Driver Imagick
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $encodedImage = $image->toJpeg(quality: 70);
                Storage::disk('public')->put($path, (string) $encodedImage);

                $validated['poster'] = $path; 

            } catch (\Exception $e) {
                return back()->withErrors([
                    'poster' => 'Gagal memproses poster (Imagick): ' . $e->getMessage()
                ])->withInput();
            }
        }

        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
            $validated['published_at'] = $request->filled('published_at') ? $request->published_at : ($broadcast->published_at ?? now());
        } else {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        $broadcast->update($validated);

        $message = $validated['status'] === 'published' ? 'Penyiaran berhasil diperbarui!' : 'Perubahan berhasil disimpan sebagai draft!';

        return redirect()->route('dashboard.broadcasts.index')
                        ->with('broadcast_success', $message);
    }

    public function destroy(Broadcast $broadcast): RedirectResponse
    {
        try {
            $broadcastTitle = $broadcast->title;
            
            if ($broadcast->poster && Storage::disk('public')->exists($broadcast->poster)) {
                Storage::disk('public')->delete($broadcast->poster);
            }
            
            $broadcast->delete();

            return redirect()->route('dashboard.broadcasts.index')
                             ->with('broadcast_success', 'Penyiaran "' . $broadcastTitle . '" berhasil dihapus! 🗑️');

        } catch (\Exception $e) {
            return redirect()->route('dashboard.broadcasts.index')
                             ->with('broadcast_error', 'Gagal menghapus penyiaran. Terjadi error: ' . $e->getMessage());
        }
    }
}