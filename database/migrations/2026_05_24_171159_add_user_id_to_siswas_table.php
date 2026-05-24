<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {

            // Tambah alamat jika belum ada
            if (!Schema::hasColumn('siswas', 'alamat')) {
                $table->text('alamat')
                      ->nullable()
                      ->after('jenis_kelamin');
            }

            // Tambah telepon jika belum ada
            if (!Schema::hasColumn('siswas', 'telepon')) {
                $table->string('telepon')
                      ->nullable()
                      ->after('alamat');
            }

            // Tambah status jika belum ada
            if (!Schema::hasColumn('siswas', 'status')) {
                $table->enum('status', ['AKTIF', 'NONAKTIF'])
                      ->default('AKTIF')
                      ->after('telepon');
            }

            // Tambah foto jika belum ada
            if (!Schema::hasColumn('siswas', 'foto')) {
                $table->string('foto')
                      ->nullable()
                      ->after('status');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {

            // Hapus kolom jika ada
            $columns = [];

            if (Schema::hasColumn('siswas', 'alamat')) {
                $columns[] = 'alamat';
            }

            if (Schema::hasColumn('siswas', 'telepon')) {
                $columns[] = 'telepon';
            }

            if (Schema::hasColumn('siswas', 'status')) {
                $columns[] = 'status';
            }

            if (Schema::hasColumn('siswas', 'foto')) {
                $columns[] = 'foto';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }

        });
    }
};