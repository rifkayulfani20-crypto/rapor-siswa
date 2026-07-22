<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, Nilai, TahunPelajaran, SikapSiswa, Kehadiran};
use Illuminate\Http\Request;

class RaportController extends Controller {

    public function index(Request $request) {
        // Sebelumnya hardcode ke TahunPelajaran::aktif() dan menampilkan
        // SEMUA kelas dari semua tahun ajaran tercampur. Sekarang admin bisa
        // pilih tahun ajaran mana yang mau dilihat (default: yang aktif),
        // supaya raport semester lama tetap bisa diakses setelah kenaikan kelas.
        $tapelId = $request->query('tapel_id');
        $tapel = $tapelId
            ? TahunPelajaran::find($tapelId)
            : TahunPelajaran::aktif();

        $tapelOptions = TahunPelajaran::orderByDesc('id')->get();

        $kelas = Kelas::with(['siswas', 'waliKelas', 'tahunPelajaran'])
            ->when($tapel, fn ($q) => $q->where('tahun_pelajaran_id', $tapel->id))
            ->get();

        return view('admin.raport.index', compact('kelas', 'tapel', 'tapelOptions'));
    }

    public function cetak(Request $request, Siswa $siswa) {
        // tapel_id dikirim dari halaman index (link "Cetak" membawa tahun
        // ajaran yang sedang dilihat admin). Kalau tidak ada (akses langsung),
        // fallback ke tapel aktif seperti perilaku lama.
        $tapelId = $request->query('tapel_id');
        $tapel = $tapelId
            ? TahunPelajaran::find($tapelId)
            : TahunPelajaran::aktif();

        $nilais    = Nilai::with('mataPelajaran')
            ->where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->get();
        $sikap     = SikapSiswa::where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->first();
        $kehadiran = Kehadiran::where('siswa_id', $siswa->id)
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->first();
        $prestasi  = collect();
        $catatan   = null;
        return view('admin.raport.cetak', compact('siswa','tapel','nilais','kehadiran','sikap','prestasi','catatan'));
    }
}
