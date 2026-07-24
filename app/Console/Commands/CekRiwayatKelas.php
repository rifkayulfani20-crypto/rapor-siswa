<?php

namespace App\Console\Commands;

use App\Models\{Kelas, RiwayatKelas, SikapSiswa, Kehadiran, Nilai, Siswa};
use Illuminate\Console\Command;

class CekRiwayatKelas extends Command
{
    protected $signature = 'kelas:cek-riwayat {kelas_id}';
    protected $description = 'Cek jejak historis siswa untuk sebuah kelas (riwayat_kelas, sikap, kehadiran) sebelum memutuskan cara memperbaiki data yang tampak kosong';

    public function handle()
    {
        $kelasId = $this->argument('kelas_id');
        $kelas = Kelas::with('tahunPelajaran')->find($kelasId);

        if (!$kelas) {
            $this->error("Kelas dengan ID {$kelasId} tidak ditemukan.");
            return self::FAILURE;
        }

        $this->info("Kelas: {$kelas->nama} — {$kelas->tahunPelajaran->nama} {$kelas->tahunPelajaran->semester}");
        $this->newLine();

        $riwayatCount = RiwayatKelas::where('kelas_id', $kelasId)
            ->where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)
            ->count();
        $this->line("1. Baris di riwayat_kelas untuk kelas ini : {$riwayatCount}");

        $liveCount = Siswa::where('kelas_id', $kelasId)->count();
        $this->line("2. Siswa yang SAAT INI kelas_id-nya = kelas ini : {$liveCount}");

        $sikapCount = SikapSiswa::where('kelas_id', $kelasId)
            ->where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)
            ->count();
        $this->line("3. Baris nilai sikap (SikapSiswa) tercatat untuk kelas ini : {$sikapCount}");

        $nilaiCount = Nilai::where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)->count();
        $this->line("4. Total baris Nilai di tahun ajaran yang sama (semua kelas) : {$nilaiCount}");

        $this->newLine();

        if ($riwayatCount === 0 && $liveCount === 0 && $sikapCount === 0) {
            $this->warn("KESIMPULAN: Tidak ada jejak sama sekali untuk kelas ini di tabel manapun.");
            $this->warn("Kemungkinan besar kelas ini memang belum pernah diisi siswa sungguhan,");
            $this->warn("atau datanya dibuat sebelum fitur riwayat_kelas ada dan tidak bisa direkonstruksi otomatis.");
        } else {
            $this->info("KESIMPULAN: Ada jejak data yang bisa dipakai untuk menambal riwayat_kelas kelas ini.");
        }

        return self::SUCCESS;
    }
}