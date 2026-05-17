<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wali_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->unsignedBigInteger('siswa_id');
            $table->enum('sebagai', ['Ayah', 'Ibu', 'Wali']);
            $table->string('pekerjaan')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('wali_siswas'); }
};