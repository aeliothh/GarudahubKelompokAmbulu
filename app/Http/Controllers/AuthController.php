<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi pengguna.
     */
    public function register(Request $request)
    {
        // Validasi data registrasi
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:klien,developer',
        ]);

        // Membuat akun baru
        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Memperbarui session untuk keamanan
        $request->session()->regenerate();

        return redirect('/dashboard')
            ->with('success', 'Registrasi berhasil!');
    }

    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses login pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Memeriksa email dan password
        if (Auth::attempt($credentials)) {

            // Memperbarui session untuk keamanan
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')
                ->with('success', 'Login berhasil!');
        }

        // Jika login gagal
        return back()
            ->withErrors([
                'email' => 'Email atau password tidak sesuai.',
            ])
            ->onlyInput('email');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        // Mengakhiri sesi autentikasi
        Auth::logout();

        // Menghapus session lama
        $request->session()->invalidate();

        // Membuat token CSRF baru
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Kamu berhasil logout!');
    }
}
