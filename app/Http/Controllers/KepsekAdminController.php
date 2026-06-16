<?php

namespace App\Http\Controllers;

use App\Models\Kepsek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Digunakan oleh Admin untuk mengelola data Kepala Sekolah.
 * Terpisah dari GuruController dan AdminController.
 */
class KepsekAdminController extends Controller
{
    public function index()
    {
        $kepseks = Kepsek::with('user')->latest()->paginate(10);
        return view('admin.kepsek.index', compact('kepseks'));
    }

    public function create()
    {
        return view('admin.kepsek.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'nip'           => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'kepsek',
        ]);

        Kepsek::create([
            'user_id'       => $user->id,
            'nama'          => $request->nama,
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp'         => $request->no_hp,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('admin.kepsek.index')->with('success', 'Data kepala sekolah berhasil ditambahkan!');
    }

    public function edit(Kepsek $kepsek)
    {
        return view('admin.kepsek.form', compact('kepsek'));
    }

    public function update(Request $request, Kepsek $kepsek)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $kepsek->user_id,
            'nip'           => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        $kepsek->update($request->only('nama', 'nip', 'jenis_kelamin', 'no_hp', 'tempat_lahir', 'tanggal_lahir', 'alamat'));

        if ($kepsek->user) {
            $kepsek->user->update([
                'name'  => $request->nama,
                'email' => $request->email,
            ]);
            if ($request->filled('password')) {
                $kepsek->user->update(['password' => Hash::make($request->password)]);
            }
        }

        return redirect()->route('admin.kepsek.index')->with('success', 'Data kepala sekolah berhasil diperbarui!');
    }

    public function destroy(Kepsek $kepsek)
    {
        $kepsek->user?->delete(); // cascade hapus kepsek juga
        return redirect()->route('admin.kepsek.index')->with('success', 'Data kepala sekolah berhasil dihapus!');
    }
}
