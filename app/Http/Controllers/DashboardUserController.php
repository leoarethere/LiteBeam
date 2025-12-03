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

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User admin baru berhasil ditambahkan!');
    }

    // Menampilkan form edit user
    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    // Mengupdate data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Validasi email unik kecuali punya user ini sendiri
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', 'min:8'], // Password opsional
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya ganti password jika input password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    // Menghapus user
    public function destroy(User $user)
    {
        // Proteksi: Tidak boleh menghapus diri sendiri
        if (Auth::user()->id === $user->id) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun sendiri yang sedang login.']);
        }

        $user->delete();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}