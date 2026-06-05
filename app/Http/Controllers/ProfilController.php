<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller {

    public function index() {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'kepsek') {
            return view('kepsek.profil', compact('user'));
        } elseif ($role === 'guru') {
            return view('guru-panel.profil', compact('user'));
        } elseif ($role === 'siswa') {
            return view('siswa-panel.profil', compact('user'));
        }

        // default admin
        return view('admin.profil.index', ['user' => $user]);
    }

    public function update(Request $request) {
        $user = auth()->user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        $user->update(['name' => $request->name, 'email' => $request->email]);
        if ($request->filled('password')) {
            $request->validate([
                'password'              => 'min:6',
                'password_confirmation' => 'required|same:password'
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}