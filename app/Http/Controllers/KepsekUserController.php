<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KepsekUserController extends Controller
{
    public function index()
    {
        $kepseks = User::where('role', 'kepsek')->latest()->paginate(10);
        return view('admin.data-kepsek.index', compact('kepseks'));
    }

    public function create()
    {
        return view('admin.data-kepsek.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'kepsek',
        ]);

        return redirect()->route('kepsek-user.index')->with('success', 'Akun Kepala Sekolah berhasil ditambahkan!');
    }

    public function edit(User $kepsek)
    {
        return view('admin.data-kepsek.form', compact('kepsek'));
    }

    public function update(Request $request, User $kepsek)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $kepsek->id,
        ]);

        $kepsek->update($request->only('name', 'email'));

        if ($request->filled('password')) {
            $kepsek->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('kepsek-user.index')->with('success', 'Akun Kepala Sekolah berhasil diperbarui!');
    }

    public function destroy(User $kepsek)
    {
        $kepsek->delete();
        return redirect()->route('kepsek-user.index')->with('success', 'Akun Kepala Sekolah berhasil dihapus!');
    }
}