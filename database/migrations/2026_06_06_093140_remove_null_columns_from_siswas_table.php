<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn([
                'telepon',
                'agama',
                'jenis_pendaftaran',
                'diterima_pada',
                'anak_ke',
                'pekerjaan_ayah',
                'nama_ibu',
                'pekerjaan_ibu',
                'nama_wali',
                'pekerjaan_wali',
                'foto',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('telepon')->nullable();
            $table->string('agama')->nullable();
            $table->string('jenis_pendaftaran')->nullable();
            $table->date('diterima_pada')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('foto')->nullable();
        });
    }
};