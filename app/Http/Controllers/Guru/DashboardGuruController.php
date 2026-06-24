<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Pembelajaran;
use App\Models\Nilai;
use App\Models\SikapSiswa;
use App\Models\Kehadiran;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardGuruController extends Controller
{
    private function getGuruId()
    {
        $guru = Guru::where('user_id', auth()->id())->first();
        return $guru->id ?? 0;
    }

    public function index()
    {
        $guruId = $this->getGuruId();
        $tapel  = TahunPelajaran::aktif();

        $pembelajarans = Pembelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruId)
            ->where('status', 'Aktif')
            ->get();

        $kelasIds = $pembelajarans->pluck('kelas_id')->unique();
        $mapelIds = $pembelajarans->pluck('mata_pelajaran_id')->unique();
        $siswaIds = Siswa::whereIn('kelas_id', $kelasIds)->where('status', 'Aktif')->pluck('id');

        $nilaiSudahDiinput = Nilai::whereIn('mata_pelajaran_id', $mapelIds)
            ->whereIn('siswa_id', $siswaIds)
            ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->count();

        $totalTarget = $mapelIds->count() * $siswaIds->count();
        $persen = $totalTarget > 0 ? round($nilaiSudahDiinput / $totalTarget * 100) : 0;

        $siswaPerKelas = Kelas::whereIn('id', $kelasIds)
            ->withCount(['siswas' => fn($q) => $q->where('status', 'Aktif')])
            ->get()
            ->map(fn($k) => [
                'nama'  => $k->nama,
                'total' => $k->siswas_count,
            ]);

        $nilaiPerMapel = $pembelajarans->map(function($p) use ($siswaIds, $tapel) {
            $avg = Nilai::where('mata_pelajaran_id', $p->mata_pelajaran_id)
                ->whereIn('siswa_id', $siswaIds)
                ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
                ->avg('nilai_akhir');
            return [
                'nama' => $p->mataPelajaran->nama ?? '-',
                'rata' => round($avg ?? 0, 1),
            ];
        })->unique('nama')->values();

        return view('guru-panel.dashboard', [
            'total_mapel'     => $mapelIds->count(),
            'total_kelas'     => $kelasIds->count(),
            'persen'          => $persen,
            'siswa_per_kelas' => $siswaPerKelas,
            'nilai_per_mapel' => $nilaiPerMapel,
        ]);
    }

    public function profil()
    {
        return view('guru-panel.profil');
    }

    public function profilUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            if (!$request->filled('password_lama') || !Hash::check($request->password_lama, $user->password)) {
                return back()
                    ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                    ->withInput();
            }

            $request->validate([
                'password' => 'min:6|confirmed',
            ]);

            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function siswaIndex()
    {
        $siswas = Siswa::with('kelas')->get();
        return view('guru-panel.siswa.index', compact('siswas'));
    }

    public function kelasIndex()
    {
        $guruId = $this->getGuruId();
        $kelass = Kelas::with(['waliKelas', 'tahunPelajaran'])
                    ->where('wali_kelas_id', $guruId)
                    ->get();
        return view('guru-panel.walikelas.kelas', compact('kelass'));
    }

    public function kelasSiswa($kelas)
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($kelas);
        return view('guru-panel.walikelas.kelas-siswa', compact('kelas'));
    }

    public function nilaiSosialIndex()
    {
        $guruId = $this->getGuruId();
        $kelass = Kelas::with(['waliKelas', 'tahunPelajaran'])
                    ->where('wali_kelas_id', $guruId)
                    ->get();
        return view('guru-panel.walikelas.nilaisosial', compact('kelass'));
    }

    public function nilaiSosialEdit($kelas)
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($kelas);
        $tapel = $kelas->tahunPelajaran;
        return view('guru-panel.walikelas.nilaisosial-edit', compact('kelas', 'tapel'));
    }

    public function nilaiSosialUpdate(Request $request, $kelas)
    {
        $kelasModel = Kelas::with('tahunPelajaran')->findOrFail($kelas);
        $tapel = $kelasModel->tahunPelajaran;

        if ($tapel && $tapel->is_locked) {
            return back()->with('error',
                '🔒 Nilai untuk tahun pelajaran "' . $tapel->nama . ' - ' . $tapel->semester . '" sedang dikunci oleh Kepala Sekolah.'
            );
        }

        foreach ($request->siswa_id as $i => $siswaId) {
            SikapSiswa::updateOrCreate(
                [
                    'siswa_id'           => $siswaId,
                    'kelas_id'           => $kelas,
                    'tahun_pelajaran_id' => $kelasModel->tahun_pelajaran_id,
                ],
                [
                    'predikat_sosial'  => $request->predikat[$i] ?? null,
                    'deskripsi_sosial' => $request->deskripsi[$i] ?? null,
                ]
            );
        }
        return back()->with('success', 'Nilai sosial berhasil disimpan!');
    }

    public function nilaiSpiritualIndex()
    {
        $guruId = $this->getGuruId();
        $kelass = Kelas::with(['waliKelas', 'tahunPelajaran'])
                    ->where('wali_kelas_id', $guruId)
                    ->get();
        return view('guru-panel.walikelas.nilaispiritual', compact('kelass'));
    }

    public function nilaiSpiritualEdit($kelas)
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($kelas);
        $tapel = $kelas->tahunPelajaran;
        return view('guru-panel.walikelas.nilaispiritual-edit', compact('kelas', 'tapel'));
    }

    public function nilaiSpiritualUpdate(Request $request, $kelas)
    {
        $kelasModel = Kelas::with('tahunPelajaran')->findOrFail($kelas);
        $tapel = $kelasModel->tahunPelajaran;

        if ($tapel && $tapel->is_locked) {
            return back()->with('error',
                '🔒 Nilai untuk tahun pelajaran "' . $tapel->nama . ' - ' . $tapel->semester . '" sedang dikunci oleh Kepala Sekolah.'
            );
        }

        foreach ($request->siswa_id as $i => $siswaId) {
            SikapSiswa::updateOrCreate(
                [
                    'siswa_id'           => $siswaId,
                    'kelas_id'           => $kelas,
                    'tahun_pelajaran_id' => $kelasModel->tahun_pelajaran_id,
                ],
                [
                    'predikat_spiritual'  => $request->predikat[$i] ?? null,
                    'deskripsi_spiritual' => $request->deskripsi[$i] ?? null,
                ]
            );
        }
        return back()->with('success', 'Nilai spiritual berhasil disimpan!');
    }

    public function ketidakhadiranIndex()
    {
        $guruId = $this->getGuruId();
        $kelass = Kelas::with(['waliKelas', 'tahunPelajaran'])
                    ->where('wali_kelas_id', $guruId)
                    ->get();
        return view('guru-panel.walikelas.ketidakhadiran', compact('kelass'));
    }

    public function ketidakhadiranEdit($kelas)
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($kelas);
        $tapel = $kelas->tahunPelajaran;
        $ketidakhadiranData = Kehadiran::where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)
                        ->whereIn('siswa_id', $kelas->siswas->pluck('id'))
                        ->get()
                        ->keyBy('siswa_id');
        return view('guru-panel.walikelas.ketidakhadiran-edit', compact('kelas', 'ketidakhadiranData', 'tapel'));
    }

    public function ketidakhadiranUpdate(Request $request, $kelas)
    {
        $kelasModel = Kelas::with(['tahunPelajaran', 'siswas'])->findOrFail($kelas);
        $tapel = $kelasModel->tahunPelajaran;

        if ($tapel && $tapel->is_locked) {
            return back()->with('error',
                '🔒 Data untuk tahun pelajaran "' . $tapel->nama . ' - ' . $tapel->semester . '" sedang dikunci oleh Kepala Sekolah.'
            );
        }

        foreach ($request->siswa_id as $i => $siswaId) {
            Kehadiran::updateOrCreate(
                [
                    'siswa_id'           => $siswaId,
                    'tahun_pelajaran_id' => $kelasModel->tahun_pelajaran_id,
                ],
                [
                    'sakit'            => $request->sakit[$i] ?? 0,
                    'izin'             => $request->izin[$i] ?? 0,
                    'tanpa_keterangan' => $request->tanpa_keterangan[$i] ?? 0,
                ]
            );
        }
        return redirect()->route('guru.walikelas.ketidakhadiran.edit', $kelas)
            ->with('success', 'Data ketidakhadiran berhasil disimpan!');
    }

    public function catatanIndex()
    {
        $guruId = $this->getGuruId();
        $kelass = Kelas::with(['waliKelas', 'tahunPelajaran'])
                    ->where('wali_kelas_id', $guruId)
                    ->get();
        return view('guru-panel.walikelas.catatan', compact('kelass'));
    }

    public function catatanEdit($kelas)
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($kelas);
        return view('guru-panel.walikelas.catatan-edit', compact('kelas'));
    }

    public function catatanUpdate($kelas)
    {
        $kelasModel = Kelas::with('tahunPelajaran')->findOrFail($kelas);
        $tapel = $kelasModel->tahunPelajaran;

        if ($tapel && $tapel->is_locked) {
            return back()->with('error',
                '🔒 Data untuk tahun pelajaran "' . $tapel->nama . ' - ' . $tapel->semester . '" sedang dikunci oleh Kepala Sekolah.'
            );
        }
        return back();
    }

    public function nilaiMapelIndex()
    {
        $guruId = $this->getGuruId();
        $pembelajarans = Pembelajaran::with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruId)
            ->get();
        return view('guru-panel.mapel.nilai', compact('pembelajarans'));
    }

    public function nilaiEkskulIndex()
    {
        return view('guru-panel.ekskul.nilai');
    }

    public function nilaiAkhir()
    {
        $guruId = $this->getGuruId();
        $pembelajarans = Kelas::with(['waliKelas', 'tahunPelajaran'])
            ->where('wali_kelas_id', $guruId)
            ->get();
        return view('guru-panel.nilaiakhir', compact('pembelajarans'));
    }

    public function nilaiAkhirDetail($id)
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($id);
        $pembelajarans = Pembelajaran::with('mataPelajaran')
            ->where('kelas_id', $id)
            ->get();
        $siswas = $kelas->siswas;
        $nilais = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
            ->where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)
            ->get()
            ->groupBy('siswa_id');
        return view('guru-panel.nilaiakhir-detail', compact('kelas', 'pembelajarans', 'siswas', 'nilais'));
    }

    public function raport()
    {
        $guruId = $this->getGuruId();
        $kelass = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])
            ->where('wali_kelas_id', $guruId)
            ->get();
        return view('guru-panel.raport', compact('kelass'));
    }

    public function raportCetak(\App\Models\Siswa $siswa)
    {
        $siswa->load('kelas.tahunPelajaran');
        $tapel = $siswa->kelas->tahunPelajaran;

        $nilais = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel->id)
            ->get();

        $sikap = SikapSiswa::where('siswa_id', $siswa->id)
            ->where('kelas_id', $siswa->kelas_id)
            ->where('tahun_pelajaran_id', $tapel->id)
            ->first();

        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel->id)
            ->first();

        $semuaSiswaKelas = Siswa::where('kelas_id', $siswa->kelas_id)->pluck('id');
        $rataRataSiswa = [];
        foreach ($semuaSiswaKelas as $sid) {
            $avg = Nilai::where('siswa_id', $sid)
                ->where('tahun_pelajaran_id', $tapel->id)
                ->avg('nilai_akhir');
            $rataRataSiswa[$sid] = $avg ?? 0;
        }
        arsort($rataRataSiswa);
        $peringkat  = array_search($siswa->id, array_keys($rataRataSiswa)) + 1;
        $totalSiswa = count($rataRataSiswa);
        $rataRata   = round($nilais->avg('nilai_akhir'), 2);

        return view('guru-panel.raport-cetak', compact(
            'siswa', 'tapel', 'nilais', 'sikap', 'kehadiran',
            'peringkat', 'totalSiswa', 'rataRata'
        ));
    }
}