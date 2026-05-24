<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Kehadiran;
use App\Models\TahunPelajaran;
use App\Models\Sekolah;

class DashboardSiswaController extends Controller
{
    private function getSiswa()
    {
        return Siswa::where('user_id', auth()->id())
                    ->with('kelas')
                    ->firstOrFail();
    }

    private function getPeringkat($siswa, $tapel)
    {
        // Ambil rata-rata nilai semua siswa di kelas yang sama
        $rataKelas = Nilai::where('tahun_pelajaran_id', $tapel?->id)
            ->whereHas('siswa', fn($q) => $q->where('kelas_id', $siswa->kelas_id))
            ->selectRaw('siswa_id, AVG(nilai_akhir) as rata')
            ->groupBy('siswa_id')
            ->orderByDesc('rata')
            ->get();

        $peringkat   = 1;
        $totalSiswa  = $rataKelas->count();
        $rataSiswaIni = $rataKelas->firstWhere('siswa_id', $siswa->id)?->rata ?? 0;

        foreach ($rataKelas as $i => $item) {
            if ($item->siswa_id == $siswa->id) {
                $peringkat = $i + 1;
                break;
            }
        }

        return [
            'peringkat'   => $peringkat,
            'total_siswa' => $totalSiswa,
            'rata_rata'   => round($rataSiswaIni, 2),
        ];
    }

    public function dashboard()
    {
        $siswa     = $this->getSiswa();
        $tapel     = TahunPelajaran::aktif();
        $nilais    = Nilai::where('siswa_id', $siswa->id)
                         ->where('tahun_pelajaran_id', $tapel?->id)
                         ->with('mataPelajaran')
                         ->get();
        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
                         ->where('tahun_pelajaran_id', $tapel?->id)
                         ->first();
        $sekolah   = Sekolah::first();
        $peringkat = $this->getPeringkat($siswa, $tapel);

        return view('siswa-panel.dashboard', compact('siswa','tapel','nilais','kehadiran','sekolah','peringkat'));
    }

    public function nilai()
    {
        $siswa  = $this->getSiswa();
        $tapel  = TahunPelajaran::aktif();
        $nilais = Nilai::where('siswa_id', $siswa->id)
                       ->where('tahun_pelajaran_id', $tapel?->id)
                       ->with('mataPelajaran')
                       ->get();

        return view('siswa-panel.nilai', compact('siswa','tapel','nilais'));
    }

    public function raport()
    {
        $siswa     = $this->getSiswa();
        $tapel     = TahunPelajaran::aktif();
        $nilais    = Nilai::where('siswa_id', $siswa->id)
                         ->where('tahun_pelajaran_id', $tapel?->id)
                         ->with('mataPelajaran')
                         ->get();
        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
                         ->where('tahun_pelajaran_id', $tapel?->id)
                         ->first();
        $sekolah   = Sekolah::first();
        $peringkat = $this->getPeringkat($siswa, $tapel);

        return view('siswa-panel.raport', compact('siswa','tapel','nilais','kehadiran','sekolah','peringkat'));
    }

    public function profil()
    {
        $siswa = $this->getSiswa();
        return view('siswa-panel.profil', compact('siswa'));
    }
}