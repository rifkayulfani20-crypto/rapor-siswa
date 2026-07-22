<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Perintah ALTER TABLE ... MODIFY ini sintaks khusus MySQL.
        // SQLite (dipakai saat automated testing) tidak mengenal ENUM,
        // jadi perintah ini di-skip kalau bukan MySQL.
        if (\DB::connection()->getDriverName() === 'mysql') {
            \DB::statement("ALTER TABLE kelas MODIFY tingkat ENUM('VII','VIII','IX','X','XI','XII') NOT NULL");
        }
    }

    public function down(): void
    {
        if (\DB::connection()->getDriverName() === 'mysql') {
            \DB::statement("ALTER TABLE kelas MODIFY tingkat ENUM('7','8','9') NOT NULL");
        }
    }
};