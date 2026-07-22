<?php
namespace App\Http\Controllers;

use App\Models\{Kelas, Guru, Siswa, RiwayatKelas, TahunPelajaran, Pembelajaran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KenaikanKelasController extends Controller
{
    // Urutan tingkat dari yang paling rendah ke paling tinggi, sesuai
    // enum asli di database (kolom 'tingkat' berisi angka romawi, bukan
    // angka biasa). Tingkat terakhir dalam daftar ini dianggap tingkat
    // akhir -> siswanya diluluskan, bukan dinaikkan ke kelas baru.
    private array $urutanTingkat = ['VII', 'VIII', 'IX'];

    /**
     * Tampilkan form kenaikan kelas dari sebuah Tahun Pelajaran (sumber)
     * ke Tahun Pelajaran lain (tujuan).
     */
    public function form(TahunPelajaran $tapel)
    {
        $kelasList = Kelas::where('tahun_pelajaran_id', $tapel->id)
            ->withCount(['siswas' => fn ($q) => $q->where('status', 'Aktif')])
            ->orderBy('tingkat')
            ->orderBy('nama')
            ->get()
            ->map(function ($kelas) {
                $tingkatBaru = $this->tingkatSetelah($kelas->tingkat);

                $kelas->tingkat_tujuan = $tingkatBaru;
                // Saran nama kelas baru: ganti kode tingkat lama di awal nama
                // dengan tingkat baru, misal "VII A" -> "VIII A". Admin tetap
                // bisa mengubahnya sendiri di form.
                $kelas->nama_saran = $tingkatBaru
                    ? $this->generateNamaBaru($kelas->nama, $kelas->tingkat, $tingkatBaru)
                    : null;
                return $kelas;
            });

        $tapelTujuanOptions = TahunPelajaran::where('id', '!=', $tapel->id)
            ->orderByDesc('id')
            ->get();

        $gurus = Guru::orderBy('nama')->get();

        return view('admin.tapel.kenaikan', compact('tapel', 'kelasList', 'tapelTujuanOptions', 'gurus'));
    }

    /**
     * Proses kenaikan kelas:
     * - Kelas tingkat VII -> dipindah ke kelas tingkat VIII di tapel tujuan
     * - Kelas tingkat VIII -> dipindah ke kelas tingkat IX di tapel tujuan
     * - Kelas tingkat IX -> siswa diluluskan (status "Lulus", kelas_id dikosongkan)
     */
    public function process(Request $request, TahunPelajaran $tapel)
    {
        $request->validate([
            'tapel_tujuan_id'         => 'required|exists:tahun_pelajarans,id|different:tapel',
            'mapping'                 => 'array',
            'mapping.*.nama'          => 'nullable|string|max:255',
            'mapping.*.wali_kelas_id' => 'nullable|exists:gurus,id',
            'aktifkan_tujuan'         => 'nullable|boolean',
        ]);

        $tapelTujuan = TahunPelajaran::findOrFail($request->tapel_tujuan_id);

        $kelasSumberList = Kelas::where('tahun_pelajaran_id', $tapel->id)->get();

        $ringkasan = ['naik' => 0, 'lulus' => 0, 'kelas_dibuat' => 0];

        DB::transaction(function () use ($request, $kelasSumberList, $tapelTujuan, &$ringkasan) {
            foreach ($kelasSumberList as $kelas) {
                $tingkatBaru = $this->tingkatSetelah($kelas->tingkat);

                if (!$tingkatBaru) {
                    // Tingkat akhir -> luluskan semua siswa aktif di kelas ini
                    $jumlah = Siswa::where('kelas_id', $kelas->id)
                        ->where('status', 'Aktif')
                        ->update(['kelas_id' => null, 'status' => 'Lulus']);

                    $ringkasan['lulus'] += $jumlah;
                    continue;
                }

                $map      = $request->input("mapping.{$kelas->id}", []);
                $namaBaru = trim($map['nama'] ?? '') !== ''
                    ? $map['nama']
                    : $this->generateNamaBaru($kelas->nama, $kelas->tingkat, $tingkatBaru);
                $waliBaru = $map['wali_kelas_id'] ?? $kelas->wali_kelas_id;

                // updateOrCreate supaya aman kalau proses ini di-run ulang
                // (tidak bikin kelas duplikat untuk tapel tujuan yang sama).
                $kelasBaru = Kelas::updateOrCreate(
                    ['nama' => $namaBaru, 'tahun_pelajaran_id' => $tapelTujuan->id],
                    ['tingkat' => $tingkatBaru, 'wali_kelas_id' => $waliBaru]
                );

                if ($kelasBaru->wasRecentlyCreated) {
                    $ringkasan['kelas_dibuat']++;
                }

                $siswaAktif = Siswa::where('kelas_id', $kelas->id)
                    ->where('status', 'Aktif')
                    ->get(['id']);

                Siswa::whereIn('id', $siswaAktif->pluck('id'))
                    ->update(['kelas_id' => $kelasBaru->id]);

                foreach ($siswaAktif as $siswa) {
                    RiwayatKelas::updateOrCreate(
                        ['siswa_id' => $siswa->id, 'tahun_pelajaran_id' => $tapelTujuan->id],
                        ['kelas_id' => $kelasBaru->id]
                    );
                }

                $ringkasan['naik'] += $siswaAktif->count();
            }

            if ($request->boolean('aktifkan_tujuan')) {
                TahunPelajaran::where('aktif', true)->update(['aktif' => false]);
                Pembelajaran::query()->update(['status' => 'Nonaktif']);

                $tapelTujuan->update(['aktif' => true]);
                Pembelajaran::where('tahun_pelajaran_id', $tapelTujuan->id)->update(['status' => 'Aktif']);
            }
        });

        return redirect()->route('tapel.index')->with(
            'success',
            "Kenaikan kelas selesai: {$ringkasan['naik']} siswa naik kelas, {$ringkasan['lulus']} siswa lulus, {$ringkasan['kelas_dibuat']} kelas baru dibuat."
        );
    }

    /**
     * Cari tingkat setelah tingkat saat ini berdasarkan urutan romawi
     * (VII -> VIII -> IX). Null berarti ini tingkat akhir (lulus).
     */
    private function tingkatSetelah(string $tingkatSaatIni): ?string
    {
        $index = array_search($tingkatSaatIni, $this->urutanTingkat, true);

        if ($index === false || $index === count($this->urutanTingkat) - 1) {
            return null;
        }

        return $this->urutanTingkat[$index + 1];
    }

    /**
     * Buat nama kelas baru dengan mengganti kode tingkat lama di depan nama
     * dengan tingkat baru, misal "VII A" -> "VIII A". Kalau nama kelas tidak
     * diawali kode tingkat (penamaan bebas), fallback ke "{tingkat baru}-{nama asal}".
     */
    private function generateNamaBaru(string $namaLama, string $tingkatLama, string $tingkatBaru): string
    {
        if (str_starts_with($namaLama, $tingkatLama)) {
            return $tingkatBaru . substr($namaLama, strlen($tingkatLama));
        }

        return $tingkatBaru . '-' . $namaLama;
    }
}