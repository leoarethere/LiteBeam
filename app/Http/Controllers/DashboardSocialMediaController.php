<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardSocialMediaController extends Controller
{
    public function index()
    {
        // Ambil data pertama, jika kosong buat object baru (kosong) agar form tidak error
        $socialMedia = SocialMedia::first() ?? new SocialMedia();
        
        return view('backend.social-media.index', compact('socialMedia'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'instagram' => 'nullable|url', // Wajib format URL (https://...)
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);

        // Update record pertama (id 1) atau buat jika belum ada
        SocialMedia::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return redirect()->back()->with('success', 'Link sosial media berhasil diperbarui!');
    }
}