<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class DashboardGuruController extends Controller
{
    // Helper: ambil data guru yang sedang login
    private function getGuruId()
    {
        $guru = Guru::where('user_id', auth()->id())->first();
        return $guru->id ?? 0;
    }

    public function index()
    {
        return view('guru-panel.dashboard', [
            'total_siswa'  => Siswa::count(),
            'total_guru'   => \App\Models\User::where('role', 'guru')->count(),
            'total_mapel'  => MataPelajaran::count(),
            'total_kelas'  => Kelas::count(),
            'total_ekskul' => 5,
            'persen'       => 53,
        ]);
    }

    public function profil()       { return view('guru-panel.profil'); }
    public function profilUpdate() { return back(); }

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
        return view('guru-panel.walikelas.nilaisosial-edit', compact('kelas'));
    }

    public function nilaiSosialUpdate($kelas) { return back(); }

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
        return view('guru-panel.walikelas.nilaispiritual-edit', compact('kelas'));
    }

    public function nilaiSpiritualUpdate($kelas) { return back(); }

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
        return view('guru-panel.walikelas.ketidakhadiran-edit', compact('kelas'));
    }

    public function ketidakhadiranUpdate($kelas) { return back(); }

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

    public function catatanUpdate($kelas) { return back(); }

    public function nilaiMapelIndex()  { return view('guru-panel.mapel.nilai'); }
    public function nilaiEkskulIndex() { return view('guru-panel.ekskul.nilai'); }
    public function nilaiAkhir()       { return view('guru-panel.nilaiakhir'); }
    public function raport()           { return view('guru-panel.raport'); }
}