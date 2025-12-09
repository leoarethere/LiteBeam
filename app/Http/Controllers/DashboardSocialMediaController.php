<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DashboardSocialMediaController extends Controller
{
    public function index()
    {
        // Mengambil data pertama, atau buat instance baru jika kosong
        $socialMedia = SocialMedia::first() ?? new SocialMedia();
        
        return view('backend.social-media.index', compact('socialMedia'));
    }

    public function update(Request $request)
    {
        // 1. Validasi
        // Tips: 'nullable|url' mengharuskan user mengetik 'http://' atau 'https://'
        // Jika user sering lupa, validasi bisa diganti string biasa atau diberi petunjuk di UI.
        $validated = $request->validate([
            'email'     => 'nullable|email',
            'phone'     => 'nullable|string|max:20',
            'instagram' => 'nullable|url',
            'twitter'   => 'nullable|url',
            'facebook'  => 'nullable|url',
            'tiktok'    => 'nullable|url',
            'youtube'   => 'nullable|url',
        ], [
            // Opsional: Custom error message agar lebih jelas
            'url' => 'Format URL harus diawali http:// atau https://'
        ]);

        try {
            // 2. Logika Update or Create (Singleton Pattern)
            $socialMedia = SocialMedia::first();

            if ($socialMedia) {
                // Jika data sudah ada, update row tersebut
                $socialMedia->update($validated);
                Log::info('Social Media Updated:', $validated);
            } else {
                // Jika data belum ada (tabel kosong), buat baru
                SocialMedia::create($validated);
                Log::info('Social Media Created:', $validated);
            }
            
            // 3. Hapus cache agar perubahan muncul di frontend (Navbar/Footer)
            Cache::forget('global_social_media');

            return redirect()->back()->with('success', 'Link sosial media dan kontak berhasil diperbarui!');
            
        } catch (\Exception $e) {
            // Log error untuk developer
            Log::error('Error updating social media: ' . $e->getMessage());
            
            // Tampilkan pesan error ke user
            return redirect()->back()
                ->withInput() // Penting: Kembalikan input user agar tidak perlu ngetik ulang
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}