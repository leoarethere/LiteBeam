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
            'admin_phone'       => 'required|string|max:20',
            'partnership_phone' => 'required|string|max:20',
            'hotline_phone'     => 'required|string|max:20',
            'address'           => 'required|string',
            'email'             => 'nullable|email',
            'google_maps_embed' => 'nullable|string', // <--- Tambah validasi
            'is_active'         => 'boolean',
        ]);

        $contactInfo = ContactInfo::findOrFail($id);

        $contactInfo->update([
            'admin_phone'       => $request->admin_phone,
            'partnership_phone' => $request->partnership_phone,
            'hotline_phone'     => $request->hotline_phone,
            'address'           => $request->address,
            'email'             => $request->email,
            'google_maps_embed' => $request->google_maps_embed, // <--- Simpan data
            'is_active'         => $request->has('is_active'),
        ]);

        return redirect()->route('dashboard.contact-info.index')
            ->with('success', 'Informasi kontak berhasil diperbarui!');
    }
}