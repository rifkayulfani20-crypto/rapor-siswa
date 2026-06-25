<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KepsekController extends Controller
{
    public function dashboard()
    {
        $tapels      = TahunPelajaran::latest()->get();
        $tapelAktif  = TahunPelajaran::where('aktif', 1)->first();
        $totalKelas  = Kelas::count();
        $totalSiswa  = Siswa::count();

        $kelas = Kelas::with(['siswas', 'tahunPelajaran'])->get();

        $grafikKelas = $kelas->map(function ($k) {
            $siswaIds = $k->siswas->pluck('id');
            $nilais   = Nilai::whereIn('siswa_id', $siswaIds)->get();
            return [
                'nama'        => $k->nama,
                'rata_rata'   => $nilais->count() ? round($nilais->avg('nilai_akhir'), 1) : 0,
                'lulus'       => $nilais->where('nilai_akhir', '>=', 75)->groupBy('siswa_id')->count(),
                'tidak_lulus' => $nilais->where('nilai_akhir', '<', 75)->groupBy('siswa_id')->count(),
                'total_siswa' => $k->siswas->count(),
            ];
        });

        return view('kepsek.dashboard', compact('tapels', 'tapelAktif', 'totalKelas', 'totalSiswa', 'grafikKelas'));
    }

    public function kunciNilai()
    {
        $tapels     = TahunPelajaran::withCount('kelas')->latest()->get();
        $tapelAktif = TahunPelajaran::aktif();

        return view('kepsek.kunci-nilai', compact('tapels', 'tapelAktif'));
    }

    public function nilaiAkhir()
    {
        $tapel = TahunPelajaran::aktif();
        $kelas = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->get();

        return view('kepsek.nilai-akhir', compact('kelas', 'tapel'));
    }

    public function nilaiAkhirDetail($id)
    {
        $kelas  = Kelas::with(['waliKelas', 'tahunPelajaran', 'siswas'])->findOrFail($id);
        $siswas = $kelas->siswas;
        $nilais = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
                        ->get()
                        ->groupBy('siswa_id');

        return view('kepsek.nilai-akhir-detail', compact('kelas', 'siswas', 'nilais'));
    }

    public function lockTapel(TahunPelajaran $tapel)
    {
        $tapel->update(['is_locked' => true]);

        return back()->with('success', '🔒 Nilai tahun pelajaran "' . $tapel->nama . ' ' . $tapel->semester . '" berhasil dikunci. Guru tidak dapat mengedit nilai.');
    }

    public function unlockTapel(TahunPelajaran $tapel)
    {
        $tapel->update(['is_locked' => false]);

        return back()->with('success', '🔓 Nilai tahun pelajaran "' . $tapel->nama . ' ' . $tapel->semester . '" berhasil dibuka. Guru dapat mengedit nilai kembali.');
    }

    public function profil()
    {
        $user   = auth()->user();
        $kepsek = $user->kepsek;

        return view('kepsek.profil', compact('user', 'kepsek'));
    }

    public function profilUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'nip'           => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'password'      => 'nullable|min:6|confirmed',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->kepsek()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama'          => $request->name,
                'nip'           => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp'         => $request->no_hp,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
            ]
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}