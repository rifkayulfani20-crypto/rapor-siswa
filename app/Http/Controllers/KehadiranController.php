<?php
namespace App\Http\Controllers;
use App\Models\{Kelas, Kehadiran, TahunPelajaran};
use Illuminate\Http\Request;

class KehadiranController extends Controller {
    public function index() {
        $user  = auth()->user();
        $kelas = $user->isAdmin()
            ? Kelas::with('waliKelas')->get()
            : Kelas::where('wali_kelas_id', $user->guru?->id)->get();
        return view('kehadiran.index', compact('kelas'));
    }

    public function input(Kelas $kelas) {
        $siswas = $kelas->siswas()->where('status','Aktif')->get();
        $tapel  = TahunPelajaran::aktif();
        $kehadiran = Kehadiran::where('tahun_pelajaran_id', $tapel?->id)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()->keyBy('siswa_id');
        return view('kehadiran.input', compact('kelas','siswas','tapel','kehadiran'));
    }

    public function simpan(Request $request) {
        $tapel = TahunPelajaran::aktif();
        foreach ($request->kehadiran as $siswaId => $data) {
            Kehadiran::updateOrCreate(
                ['siswa_id'=>$siswaId,'tahun_pelajaran_id'=>$tapel->id],
                ['sakit'=>$data['sakit']??0,'izin'=>$data['izin']??0,'tanpa_keterangan'=>$data['tk']??0]
            );
        }
        return back()->with('success','Data kehadiran berhasil disimpan!');
    }
}