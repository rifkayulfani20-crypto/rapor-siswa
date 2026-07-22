<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sebelumnya kolom tahun_pelajaran_id di tabel ini pakai onDelete('cascade'),
     * artinya kalau satu baris di tabel `tahun_pelajarans` (misal semester Genap)
     * dihapus, MySQL OTOMATIS ikut menghapus semua baris terkait di sini —
     * termasuk nilai sikap sosial/spiritual yang sudah diinput guru.
     *
     * Diubah jadi 'restrict' supaya database MENOLAK penghapusan tahun pelajaran
     * selama masih ada data anak yang menempel, bukannya diam-diam menghapus semua.
     */
    public function up(): void
    {
        Schema::table('sikap_siswas', function (Blueprint $table) {
            $table->dropForeign(['tahun_pelajaran_id']);
            $table->foreign('tahun_pelajaran_id')
                ->references('id')->on('tahun_pelajarans')
                ->onDelete('restrict');
        });

        Schema::table('riwayat_kelas', function (Blueprint $table) {
            $table->dropForeign(['tahun_pelajaran_id']);
            $table->foreign('tahun_pelajaran_id')
                ->references('id')->on('tahun_pelajarans')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('sikap_siswas', function (Blueprint $table) {
            $table->dropForeign(['tahun_pelajaran_id']);
            $table->foreign('tahun_pelajaran_id')
                ->references('id')->on('tahun_pelajarans')
                ->onDelete('cascade');
        });

        Schema::table('riwayat_kelas', function (Blueprint $table) {
            $table->dropForeign(['tahun_pelajaran_id']);
            $table->foreign('tahun_pelajaran_id')
                ->references('id')->on('tahun_pelajarans')
                ->onDelete('cascade');
        });
    }
};