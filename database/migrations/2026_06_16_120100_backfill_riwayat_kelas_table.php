<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Backfill data lama: kelas_id yang sudah ada di tabel siswas
     * kita anggap berlaku untuk tahun pelajaran yang aktif saat ini.
     * Riwayat untuk tahun pelajaran sebelumnya tidak bisa dipulihkan
     * karena memang belum pernah disimpan sebelum perbaikan ini.
     */
    public function up(): void {
        $tapelAktifId = DB::table('tahun_pelajarans')->where('aktif', true)->value('id');
        if (!$tapelAktifId) {
            return;
        }

        $now = now();
        $siswas = DB::table('siswas')->whereNotNull('kelas_id')->get(['id', 'kelas_id']);

        foreach ($siswas as $siswa) {
            DB::table('riwayat_kelas')->insertOrIgnore([
                'siswa_id'           => $siswa->id,
                'kelas_id'           => $siswa->kelas_id,
                'tahun_pelajaran_id' => $tapelAktifId,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);
        }
    }

    public function down(): void {
        // Sengaja tidak menghapus data riwayat saat rollback demi keamanan data
    }
};