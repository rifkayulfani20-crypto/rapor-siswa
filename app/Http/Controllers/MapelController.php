<?php
namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\TahunPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::with('tahunPelajaran')->latest()->paginate(15);
        return view('mapel.index', compact('mapels'));
    }

    public function create()
    {
        $tapels = TahunPelajaran::orderByDesc('id')->get();
        $gurus  = Guru::orderBy('nama')->get();
        return view('mapel.form', compact('tapels', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'              => 'required',
            'kode'              => 'required|unique:mata_pelajarans',
            'kkm'               => 'required|integer|min:0|max:100',
            'tahun_pelajaran_id'=> 'required',
        ]);

        MataPelajaran::create($request->only('nama', 'kode', 'kelompok', 'kkm', 'tahun_pelajaran_id', 'guru_id'));
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan!');
    }

    public function edit(MataPelajaran $mapel)
    {
        $tapels = TahunPelajaran::orderByDesc('id')->get();
        $gurus  = Guru::orderBy('nama')->get();
        return view('mapel.form', compact('tapels', 'gurus', 'mapel'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:mata_pelajarans,kode,' . $mapel->id,
            'kkm'  => 'required|integer|min:0|max:100',
        ]);

        $mapel->update($request->only('nama', 'kode', 'kelompok', 'kkm', 'tahun_pelajaran_id', 'guru_id'));
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui!');
    }

    public function destroy(MataPelajaran $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus!');
    }
}