<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\SikapSiswa;
use App\Models\Kehadiran;
use App\Models\Sekolah;

class SiswaRaportController extends Controller
{
    private function getData()
    {
        $user      = auth()->user();
        $siswa     = Siswa::where('user_id', $user->id)->with(['kelas.waliKelas'])->firstOrFail();
        $tapel     = \App\Models\TahunPelajaran::where('aktif', true)->first();
        $nilais    = Nilai::with('mataPelajaran')
                        ->where('siswa_id', $siswa->id)
                        ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
                        ->get();
        $sikap     = SikapSiswa::where('siswa_id', $siswa->id)
                        ->where('kelas_id', $siswa->kelas_id)
                        ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
                        ->first();
        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
                        ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
                        ->first();

        $semuaSiswa    = Siswa::where('kelas_id', $siswa->kelas_id)->pluck('id');
        $rataRataSiswa = [];
        foreach ($semuaSiswa as $sid) {
            $avg = Nilai::where('siswa_id', $sid)
                ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
                ->avg('nilai_akhir');
            $rataRataSiswa[$sid] = $avg ?? 0;
        }
        arsort($rataRataSiswa);
        $peringkat  = array_search($siswa->id, array_keys($rataRataSiswa)) + 1;
        $totalSiswa = count($rataRataSiswa);
        $rataRata   = round($nilais->avg('nilai_akhir'), 2);

        return compact('siswa', 'tapel', 'nilais', 'sikap', 'kehadiran', 'peringkat', 'totalSiswa', 'rataRata');
    }

    public function index()
    {
        return view('siswa-panel.raport', $this->getData());
    }

    public function cetak()
    {
        return view('siswa-panel.cetak-raport', $this->getData());
    }
}