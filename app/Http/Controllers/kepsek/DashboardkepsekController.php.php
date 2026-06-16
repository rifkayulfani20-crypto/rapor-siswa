public function dashboard()
{
    $tapels = TahunPelajaran::latest()->get();

    // Data untuk grafik rata-rata nilai per kelas
    $kelas = Kelas::with(['siswas', 'tahunPelajaran'])->get();

    $grafikKelas = $kelas->map(function ($k) {
        $siswaIds = $k->siswas->pluck('id');
        $nilais   = Nilai::whereIn('siswa_id', $siswaIds)->get();
        return [
            'nama'      => $k->nama,
            'rata_rata' => $nilais->count() ? round($nilais->avg('nilai_akhir'), 1) : 0,
            'lulus'     => $nilais->where('nilai_akhir', '>=', 75)->groupBy('siswa_id')->count(),
            'tidak_lulus' => $nilais->where('nilai_akhir', '<', 75)->groupBy('siswa_id')->count(),
            'total_siswa' => $k->siswas->count(),
        ];
    });

    return view('kepsek.dashboard', compact('tapels', 'grafikKelas'));
}