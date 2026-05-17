<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Pembelajaran;
use App\Models\Siswa;
use App\Models\TahunPelajaran;

class DashboardController extends Controller
{
    public function index()
    {
        $tapel = TahunPelajaran::aktif();
        $user  = auth()->user();

        if ($user->isAdmin()) {
            return view('dashboard.index', [
                'tapel'       => $tapel,
                'total_siswa' => Siswa::where('status', 'Aktif')->count(),
                'total_guru'  => Guru::count(),
                'total_kelas' => Kelas::count(),
                'total_mapel' => MataPelajaran::count(),
            ]);
        }

        // ── Dashboard Guru ──────────────────────────────
        $guruModel = $user->guru;

        $pembelajaran = Pembelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruModel?->id)
            ->where('status', 'Aktif')
            ->get();

        // Hitung total siswa unik yang diajar
        $kelasIds = $pembelajaran->pluck('kelas_id')->unique();
        $totalSiswaDiajar = Siswa::whereIn('kelas_id', $kelasIds)
            ->where('status', 'Aktif')
            ->count();

        // Hitung nilai yang sudah diinput oleh guru ini
        $mapelIds = $pembelajaran->pluck('mata_pelajaran_id')->unique();
        $siswaIds = Siswa::whereIn('kelas_id', $kelasIds)->where('status', 'Aktif')->pluck('id');
        $nilaiSudahDiinput = Nilai::whereIn('mata_pelajaran_id', $mapelIds)
            ->whereIn('siswa_id', $siswaIds)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->count();

        return view('dashboard.index', [
            'tapel'                => $tapel,
            'pembelajaran'         => $pembelajaran,
            'total_pembelajaran'   => $pembelajaran->count(),
            'total_siswa_diajar'   => $totalSiswaDiajar,
            'total_kelas_diajar'   => $kelasIds->count(),
            'nilai_sudah_diinput'  => $nilaiSudahDiinput,
            // admin vars biar tidak error jika blade memakai admin section
            'total_siswa'          => 0,
            'total_guru'           => 0,
            'total_kelas'          => 0,
            'total_mapel'          => 0,
        ]);
    }
}