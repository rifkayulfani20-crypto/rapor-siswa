<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\TahunPelajaran;

class DashboardSiswaController extends Controller
{
    private function getSiswa()
    {
        return Siswa::where('user_id', auth()->id())
            ->with(['kelas.waliKelas'])
            ->firstOrFail();
    }

    public function dashboard()
    {
        $siswa = $this->getSiswa();
        $tapel = TahunPelajaran::aktif();

        $jumlahNilai = Nilai::where('siswa_id', $siswa->id)
            ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->count();

        $rataRata = round(Nilai::where('siswa_id', $siswa->id)
            ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->avg('nilai_akhir') ?? 0, 1);

        return view('siswa-panel.dashboard', compact('siswa', 'tapel', 'jumlahNilai', 'rataRata'));
    }

    public function nilai()
    {
        $siswa = $this->getSiswa();
        $tapel = TahunPelajaran::aktif();

        $nilais = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->get();

        return view('siswa-panel.nilai', compact('siswa', 'tapel', 'nilais'));
    }

    public function profil()
    {
        $siswa = $this->getSiswa();
        return view('siswa-panel.profil', compact('siswa'));
    }
}