<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, Nilai, TahunPelajaran};

class RaportController extends Controller {

    public function index() {
        $kelas = Kelas::with(['siswas','waliKelas','tahunPelajaran'])->get();
        return view('admin.raport.index', compact('kelas'));
    }

    public function cetak(Siswa $siswa) {
        $tapel     = TahunPelajaran::aktif();
        $nilais    = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->get();
        $kehadiran = $siswa->kehadiran;
        $prestasi  = collect();
        $catatan   = null;
        return view('admin.raport.cetak', compact('siswa','tapel','nilais','kehadiran','prestasi','catatan'));
    }
}