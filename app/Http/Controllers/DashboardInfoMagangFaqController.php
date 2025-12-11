<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoMagangFaq;
use Illuminate\Routing\Controller;

class DashboardInfoMagangFaqController extends Controller
{
    /**
     * Menampilkan daftar FAQ (Backend).
     */
    public function index()
    {
        // Ambil data diurutkan berdasarkan 'order' (terkecil ke terbesar)
        $faqs = InfoMagangFaq::orderBy('order', 'asc')->paginate(10);

        // Kita asumsikan view-nya akan disimpan di folder backend/info-magang-faq
        return view('backend.info-magang-faq.index', compact('faqs'));
    }

    /**
     * Menampilkan form tambah FAQ baru.
     */
    public function create()
    {
        return view('backend.info-magang-faq.create');
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

        // Checkbox HTML mengembalikan value "1" atau null (tidak terkirim)
        // Kita gunakan $request->has() atau boolean() untuk menangkapnya
        $validated['is_active'] = $request->has('is_active');

        InfoMagangFaq::create($validated);

        return redirect()->route('dashboard.info-magang-faq.index')
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit FAQ.
     */
    public function edit($id)
    {
        $faq = InfoMagangFaq::findOrFail($id);
        return view('backend.info-magang-faq.edit', compact('faq'));
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

        $faq = InfoMagangFaq::findOrFail($id);

        $validated['is_active'] = $request->has('is_active');

        $faq->update($validated);

        return redirect()->route('dashboard.info-magang-faq.index')
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    /**
     * Menghapus FAQ.
     */
    public function destroy($id)
    {
        $faq = InfoMagangFaq::findOrFail($id);
        $faq->delete();

        return redirect()->route('dashboard.info-magang-faq.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }
}