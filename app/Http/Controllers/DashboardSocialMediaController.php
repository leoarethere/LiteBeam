<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class DashboardSocialMediaController extends Controller
{
    public function index()
    {
        $socialMedia = SocialMedia::first() ?? new SocialMedia();
        return view('backend.social-media.index', compact('socialMedia'));
    }

    public function update(Request $request)
    {
        // HAPUS validasi email dan phone
        $validated = $request->validate([
            'instagram' => 'nullable|url',
            'twitter'   => 'nullable|url',
            'facebook'  => 'nullable|url',
            'tiktok'    => 'nullable|url',
            'youtube'   => 'nullable|url',
        ]);

        // Logic Update or Create
        $socialMedia = SocialMedia::first();

        if ($socialMedia) {
            $socialMedia->update($validated);
        } else {
            SocialMedia::create($validated);
        }
        
        Cache::forget('global_social_media'); 

        return redirect()->back()->with('success', 'Link sosial media berhasil diperbarui!');
    }
}