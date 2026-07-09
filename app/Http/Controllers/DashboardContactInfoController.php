<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardContactInfoController extends Controller
{
    /**
     * Menampilkan daftar kontak (biasanya hanya ada 1 data).
     */
    public function index()
    {
        // 1. Ambil data pertama
        $contactInfo = ContactInfo::first();
        
        // 2. LOGIKA BARU: Jika data tidak ditemukan (null), buat data default otomatis
        if (!$contactInfo) {
            $contactInfo = ContactInfo::create([
                'admin_phone'       => '-',
                'partnership_phone' => '-',
                'hotline_phone'     => '-',
                'address'           => '-',
                'email'             => null,
                'is_active'         => false,
            ]);
        }
        
        return view('backend.contact-info.index', compact('contactInfo'));
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        $contactInfo = ContactInfo::findOrFail($id);
        return view('backend.contact-info.edit', compact('contactInfo'));
    }

    /**
     * Memproses update data ke database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'admin_phone'       => 'required|string|max:40',
            'partnership_phone' => 'required|string|max:40',
            'hotline_phone'     => 'required|string|max:40',
            'address'           => 'required|string',
            'email'             => 'nullable|email',
            'google_maps_embed' => 'nullable|string|max:2000',
        ]);

        $contactInfo = ContactInfo::findOrFail($id);

        // ✅ PERBAIKAN: Ekstrak URL src dari iframe tag jika user input full iframe
        $googleMapsEmbed = $request->google_maps_embed;
        
        if ($googleMapsEmbed) {
            // Cek apakah input berupa full iframe tag
            if (str_contains($googleMapsEmbed, '<iframe')) {
                // Ekstrak src menggunakan regex
                preg_match('/src="([^"]+)"/', $googleMapsEmbed, $matches);
                if (isset($matches[1])) {
                    $googleMapsEmbed = $matches[1]; // Ambil hanya URL-nya
                }
            }
            
            // Validasi bahwa hasilnya adalah URL Google Maps Embed yang valid
            if (!preg_match('#^https://www\.google\.com/maps/embed#', $googleMapsEmbed)) {
                return back()->withErrors([
                    'google_maps_embed' => 'Link yang Anda masukkan bukan link Google Maps Embed yang valid. Pastikan URL diawali dengan https://www.google.com/maps/embed'
                ])->withInput();
            }
        }

        $contactInfo->update([
            'admin_phone'       => $request->admin_phone,
            'partnership_phone' => $request->partnership_phone,
            'hotline_phone'     => $request->hotline_phone,
            'address'           => $request->address,
            'email'             => $request->email,
            'google_maps_embed' => $googleMapsEmbed, // Simpan URL yang sudah dibersihkan
            'is_active'         => $request->has('is_active'),
        ]);

        return redirect()->route('dashboard.contact-info.index')
            ->with('success', 'Informasi kontak berhasil diperbarui!');
    }
}