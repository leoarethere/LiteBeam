<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\TaskFunction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardTaskFunctionController extends Controller
{
    public function index(): View
    {
        // Urutkan berdasarkan Tipe (Tugas dulu, baru Fungsi), lalu Urutan
        $tasks = TaskFunction::orderBy('type', 'desc') // 'tugas' (T) > 'fungsi' (F) secara abjad desc
                             ->orderBy('order', 'asc')
                             ->get();

        return view('backend.tugas-fungsi.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('backend.tugas-fungsi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'      => 'required|in:tugas,fungsi',
            'order'     => 'required|integer',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'content'   => 'required|string',
        ]);

        // Handle Checkbox "Status Aktif"
        $validated['is_active'] = $request->has('is_active');

        // Handle Image
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = 'tf-' . Str::random(20) . '.jpg';
                $path = 'task-images/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($path, (string) $encoded);
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal upload gambar: ' . $e->getMessage()])->withInput();
            }
        }

        TaskFunction::create($validated);

        return redirect()->route('dashboard.tugas-fungsi.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(TaskFunction $tugas_fungsi): View
    {
        return view('backend.tugas-fungsi.edit', ['task' => $tugas_fungsi]);
    }

    public function update(Request $request, TaskFunction $tugas_fungsi): RedirectResponse
    {
        $validated = $request->validate([
            'type'      => 'required|in:tugas,fungsi',
            'order'     => 'required|integer',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'content'   => 'required|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($tugas_fungsi->image && Storage::disk('public')->exists($tugas_fungsi->image)) {
                Storage::disk('public')->delete($tugas_fungsi->image);
            }

            try {
                $file = $request->file('image');
                $filename = 'tf-' . Str::random(20) . '.jpg';
                $path = 'task-images/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->scale(width: 800);
                $encoded = $image->toJpeg(quality: 80);

                Storage::disk('public')->put($path, (string) $encoded);
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal upload gambar: ' . $e->getMessage()])->withInput();
            }
        }

        $tugas_fungsi->update($validated);

        return redirect()->route('dashboard.tugas-fungsi.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(TaskFunction $tugas_fungsi): RedirectResponse
    {
        if ($tugas_fungsi->image && Storage::disk('public')->exists($tugas_fungsi->image)) {
            Storage::disk('public')->delete($tugas_fungsi->image);
        }

        $tugas_fungsi->delete();

        return redirect()->route('dashboard.tugas-fungsi.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}