<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoKunjunganFaq;
use Illuminate\Routing\Controller;

class DashboardInfoKunjunganFaqController extends Controller
{
    /**
     * Menampilkan daftar FAQ Kunjungan (Backend).
     */
    public function index()
    {
        // Ambil data diurutkan berdasarkan 'order' (terkecil ke terbesar)
        $faqs = InfoKunjunganFaq::orderBy('order', 'asc')->paginate(10);

        return view('backend.info-kunjungan-faq.index', compact('faqs'));
    }

    /**
     * Menampilkan form tambah FAQ baru.
     */
    public function create()
    {
        return view('backend.info-kunjungan-faq.create');
    }

    /**
     * Menyimpan data FAQ baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string',
            'order'     => 'required|integer|min:0',
        ]);

        // Checkbox handling
        $validated['is_active'] = $request->has('is_active');

        InfoKunjunganFaq::create($validated);

        return redirect()->route('dashboard.info-kunjungan-faq.index')
            ->with('success', 'FAQ Kunjungan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit FAQ.
     */
    public function edit($id)
    {
        $faq = InfoKunjunganFaq::findOrFail($id);
        return view('backend.info-kunjungan-faq.edit', compact('faq'));
    }

    /**
     * Memperbarui data FAQ.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question'  => 'required|string|max:255',
            'answer'    => 'required|string',
            'order'     => 'required|integer|min:0',
        ]);

        $faq = InfoKunjunganFaq::findOrFail($id);

        $validated['is_active'] = $request->has('is_active');

        $faq->update($validated);

        return redirect()->route('dashboard.info-kunjungan-faq.index')
            ->with('success', 'FAQ Kunjungan berhasil diperbarui!');
    }

    /**
     * Menghapus FAQ.
     */
    public function destroy($id)
    {
        $faq = InfoKunjunganFaq::findOrFail($id);
        $faq->delete();

        return redirect()->route('dashboard.info-kunjungan-faq.index')
            ->with('success', 'FAQ Kunjungan berhasil dihapus!');
    }
}