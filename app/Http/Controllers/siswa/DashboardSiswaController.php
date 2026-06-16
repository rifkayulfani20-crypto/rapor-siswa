<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardSiswaController extends Controller
{
    private function getSiswa()
    {
        return Siswa::where('user_id', auth()->id())
            ->with(['kelas'])
            ->firstOrFail();
    }

    public function dashboard()
    {
        $siswa = $this->getSiswa();
        $tapel = TahunPelajaran::aktif();

        $jumlahNilai = Nilai::where('siswa_id', $siswa->id)
            ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->count();

        $rataRata = round(Nilai::where('siswa_id', $siswa->id)
            ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->avg('nilai_akhir') ?? 0, 1);

        return view('siswa-panel.dashboard', compact('siswa', 'tapel', 'jumlahNilai', 'rataRata'));
    }

    public function nilai()
    {
        $siswa = $this->getSiswa();
        $tapel = TahunPelajaran::aktif();

        $nilais = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->when($tapel, fn($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->get();

        return view('siswa-panel.nilai', compact('siswa', 'tapel', 'nilais'));
    }

    public function profil()
    {
        $siswa = $this->getSiswa();
        return view('siswa-panel.profil', compact('siswa'));
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('password_error', 'Password lama tidak sesuai!');
        }

        $user->update(['password' => Hash::make($request->password_baru)]);

        return back()->with('password_success', 'Password berhasil diubah!');
    }
}