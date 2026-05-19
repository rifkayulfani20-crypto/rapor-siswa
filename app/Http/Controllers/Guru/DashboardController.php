<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class DashboardGuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard', [
            'total_siswa'  => Siswa::count(),
            'total_guru'   => \App\Models\User::where('role', 'guru')->count(),
            'total_mapel'  => MataPelajaran::count(),
            'total_kelas'  => Kelas::count(),
            'total_ekskul' => 5,
            'persen'       => 53,
        ]);
    }

    public function profil()           { return view('guru.profil'); }
    public function profilUpdate()     { return back(); }
    public function siswaIndex()       { return view('guru.siswa.index', ['siswas' => Siswa::with('kelas')->get()]); }
    public function kelasIndex()       { return view('guru.walikelas.kelas'); }
    public function nilaiSosialIndex() { return view('guru.walikelas.nilaisosial'); }
    public function nilaiSosialEdit($kelas)   { return view('guru.walikelas.nilaisosial-edit', compact('kelas')); }
    public function nilaiSosialUpdate($kelas) { return back(); }
    public function nilaiSpiritualIndex()     { return view('guru.walikelas.nilaispiritual'); }
    public function nilaiSpiritualEdit($kelas)   { return view('guru.walikelas.nilaispiritual-edit', compact('kelas')); }
    public function nilaiSpiritualUpdate($kelas) { return back(); }
    public function ketidakhadiranIndex()     { return view('guru.walikelas.ketidakhadiran'); }
    public function ketidakhadiranEdit($kelas)   { return view('guru.walikelas.ketidakhadiran-edit', compact('kelas')); }
    public function ketidakhadiranUpdate($kelas) { return back(); }
    public function catatanIndex()     { return view('guru.walikelas.catatan'); }
    public function catatanEdit($kelas)   { return view('guru.walikelas.catatan-edit', compact('kelas')); }
    public function catatanUpdate($kelas) { return back(); }
    public function prestasiIndex()    { return view('guru.walikelas.prestasi'); }
    public function prestasiEdit($kelas)  { return view('guru.walikelas.prestasi-edit', compact('kelas')); }
    public function prestasiUpdate($kelas){ return back(); }
    public function nilaiMapelIndex()  { return view('guru.mapel.nilai'); }
    public function nilaiEkskulIndex() { return view('guru.ekskul.nilai'); }
    public function nilaiAkhir()       { return view('guru.nilaiakhir'); }
    public function raport()           { return view('guru.raport'); }
}