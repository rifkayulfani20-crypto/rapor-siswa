<?php

namespace App\Console\Commands;

use App\Models\{Kelas, RiwayatKelas, SikapSiswa};
use Illuminate\Console\Command;

class TambalRiwayatDariSikap extends Command
{
    /**
     * php artisan kelas:tambal-riwayat 11            -> preview saja
     * php artisan kelas:tambal-riwayat 11 --apply     -> benar-benar menyimpan
     * php artisan kelas:tambal-riwayat --semua        -> preview semua kelas yang butuh tambalan
     * php artisan kelas:tambal-riwayat --semua --apply
     */
    protected $signature = 'kelas:tambal-riwayat {kelas_id?} {--semua} {--apply}';

    protected $description = 'Menambal baris riwayat_kelas yang hilang menggunakan jejak SikapSiswa (siswa_id+kelas_id+tahun_pelajaran_id) sebagai sumber kebenaran';

    public function handle()
    {
        $apply = $this->option('apply');
        $semua = $this->option('semua');
        $kelasId = $this->argument('kelas_id');

        if (!$semua && !$kelasId) {
            $this->error('Sertakan ID kelas, contoh: php artisan kelas:tambal-riwayat 11');
            $this->line('Atau pakai --semua untuk memproses semua kelas sekaligus.');
            return self::FAILURE;
        }

        $kelasList = $semua
            ? Kelas::all()
            : Kelas::where('id', $kelasId)->get();

        if ($kelasList->isEmpty()) {
            $this->error('Kelas tidak ditemukan.');
            return self::FAILURE;
        }

        $totalDitambal = 0;

        foreach ($kelasList as $kelas) {
            // Ambil siswa_id unik dari SikapSiswa untuk kelas + tahun ajaran ini.
            // SikapSiswa dipilih sebagai sumber karena secara eksplisit menyimpan
            // kombinasi siswa_id + kelas_id + tahun_pelajaran_id, sehingga bisa
            // dipercaya sebagai bukti "siswa ini pernah ada di kelas ini".
            $siswaIds = SikapSiswa::where('kelas_id', $kelas->id)
                ->where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)
                ->distinct()
                ->pluck('siswa_id');

            if ($siswaIds->isEmpty()) {
                continue;
            }

            $sudahAda = RiwayatKelas::where('kelas_id', $kelas->id)
                ->where('tahun_pelajaran_id', $kelas->tahun_pelajaran_id)
                ->pluck('siswa_id');

            $perluDitambah = $siswaIds->diff($sudahAda);

            if ($perluDitambah->isEmpty()) {
                continue;
            }

            $this->line("- {$kelas->nama} ({$kelas->tahunPelajaran->nama} {$kelas->tahunPelajaran->semester}): {$perluDitambah->count()} baris riwayat_kelas akan ditambahkan");

            if ($apply) {
                foreach ($perluDitambah as $siswaId) {
                    RiwayatKelas::updateOrCreate([
                        'siswa_id'           => $siswaId,
                        'kelas_id'           => $kelas->id,
                        'tahun_pelajaran_id' => $kelas->tahun_pelajaran_id,
                    ]);
                }
            }

            $totalDitambal += $perluDitambah->count();
        }

        $this->newLine();
        if ($totalDitambal === 0) {
            $this->info('Tidak ada yang perlu ditambal. Semua sudah sesuai atau memang tidak ada jejak SikapSiswa.');
        } elseif ($apply) {
            $this->info("Selesai. {$totalDitambal} baris riwayat_kelas berhasil ditambahkan.");
        } else {
            $this->info("Preview selesai: {$totalDitambal} baris akan ditambahkan. Jalankan ulang dengan --apply untuk menyimpan.");
        }

        return self::SUCCESS;
    }
}