<?php

namespace App\Http\Controllers;

use App\Models\LinkSource;
use App\Models\TvSchedule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardTvScheduleController extends Controller
{
    /**
     * Menampilkan daftar jadwal acara.
     */
    public function index()
    {
        // Kita ambil data dan urutkan berdasarkan urutan hari (Senin s/d Minggu) dan Jam
        $schedules = TvSchedule::orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                               ->orderBy('time', 'asc')
                               ->paginate(20);

        return view('backend.tv-schedules.index', compact('schedules'));
    }

    /**
     * Menampilkan form tambah jadwal baru.
     */
    public function create()
    {
        // Ambil data sumber link yang aktif untuk pilihan dropdown
        $sources = LinkSource::where('is_active', true)->get();
        
        return view('backend.tv-schedules.create', compact('sources'));
    }

    /**
     * Menyimpan data jadwal baru ke database.
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

        // Set default is_active ke 1 jika dicek, atau logika default controller
        $validated['is_active'] = $request->has('is_active') ? 1 : 1; 

        TvSchedule::create($validated);

        return redirect()->route('dashboard.tv-schedules.index')
                         ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit jadwal.
     */
    public function edit(TvSchedule $tvSchedule)
    {
        $sources = LinkSource::where('is_active', true)->get();
        
        return view('backend.tv-schedules.edit', compact('tvSchedule', 'sources'));
    }

    /**
     * Memperbarui data jadwal yang diedit.
     */
    public function update(Request $request, TvSchedule $tvSchedule)
    {
        $validated = $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'time' => 'required',
            'program_name' => 'required|string|max:255',
            'link_source_id' => 'nullable|exists:link_sources,id',
            'is_active' => 'nullable|in:0,1',
        ]);

        // Pastikan checkbox terhandle dengan benar (jika tidak dicentang, nilainya 0)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $tvSchedule->update($validated);

        return redirect()->route('dashboard.tv-schedules.index')
                         ->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Menghapus jadwal.
     */
    public function destroy(TvSchedule $tvSchedule)
    {
        $tvSchedule->delete();

        return redirect()->route('dashboard.tv-schedules.index')
                         ->with('success', 'Jadwal berhasil dihapus!');
    }
}