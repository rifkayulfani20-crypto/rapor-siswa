<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('catatan_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('tahun_pelajaran_id');
            $table->text('catatan_wali_kelas')->nullable();
            $table->text('catatan_kepala_sekolah')->nullable();
            $table->timestamps();
            $table->unique(['siswa_id','tahun_pelajaran_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('catatan_siswa'); }
};