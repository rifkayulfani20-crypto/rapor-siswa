<?php
namespace App\Http\Controllers;
use App\Models\{Pembelajaran, Guru, MataPelajaran, Kelas, TahunPelajaran};
use Illuminate\Http\Request;

class PembelajaranController extends Controller {
    public function index() {
        $pembelajaran = Pembelajaran::with(['guru','mataPelajaran','kelas'])->paginate(15);
        return view('pembelajaran.index', compact('pembelajaran'));
    }
    public function create() {
        return view('pembelajaran.form', [
            'gurus'   => Guru::orderBy('nama')->get(),
            'mapels'  => MataPelajaran::orderBy('nama')->get(),
            'kelas'   => Kelas::orderBy('nama')->get(),
            'tapels'  => TahunPelajaran::orderByDesc('id')->get(),
            'item'    => null,
        ]);
    }
    public function store(Request $request) {
        $request->validate(['guru_id'=>'required','mata_pelajaran_id'=>'required','kelas_id'=>'required','tahun_pelajaran_id'=>'required']);
        Pembelajaran::create($request->only('guru_id','mata_pelajaran_id','kelas_id','tahun_pelajaran_id','status'));
        return redirect()->route('pembelajaran.index')->with('success','Data pembelajaran berhasil ditambahkan!');
    }
    public function destroy(Pembelajaran $pembelajaran) {
        $pembelajaran->delete();
        return redirect()->route('pembelajaran.index')->with('success','Data pembelajaran berhasil dihapus!');
    }
}
