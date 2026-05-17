<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\WaliSiswa;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function index()
    {
        $walis = WaliSiswa::with('siswa.kelas')->latest()->paginate(15);
        return view('admin.walisiswa.index', compact('walis'));
    }

    public function create()
    {
        $siswas = Siswa::with('kelas')->where('status', 'Aktif')->orderBy('nama')->get();
        return view('admin.walisiswa.form', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'siswa_id'      => 'required|exists:siswas,id',
            'sebagai'       => 'required|in:Ayah,Ibu,Wali',
        ]);

        WaliSiswa::create($request->only(
            'nama', 'jenis_kelamin', 'siswa_id', 'sebagai', 'pekerjaan', 'no_hp', 'alamat'
        ));

        return redirect()->route('walisiswa.index')->with('success', 'Data wali siswa berhasil ditambahkan!');
    }

    public function edit(WaliSiswa $wali)
    {
        $siswas = Siswa::with('kelas')->where('status', 'Aktif')->orderBy('nama')->get();
        return view('admin.walisiswa.form', compact('wali', 'siswas'));
    }

    public function update(Request $request, WaliSiswa $wali)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'siswa_id'      => 'required|exists:siswas,id',
            'sebagai'       => 'required|in:Ayah,Ibu,Wali',
        ]);

        $wali->update($request->only(
            'nama', 'jenis_kelamin', 'siswa_id', 'sebagai', 'pekerjaan', 'no_hp', 'alamat'
        ));

        return redirect()->route('walisiswa.index')->with('success', 'Data wali siswa berhasil diperbarui!');
    }

    public function destroy(WaliSiswa $wali)
    {
        $wali->delete();
        return redirect()->route('walisiswa.index')->with('success', 'Data wali siswa berhasil dihapus!');
    }
}