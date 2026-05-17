<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas};
use Illuminate\Http\Request;

class SiswaController extends Controller {
    public function index() {
        $siswas = Siswa::with('kelas')->latest()->paginate(15);
        return view('siswa.index', compact('siswas'));
    }

    public function create() {
        $kelas = Kelas::orderBy('nama')->get();
        return view('siswa.form', compact('kelas'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nama'          => 'required|string|max:255',
            'nis'           => 'required|string|unique:siswas',
            'nisn'          => 'nullable|string|unique:siswas',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'nama_ayah'     => 'nullable|string',
            'nama_ibu'      => 'nullable|string',
            'nama_wali'     => 'nullable|string',
            'no_hp_ortu'    => 'nullable|string',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);
        Siswa::create($data);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa) {
        $siswa->load('kelas','nilais.mataPelajaran','kehadiran','prestasi','catatan');
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa) {
        $kelas = Kelas::orderBy('nama')->get();
        return view('siswa.form', compact('siswa','kelas'));
    }

    public function update(Request $request, Siswa $siswa) {
        $data = $request->validate([
            'nama'          => 'required|string|max:255',
            'nis'           => 'required|string|unique:siswas,nis,'.$siswa->id,
            'nisn'          => 'nullable|string|unique:siswas,nisn,'.$siswa->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'nama_ayah'     => 'nullable|string',
            'nama_ibu'      => 'nullable|string',
            'nama_wali'     => 'nullable|string',
            'no_hp_ortu'    => 'nullable|string',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);
        $siswa->update($data);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa) {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}
