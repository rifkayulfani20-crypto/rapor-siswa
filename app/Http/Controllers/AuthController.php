<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'role'     => 'required|in:admin,guru,siswa,kepsek',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $role         = Auth::user()->role;   // role asli di database
            $selectedRole = $request->role;        // role yang dipilih di dropdown

            // Pasangan role yang boleh saling login (cross-login)
            // Contoh: akun kepsek boleh login walau pilih "guru", dan sebaliknya.
            $crossAllowed = [
                'guru'   => 'kepsek',
                'kepsek' => 'guru',
            ];

            $isMismatch = $role !== $selectedRole;
            $isCrossAllowed = $isMismatch
                && isset($crossAllowed[$role])
                && $crossAllowed[$role] === $selectedRole;

            // Kalau role tidak cocok DAN bukan pasangan yang diizinkan -> tolak
            if ($isMismatch && !$isCrossAllowed) {
                Auth::logout();
                return back()->withErrors(['email' => 'Role yang dipilih tidak sesuai dengan akun ini.'])->onlyInput('email');
            }

            // Redirect selalu berdasarkan role ASLI di database, bukan yang dipilih di dropdown
            if ($role === 'admin') {
                return redirect()->route('dashboard');
            } elseif ($role === 'guru') {
                return redirect()->route('guru.dashboard');
            } elseif ($role === 'siswa') {
                return redirect()->route('siswa.dashboard');
            } elseif ($role === 'kepsek') {
                return redirect()->route('kepsek.dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Role tidak dikenali.']);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}