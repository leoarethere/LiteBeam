<?php

namespace App\Http\Controllers;

use App\Models\LinkSource;
use App\Models\TvSchedule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardJadwalAcaraController extends Controller
{
    /**
     * Menampilkan daftar jadwal.
     */
    public function index()
    {
        $schedules = TvSchedule::orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                               ->orderBy('time', 'asc')
                               ->paginate(20);

        // Perhatikan view-nya mengarah ke folder 'jadwal-acara'
        return view('backend.jadwal-acara.index', compact('schedules'));
    }

    /**
     * Form tambah.
     */
    public function create()
    {
        $sources = LinkSource::where('is_active', true)->get();
        return view('backend.jadwal-acara.create', compact('sources'));
    }

    /**
     * Simpan data.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'time' => 'required',
            'program_name' => 'required|string|max:255',
            'link_source_id' => 'nullable|exists:link_sources,id',
            'is_active' => 'nullable|in:0,1',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 1; 

        TvSchedule::create($validated);

        // Redirect ke route 'dashboard.jadwal-acara.index'
        return redirect()->route('dashboard.jadwal-acara.index')
                         ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Form edit.
     */
    public function edit(TvSchedule $jadwal_acara) // Parameter binding bisa disesuaikan, tapi menggunakan model TvSchedule
    {
        $sources = LinkSource::where('is_active', true)->get();
        
        // Kita kirim variabel $tvSchedule ke view agar tidak perlu ubah banyak kode view
        return view('backend.jadwal-acara.edit', [
            'tvSchedule' => $jadwal_acara,
            'sources' => $sources
        ]);
    }

    /**
     * Update data.
     */
    public function update(Request $request, TvSchedule $jadwal_acara)
    {
        $validated = $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'time' => 'required',
            'program_name' => 'required|string|max:255',
            'link_source_id' => 'nullable|exists:link_sources,id',
            'is_active' => 'nullable|in:0,1',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $jadwal_acara->update($validated);

        return redirect()->route('dashboard.jadwal-acara.index')
                         ->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Hapus data.
     */
    public function destroy(TvSchedule $jadwal_acara)
    {
        $jadwal_acara->delete();

        return redirect()->route('dashboard.jadwal-acara.index')
                         ->with('success', 'Jadwal berhasil dihapus!');
    }
}