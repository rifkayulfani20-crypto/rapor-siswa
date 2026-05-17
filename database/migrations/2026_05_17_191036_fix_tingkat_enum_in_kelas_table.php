<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \DB::statement("ALTER TABLE kelas MODIFY tingkat ENUM('VII','VIII','IX','X','XI','XII') NOT NULL");
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE kelas MODIFY tingkat ENUM('7','8','9') NOT NULL");
    }
};