<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->default('MTs Rekayasa');
            $table->string('npsn')->nullable();
            $table->string('nss')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->string('nip_kepala_sekolah')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sekolahs'); }
};