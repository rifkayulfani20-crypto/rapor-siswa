<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Pembelajaran;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $pembelajaran = Pembelajaran::with(['guru', 'mataPelajaran', 'kelas'])
                ->where('status', 'Aktif')
                ->get();
        } else {
            $pembelajaran = Pembelajaran::with(['guru', 'mataPelajaran', 'kelas'])
                ->where('guru_id', $user->guru?->id)
                ->where('status', 'Aktif')
                ->get();
        }

        return view('admin.nilai.index', compact('pembelajaran'));
    }

    public function nilaiAkhir()
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran'])->paginate(10);
        return view('admin.nilai.akhir', compact('kelas'));
    }

    public function input(Pembelajaran $pembelajaran)
    {
        $pembelajaran->load(['guru', 'mataPelajaran', 'kelas.siswas', 'kelas.tahunPelajaran']);

        // ── CEK STATUS PEMBELAJARAN ──────────────────────────────
        if ($pembelajaran->status !== 'Aktif') {
            return back()->with('error',
                '🔒 Pembelajaran "' . ($pembelajaran->mataPelajaran->nama ?? '-') . '" sudah tidak aktif. Anda tidak dapat menginput nilai untuk pembelajaran ini.'
            );
        }

        // ── TAHUN PELAJARAN MILIK KELAS (bukan yang aktif global) ─
        $tapel = $pembelajaran->kelas->tahunPelajaran;

        // ── CEK KUNCI NILAI (dicek dari tahun pelajaran milik kelas) ──
        if ($tapel && $tapel->is_locked) {
            return back()->with('error',
                '🔒 Nilai untuk tahun pelajaran "' . $tapel->nama . ' - ' . $tapel->semester . '" sedang dikunci oleh Kepala Sekolah. Anda tidak dapat mengedit nilai saat ini.'
            );
        }

        $siswas = $pembelajaran->kelas->siswas()->where('status', 'Aktif')->get();

        $nilais = Nilai::where('mata_pelajaran_id', $pembelajaran->mata_pelajaran_id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()
            ->keyBy('siswa_id');

        $view = auth()->user()->role === 'guru' ? 'nilai.input' : 'admin.nilai.input';

        return view($view, compact('pembelajaran', 'siswas', 'tapel', 'nilais'));
    }

    public function simpan(Request $request)
    {
        $pembelajaran = Pembelajaran::with('kelas.tahunPelajaran')->findOrFail($request->pembelajaran_id);

        // ── CEK STATUS PEMBELAJARAN ──────────────────────────────
        if ($pembelajaran->status !== 'Aktif') {
            return back()->with('error',
                '🔒 Pembelajaran ini sudah tidak aktif. Anda tidak dapat menyimpan nilai untuk pembelajaran ini.'
            );
        }

        // ── TAHUN PELAJARAN MILIK KELAS (bukan yang aktif global) ─
        $tapel = $pembelajaran->kelas->tahunPelajaran;

        // ── CEK KUNCI NILAI (dicek dari tahun pelajaran milik kelas) ──
        if ($tapel && $tapel->is_locked) {
            return back()->with('error',
                '🔒 Nilai untuk tahun pelajaran "' . $tapel->nama . ' - ' . $tapel->semester . '" sedang dikunci oleh Kepala Sekolah. Anda tidak dapat menyimpan nilai saat ini.'
            );
        }

        $mataPelajaranId = $pembelajaran->mata_pelajaran_id;

        foreach ($request->nilai as $siswaId => $data) {
            $np  = $data['pengetahuan']  ?? 0;
            $nk  = $data['keterampilan'] ?? 0;
            $pts = $data['pts']          ?? 0;
            $pas = $data['pas']          ?? 0;
            $na = round(($np * 0.25) + ($nk * 0.25) + ($pts * 0.25) + ($pas * 0.25), 2);

            Nilai::updateOrCreate(
                [
                    'siswa_id'           => $siswaId,
                    'mata_pelajaran_id'  => $mataPelajaranId,
                    'tahun_pelajaran_id' => $tapel?->id,
                ],
                [
                    'nilai_pengetahuan'  => $np,
                    'nilai_keterampilan' => $nk,
                    'nilai_pts'          => $pts,
                    'nilai_pas'          => $pas,
                    'nilai_akhir'        => $na,
                    'deskripsi'          => $data['deskripsi'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    public function nilaiAkhirDetail($id)
    {
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($id);
        $pembelajarans = Pembelajaran::with('mataPelajaran')
            ->where('kelas_id', $id)
            ->get();
        $siswas = $kelas->siswas()->where('status', 'Aktif')->get();
        $nilais = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
            ->where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)
            ->get()
            ->groupBy('siswa_id');
        return view('admin.nilai.akhir-detail', compact('kelas', 'pembelajarans', 'siswas', 'nilais'));
    }
}