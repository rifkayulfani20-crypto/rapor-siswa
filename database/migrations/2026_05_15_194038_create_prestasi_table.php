<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('tahun_pelajaran_id');
            $table->string('jenis');
            $table->string('nama');
            $table->string('tingkat');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('prestasi'); }
};
