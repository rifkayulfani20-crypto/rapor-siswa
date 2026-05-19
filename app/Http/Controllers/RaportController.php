<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, Nilai, TahunPelajaran};

class RaportController extends Controller {
    public function index() {
        $kelas = Kelas::with(['siswas','waliKelas','tahunPelajaran'])->get();
        return view('raport.index', compact('kelas'));
    }

    public function cetak(Siswa $siswa) {
        $tapel    = TahunPelajaran::aktif();
        $nilais   = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->get();
        $kehadiran = $siswa->kehadiran;
        $prestasi  = collect(); // kosongkan dulu karena model Prestasi belum ada
        $catatan   = null;       // belum ada model CatatanSiswa
        return view('raport.cetak', compact('siswa','tapel','nilais','kehadiran','prestasi','catatan'));
    }
}