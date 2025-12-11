<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class DashboardSocialMediaController extends Controller
{
    /**
     * Menampilkan data sosial media (Read Only).
     */
    public function index()
    {
        // Ambil data pertama
        $socialMedia = SocialMedia::first();

        // Jika belum ada data, buat dummy data agar tombol Edit muncul (Sama seperti Contact Info)
        if (!$socialMedia) {
            $socialMedia = SocialMedia::create([
                'instagram' => null,
                'facebook'  => null,
                'twitter'   => null,
                'tiktok'    => null,
                'youtube'   => null,
            ]);
        }
        
        return view('backend.social-media.index', compact('socialMedia'));
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        return view('backend.social-media.edit', compact('socialMedia'));
    }

    /**
     * Memproses update data.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'instagram' => 'nullable|url',
            'twitter'   => 'nullable|url',
            'facebook'  => 'nullable|url',
            'tiktok'    => 'nullable|url',
            'youtube'   => 'nullable|url',
        ]);

        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->update($validated);
        
        Cache::forget('global_social_media'); 

        // Redirect ke Index, bukan back()
        return redirect()->route('dashboard.social-media.index')
            ->with('success', 'Link sosial media berhasil diperbarui!');
    }
}