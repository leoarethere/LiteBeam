<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profile
     */
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update profile user
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // 1. Validasi Data Dasar (Nama & Email)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
        ]);

        // 2. Update Data Dasar
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // 3. Logika Ganti Password (Jika user mengisi kolom password)
        if ($request->filled('current_password') || $request->filled('password')) {
            // Validasi password fields
            $request->validate([
                'current_password' => ['required_with:password'], 
                'password' => ['required', 'min:8', 'confirmed'],
            ], [
                'current_password.required_with' => 'Password lama wajib diisi jika ingin mengganti password.',
                'password.required' => 'Password baru wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]);

            // Verifikasi password lama
            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Password lama yang Anda masukkan salah.',
                ]);
            }

            // Update password baru
            $user->password = Hash::make($request->password);
        }

        // 4. Simpan perubahan
        try {
            $user->save();
            
            return redirect()->route('profile.edit')
                ->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus akun user (opsional, jika diperlukan)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}