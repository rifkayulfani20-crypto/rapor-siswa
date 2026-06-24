<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, Nilai, TahunPelajaran, SikapSiswa, Kehadiran};

class RaportController extends Controller {

    public function index() {
        $tapel = TahunPelajaran::aktif();
        $kelas = Kelas::with(['siswas', 'waliKelas', 'tahunPelajaran'])->get();
        return view('admin.raport.index', compact('kelas', 'tapel'));
    }

    public function cetak(Siswa $siswa) {
        $tapel     = TahunPelajaran::aktif();
        $nilais    = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->get();
        $sikap     = SikapSiswa::where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->first();
        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->first();
        $prestasi  = collect();
        $catatan   = null;
        return view('admin.raport.cetak', compact('siswa','tapel','nilais','kehadiran','sikap','prestasi','catatan'));
    }
}