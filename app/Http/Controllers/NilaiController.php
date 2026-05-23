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
        $pembelajaran->load(['guru', 'mataPelajaran', 'kelas.siswas']);
        $siswas = $pembelajaran->kelas->siswas()->where('status', 'Aktif')->get();
        $tapel  = TahunPelajaran::aktif();

        $nilais = Nilai::where('mata_pelajaran_id', $pembelajaran->mata_pelajaran_id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()
            ->keyBy('siswa_id');

        return view('admin.nilai.input', compact('pembelajaran', 'siswas', 'tapel', 'nilais'));
    }

    public function simpan(Request $request)
    {
        $tapel = TahunPelajaran::aktif();

        foreach ($request->nilai as $siswaId => $data) {
            $np  = $data['pengetahuan']  ?? 0;
            $nk  = $data['keterampilan'] ?? 0;
            $pts = $data['pts']          ?? 0;
            $pas = $data['pas']          ?? 0;
            $na  = round(($np + $nk + $pts + $pas) / 4, 2);

            Nilai::updateOrCreate(
                [
                    'siswa_id'           => $siswaId,
                    'mata_pelajaran_id'  => $request->mata_pelajaran_id,
                    'tahun_pelajaran_id' => $tapel->id,
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
}