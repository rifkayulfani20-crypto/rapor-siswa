<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu kolomnya ada atau tidak, supaya migration ini aman
        // dijalankan baik di database lama (yang punya kolom 'gelar')
        // maupun database baru yang dibangun dari nol (yang tidak pernah
        // punya kolom ini, misalnya saat automated testing).
        if (Schema::hasColumn('gurus', 'gelar')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->dropColumn('gelar');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('gurus', 'gelar')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->string('gelar')->nullable();
            });
        }
    }
};