<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'], 
        ]);

        // PERBAIKAN: Mengarahkan ke URL '/login' yang benar.
        // // Opsi 1: Menggunakan URL path langsung (disarankan jika route sederhana)
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
        
        // // Opsi 2: Menggunakan nama route (praktik terbaik jika Anda menamai route Anda)
        // return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}