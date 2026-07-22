<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            // MySQL enum perlu di-ALTER langsung supaya value 'Lulus' diterima.
            DB::statement("ALTER TABLE siswas MODIFY status ENUM('Aktif','Nonaktif','Lulus') NOT NULL DEFAULT 'Aktif'");
        }
        // SQLite: Laravel tidak menegakkan CHECK constraint dari enum() dengan ketat
        // pada semua versi, dan merekonstruksi tabel di sini berisiko merusak kolom
        // lain. Project ini berjalan di MySQL (lihat .env), jadi cabang sqlite
        // sengaja dibiarkan no-op. Kalau nanti butuh dukungan sqlite penuh, buat
        // ulang tabel siswas dari migration aslinya dengan enum yang sudah termasuk 'Lulus'.
    }

    public function down(): void
    {
        // Sengaja tidak di-revert otomatis: siswa berstatus 'Lulus' bisa hilang datanya
        // kalau enum dipaksa balik ke 2 pilihan saja. Kalau perlu rollback, tangani manual.
    }
};