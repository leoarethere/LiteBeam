<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardUserController extends Controller
{
    // Menampilkan daftar user
    public function index(Request $request)
    {
        $query = User::query();

        // Fitur Pencarian (dibungkus grouping agar aman)
        if ($request->filled('search')) {
            $search = str_replace(['%', '_'], ['\%', '\_'], $request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Tampilkan 10 user per halaman
        $users = $query->latest()->paginate(10)->withQueryString();

        return view('backend.users.index', compact('users'));
    }

    // Menampilkan form tambah user
    public function create()
    {
        return view('backend.users.create');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => Auth::user()->is_admin ? ($request->is_admin ?? false) : false,
        ]);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User admin baru berhasil ditambahkan!');
    }

    // Menampilkan form edit user
    public function edit(User $user)
    {
        // Proteksi: Admin Secondary (is_admin = 0) tidak bisa mengedit Akun Utama (is_admin = 1)
        if (!Auth::user()->is_admin && $user->is_admin) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah Akun Utama.');
        }

        return view('backend.users.edit', compact('user'));
    }

    // ✅ PERBAIKAN: Mengupdate data user
    public function update(Request $request, User $user)
    {
        // Proteksi: Admin Secondary (is_admin = 0) tidak bisa mengedit Akun Utama (is_admin = 1)
        if (!Auth::user()->is_admin && $user->is_admin) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah Akun Utama.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        // Proteksi: Cegah penurunan jabatan jika ini adalah Akun Utama terakhir
        $newIsAdmin = Auth::user()->is_admin ? ($request->has('is_admin') ? $request->is_admin : $user->is_admin) : $user->is_admin;
        if ($user->is_admin && !$newIsAdmin) {
            $totalPrimaryAdmins = User::where('is_admin', true)->count();
            if ($totalPrimaryAdmins <= 1) {
                return back()->withErrors(['error' => 'Tidak dapat mengubah role. Harus ada setidaknya satu Akun Utama di dalam sistem.']);
            }
        }

        // ✅ PERBAIKAN: Gunakan array untuk update mass assignment
        $dataToUpdate = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'is_admin' => $newIsAdmin,
        ];

        // ✅ PERBAIKAN: Hanya update password jika diisi
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        // ✅ PERBAIKAN: Update menggunakan method update() dengan array
        $user->update($dataToUpdate);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    // Menghapus user
    public function destroy(User $user)
    {
        // Proteksi: Admin Secondary (is_admin = 0) tidak bisa menghapus Akun Utama (is_admin = 1)
        if (!Auth::user()->is_admin && $user->is_admin) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus Akun Utama.');
        }

        // Proteksi: Tidak boleh menghapus diri sendiri
        if (Auth::user()->id === $user->id) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun sendiri yang sedang login.']);
        }

        // Proteksi: Cegah penghapusan jika ini adalah Akun Utama terakhir
        if ($user->is_admin) {
            $totalPrimaryAdmins = User::where('is_admin', true)->count();
            if ($totalPrimaryAdmins <= 1) {
                return back()->withErrors(['error' => 'Tidak dapat menghapus user ini. Harus ada setidaknya satu Akun Utama di dalam sistem.']);
            }
        }

        // Proteksi: Cek apakah user masih memiliki konten (Post/News)
        $totalPosts = $user->posts()->count();
        $totalNews = $user->news()->count();

        if ($totalPosts > 0 || $totalNews > 0) {
            $detail = [];
            if ($totalPosts > 0) $detail[] = $totalPosts . ' postingan';
            if ($totalNews > 0) $detail[] = $totalNews . ' berita';

            return back()->withErrors([
                'error' => 'Gagal menghapus! User ini masih memiliki ' . implode(' dan ', $detail) . '. Pindahkan atau hapus kontennya terlebih dahulu.'
            ]);
        }

        $user->delete();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}