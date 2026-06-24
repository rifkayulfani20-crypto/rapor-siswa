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

            $totalSiswa = Siswa::where('status', 'Aktif')->count();
            $totalMapel = MataPelajaran::count();

            $nilaiSudahDiinput = Nilai::when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))->count();

            $persen = ($totalSiswa > 0 && $totalMapel > 0)
                ? round($nilaiSudahDiinput / ($totalSiswa * $totalMapel) * 100)
                : 0;

            // Data siswa per kelas untuk chart, diurutkan per tingkat lalu nama
            // supaya kelas dalam tingkat yang sama berdekatan dan mudah dibandingkan
            $siswaPerKelas = Kelas::withCount(['siswas' => fn($q) => $q->where('status', 'Aktif')])
                ->orderBy('tingkat')
                ->orderBy('nama')
                ->get()
                ->map(fn($k) => [
                    'nama'    => $k->nama,
                    'tingkat' => $k->tingkat,
                    'total'   => $k->siswas_count,
                ]);

            return view('dashboard.index', [
                'tapel'               => $tapel,
                'total_siswa'         => $totalSiswa,
                'total_guru'          => Guru::count(),
                'total_kelas'         => Kelas::count(),
                'total_mapel'         => $totalMapel,
                'nilai_sudah_diinput' => $nilaiSudahDiinput,
                'persen'              => $persen,
                'siswa_per_kelas'     => $siswaPerKelas,
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

        return redirect()->route('guru.dashboard');
    }
}