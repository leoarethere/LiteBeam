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
use Illuminate\Support\Facades\Storage;
// 👇 UBAH KE GD AGAR KONSISTEN DENGAN POST CONTROLLER
use Intervention\Image\Drivers\Gd\Driver; 

class DashboardBroadcastController extends Controller
{
    public function index(Request $request): View
    {
        $query = Broadcast::with(['user', 'broadcastCategory']);
        
        // Filter Pencarian
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%')
                         ->orWhere('synopsis', 'like', '%' . $search . '%');
            });
        });
        
        // Filter Kategori
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereHas('broadcastCategory', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->category);
            });
        });
        
        // Sorting
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

    public function create(): View
    {
        $categories = BroadcastCategory::orderBy('name')->get(); 
        return view('backend.penyiaran.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:broadcasts,slug',
                'broadcast_category_id' => 'required|exists:broadcast_categories,id',
                'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
                'youtube_link' => 'nullable|url|max:255',
                'synopsis' => 'nullable|string',
                'action' => 'required|in:draft,publish'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }

        $validated['user_id'] = Auth::id();

        // 2. Handle Upload Gambar (Poster) dengan Kompresi
        if ($request->hasFile('poster')) {
            try {
                $file = $request->file('poster');
                $filename = Str::random(40) . '.jpg';
                $path = 'broadcast-posters/' . $filename;

                // Gunakan GD Driver (Konsisten)
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                
                // Resize agar tidak terlalu besar (lebar max 800px cukup untuk poster)
                $image->scale(width: 800);
                
                // Encode ke JPG kualitas 75%
                $encodedImage = $image->toJpeg(quality: 75);
                
                Storage::disk('public')->put($path, (string) $encodedImage);
                $validated['poster'] = $path;

            } catch (\Exception $e) {
                \Log::error('Broadcast poster upload error: ' . $e->getMessage());
                return back()
                    ->withErrors(['poster' => 'Gagal memproses poster: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        // 3. Tentukan Status & Tanggal Publish
        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
            $validated['published_at'] = now();
        } else {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        // 4. Simpan ke Database
        try {
            Broadcast::create($validated);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Database error: ' . $e->getMessage()])->withInput();
        }

        $message = $validated['status'] === 'published' 
            ? 'Penyiaran berhasil dipublikasikan!' 
            : 'Penyiaran disimpan sebagai draft!';

        return redirect()->route('dashboard.broadcasts.index')
                        ->with('broadcast_success', $message);
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
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => ['required', 'string', 'max:255', Rule::unique('broadcasts')->ignore($broadcast->id)], 
                'broadcast_category_id' => 'required|exists:broadcast_categories,id',
                'synopsis' => 'nullable|string',
                'youtube_link' => 'nullable|url|max:255',
                'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'published_at' => 'nullable|date',
                'action' => 'required|in:draft,publish',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }

        // Update Poster
        if ($request->hasFile('poster')) {
            try {
                // Hapus poster lama jika ada
                if ($broadcast->poster && Storage::disk('public')->exists($broadcast->poster)) {
                    Storage::disk('public')->delete($broadcast->poster);
                }

                $file = $request->file('poster');
                $filename = Str::random(40) . '.jpg';
                $path = 'broadcast-posters/' . $filename;

                // Gunakan GD Driver
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encodedImage = $image->toJpeg(quality: 75);
                
                Storage::disk('public')->put($path, (string) $encodedImage);
                $validated['poster'] = $path; 

            } catch (\Exception $e) {
                return back()->withErrors([
                    'poster' => 'Gagal memproses poster: ' . $e->getMessage()
                ])->withInput();
            }
        }

        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
            $validated['published_at'] = $request->filled('published_at') 
                ? $request->published_at 
                : ($broadcast->published_at ?? now());
        } else {
            $validated['status'] = 'draft';
            $validated['published_at'] = null;
        }

        $broadcast->update($validated);

        $message = $validated['status'] === 'published' 
            ? 'Penyiaran berhasil diperbarui!' 
            : 'Perubahan berhasil disimpan sebagai draft!';

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
                             ->with('broadcast_error', 'Gagal menghapus penyiaran: ' . $e->getMessage());
        }
    }
}