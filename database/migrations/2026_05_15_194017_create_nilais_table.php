<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('mata_pelajaran_id');
            $table->unsignedBigInteger('tahun_pelajaran_id');
            $table->decimal('nilai_pengetahuan', 5, 2)->nullable();
            $table->decimal('nilai_keterampilan', 5, 2)->nullable();
            $table->decimal('nilai_pts', 5, 2)->nullable();
            $table->decimal('nilai_pas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->unique(['siswa_id','mata_pelajaran_id','tahun_pelajaran_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('nilais'); }
};