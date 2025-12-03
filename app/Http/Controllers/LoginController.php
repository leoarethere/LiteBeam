<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function index(): View
    {
        return view('auth.login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    /**
     * Menangani proses login pengguna.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // 2. Coba untuk mengautentikasi pengguna dengan remember me
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Jika berhasil, regenerate session untuk keamanan
            $request->session()->regenerate();

            // Arahkan ke halaman dashboard dengan notifikasi sukses
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // 3. Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menangani proses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Dapatkan nama user sebelum logout
        $userName = Auth::user()->name;

        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // ✅ UBAH DARI route('home') MENJADI route('login')
        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout. Sampai jumpa, ' . $userName . '!');
    }
}