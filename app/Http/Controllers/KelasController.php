<?php
namespace App\Http\Controllers;
use App\Models\{Kelas, Guru, TahunPelajaran};
use Illuminate\Http\Request;

class KelasController extends Controller {
    public function index() {
        $kelas = Kelas::with(['waliKelas','tahunPelajaran'])->withCount('siswas')->paginate(15);
        return view('kelas.index', compact('kelas'));
    }
    public function create() {
        return view('kelas.form', ['gurus'=>Guru::orderBy('nama')->get(),'tapels'=>TahunPelajaran::orderByDesc('id')->get(),'kelas'=>null]);
    }
    public function store(Request $request) {
        $request->validate(['nama'=>'required','tingkat'=>'required','tahun_pelajaran_id'=>'required|exists:tahun_pelajarans,id']);
        Kelas::create($request->only('nama','tingkat','wali_kelas_id','tahun_pelajaran_id'));
        return redirect()->route('kelas.index')->with('success','Data kelas berhasil ditambahkan!');
    }
    public function edit(Kelas $kelas) {
        return view('kelas.form', ['gurus'=>Guru::orderBy('nama')->get(),'tapels'=>TahunPelajaran::orderByDesc('id')->get(),'kelas'=>$kelas]);
    }
    public function update(Request $request, Kelas $kelas) {
        $request->validate(['nama'=>'required','tingkat'=>'required','tahun_pelajaran_id'=>'required']);
        $kelas->update($request->only('nama','tingkat','wali_kelas_id','tahun_pelajaran_id'));
        return redirect()->route('kelas.index')->with('success','Data kelas berhasil diperbarui!');
    }
    public function destroy(Kelas $kelas) {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success','Data kelas berhasil dihapus!');
    }
}