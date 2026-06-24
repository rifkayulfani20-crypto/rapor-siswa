<?php
namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::latest()->paginate(15);
        return view('admin.mapel.index', compact('mapels'));
    }

    public function create()
    {
        $gurus = Guru::orderBy('nama')->get();
        return view('admin.mapel.form', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:mata_pelajarans',
            'kkm'  => 'required|integer|min:0|max:100',
        ]);

        MataPelajaran::create($request->only('nama', 'kode', 'kelompok', 'kkm', 'guru_id'));
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan!');
    }

    public function edit(MataPelajaran $mapel)
    {
        $gurus = Guru::orderBy('nama')->get();
        return view('admin.mapel.form', compact('gurus', 'mapel'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:mata_pelajarans,kode,' . $mapel->id,
            'kkm'  => 'required|integer|min:0|max:100',
        ]);

        $mapel->update($request->only('nama', 'kode', 'kelompok', 'kkm', 'guru_id'));
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui!');
    }

    public function destroy(MataPelajaran $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus!');
    }
}