<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'guru') {
            return view('guru-panel.profil', compact('user'));
        } elseif ($role === 'siswa') {
            $siswa = \App\Models\Siswa::where('user_id', $user->id)->with('kelas')->firstOrFail();
            return view('siswa-panel.profil', compact('user', 'siswa'));
        }

        // default admin
        return view('admin.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            // Cek password lama
            if (!$request->filled('password_lama') || !Hash::check($request->password_lama, $user->password)) {
                return back()
                    ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                    ->withInput();
            }

            $request->validate([
                'password' => 'min:6|confirmed',
            ]);

            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}