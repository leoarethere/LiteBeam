<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'body' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'website' => 'nullable|string|max:255',
        ]);

        if ($request->filled('website')) {
            return back()->withErrors(['error' => 'Terindikasi sebagai spam.']);
        }

        $allowedTypes = [
            'App\Models\News',
            'App\Models\Post',
            'App\Models\Broadcast',
        ];

        if (!in_array($validated['commentable_type'], $allowedTypes)) {
            return back()->withErrors(['error' => 'Tipe konten tidak valid.']);
        }

        $modelClass = $validated['commentable_type'];
        if (!$modelClass::where('id', $validated['commentable_id'])->exists()) {
            return back()->withErrors(['error' => 'Konten tidak ditemukan atau sudah dihapus.']);
        }

        $validated['status'] = 'pending';

        Comment::create($validated);

        return back()->with('success', 'Komentar Anda berhasil dikirim! Komentar Anda akan muncul setelah disetujui oleh admin.');
    }
}
