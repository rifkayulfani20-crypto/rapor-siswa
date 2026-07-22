<?php
namespace App\Http\Controllers;
use App\Models\{Kelas, Guru, TahunPelajaran};
use Illuminate\Http\Request;
class KelasController extends Controller {
    public function index(\Illuminate\Http\Request $request) {
        // Default filter: tahun ajaran yang sedang aktif, supaya kelas-kelas
        // lama (yang siswanya sudah dipindah lewat kenaikan kelas dan kini
        // 0 siswa) tidak numpuk memenuhi tampilan. Admin tetap bisa pilih
        // "Semua Tahun Ajaran" atau tahun ajaran lain lewat filter.
        $tapelAktif = TahunPelajaran::where('aktif', true)->first();
        $tapelFilterId = $request->input('tapel_id', $tapelAktif->id ?? '');
        $kelas = Kelas::with(['waliKelas','tahunPelajaran'])
            ->withCount('riwayatKelas')
            ->when($tapelFilterId, fn($q) => $q->where('tahun_pelajaran_id', $tapelFilterId))
            ->orderByDesc('tahun_pelajaran_id')
            ->orderByRaw("CASE tingkat WHEN 'VII' THEN 1 WHEN 'VIII' THEN 2 WHEN 'IX' THEN 3 ELSE 4 END")
            ->orderBy('nama')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
        $tapelList = TahunPelajaran::orderByDesc('id')->get();
        return view('admin.kelas.index', compact('kelas', 'tapelList', 'tapelFilterId'));
    }
    public function create() {
        return view('admin.kelas.form', ['gurus'=>Guru::orderBy('nama')->get(),'tapels'=>TahunPelajaran::orderByDesc('id')->get(),'kelas'=>null]);
    }
    public function store(Request $request) {
        $request->validate(['nama'=>'required','tingkat'=>'required','tahun_pelajaran_id'=>'required|exists:tahun_pelajarans,id']);
        Kelas::create($request->only('nama','tingkat','wali_kelas_id','tahun_pelajaran_id'));
        return redirect()->route('kelas.index')->with('success','Data kelas berhasil ditambahkan!');
    }
    public function edit(Kelas $kelas) {
        return view('admin.kelas.form', ['gurus'=>Guru::orderBy('nama')->get(),'tapels'=>TahunPelajaran::orderByDesc('id')->get(),'kelas'=>$kelas]);
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
