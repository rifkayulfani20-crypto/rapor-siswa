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

        // ── Dashboard ADMIN ──────────────────────────────
        if ($user->isAdmin()) {
            return view('dashboard.index', [
                'tapel'       => $tapel,
                'total_siswa' => Siswa::where('status', 'Aktif')->count(),
                'total_guru'  => Guru::count(),
                'total_kelas' => Kelas::count(),
                'total_mapel' => MataPelajaran::count(),
            ]);
        }

        // ── Dashboard GURU ──────────────────────────────
        $guruModel = $user->guru;

        $pembelajaran = Pembelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruModel?->id)
            ->where('status', 'Aktif')
            ->get();

        $kelasIds = $pembelajaran->pluck('kelas_id')->unique();
        $totalSiswaDiajar = Siswa::whereIn('kelas_id', $kelasIds)
            ->where('status', 'Aktif')
            ->count();

        $mapelIds = $pembelajaran->pluck('mata_pelajaran_id')->unique();
        $siswaIds = Siswa::whereIn('kelas_id', $kelasIds)->where('status', 'Aktif')->pluck('id');
        $nilaiSudahDiinput = Nilai::whereIn('mata_pelajaran_id', $mapelIds)
            ->whereIn('siswa_id', $siswaIds)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->count();

        // Redirect ke dashboard guru dengan layout guru
        return redirect()->route('guru.dashboard');
    }
}