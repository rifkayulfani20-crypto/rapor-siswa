<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\TahunPelajaranController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Guru\DashboardGuruController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/', fn () => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated
Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/admin/profil', [ProfilController::class, 'update'])->name('profil.update');

    // ==================== ADMIN ONLY ====================
    Route::middleware(['role:admin'])->group(function () {

        // Siswa
        Route::resource('admin/datasiswa', SiswaController::class)
            ->except('show')
            ->parameters(['datasiswa' => 'siswa'])
            ->names([
                'index'   => 'siswa.index',
                'create'  => 'siswa.create',
                'store'   => 'siswa.store',
                'edit'    => 'siswa.edit',
                'update'  => 'siswa.update',
                'destroy' => 'siswa.destroy',
            ]);

        // Guru
        Route::resource('admin/dataguru', GuruController::class)
            ->except('show')
            ->parameters(['dataguru' => 'guru'])
            ->names([
                'index'   => 'guru.index',
                'create'  => 'guru.create',
                'store'   => 'guru.store',
                'edit'    => 'guru.edit',
                'update'  => 'guru.update',
                'destroy' => 'guru.destroy',
            ]);

        // Admin
        Route::resource('admin/dataadmin', AdminController::class)
            ->except('show')
            ->parameters(['dataadmin' => 'user'])
            ->names([
                'index'   => 'admin.index',
                'create'  => 'admin.create',
                'store'   => 'admin.store',
                'edit'    => 'admin.edit',
                'update'  => 'admin.update',
                'destroy' => 'admin.destroy',
            ]);

        // Akun
        Route::get('/admin/dataakun', [AkunController::class, 'index'])->name('admin.akun.index');
        Route::get('/admin/dataakun/{akun}/edit', [AkunController::class, 'edit'])->name('admin.akun.edit');
        Route::put('/admin/dataakun/{akun}', [AkunController::class, 'update'])->name('admin.akun.update');

        // Tapel
        Route::resource('admin/tapel', TahunPelajaranController::class)
            ->except('show')
            ->names([
                'index'   => 'tapel.index',
                'create'  => 'tapel.create',
                'store'   => 'tapel.store',
                'edit'    => 'tapel.edit',
                'update'  => 'tapel.update',
                'destroy' => 'tapel.destroy',
            ]);

        // Kelas
        Route::resource('admin/kelas', KelasController::class)
            ->except('show')
            ->parameters(['kelas' => 'kelas'])
            ->names([
                'index'   => 'kelas.index',
                'create'  => 'kelas.create',
                'store'   => 'kelas.store',
                'edit'    => 'kelas.edit',
                'update'  => 'kelas.update',
                'destroy' => 'kelas.destroy',
            ]);

        // Mapel
        Route::resource('admin/mapel', MapelController::class)
            ->except('show')
            ->names([
                'index'   => 'mapel.index',
                'create'  => 'mapel.create',
                'store'   => 'mapel.store',
                'edit'    => 'mapel.edit',
                'update'  => 'mapel.update',
                'destroy' => 'mapel.destroy',
            ]);

        // Pembelajaran
        Route::resource('admin/pembelajaran', PembelajaranController::class)
            ->except('show')
            ->names([
                'index'   => 'pembelajaran.index',
                'create'  => 'pembelajaran.create',
                'store'   => 'pembelajaran.store',
                'edit'    => 'pembelajaran.edit',
                'update'  => 'pembelajaran.update',
                'destroy' => 'pembelajaran.destroy',
            ]);

        // Raport Admin
        Route::get('/admin/raport', [RaportController::class, 'index'])->name('raport.index');
        Route::get('/admin/raport/cetak/{siswa}', [RaportController::class, 'cetak'])->name('raport.cetak');
    });

    // ==================== ADMIN & GURU ====================
    Route::middleware(['role:admin,guru'])->group(function () {
        Route::get('/admin/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/admin/nilaiakhir', [NilaiController::class, 'nilaiAkhir'])->name('nilai.akhir');
        Route::get('/admin/nilai/{pembelajaran}/input', [NilaiController::class, 'input'])->name('nilai.input');
        Route::post('/admin/nilai/simpan', [NilaiController::class, 'simpan'])->name('nilai.simpan');
    });

    // ==================== GURU ONLY ====================
    Route::middleware(['role:guru'])->prefix('guru')->name('guru.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardGuruController::class, 'index'])->name('dashboard');

        // Profil Guru
        Route::get('/profil', [DashboardGuruController::class, 'profil'])->name('profil');
        Route::put('/profil', [DashboardGuruController::class, 'profilUpdate'])->name('profil.update');

        // Siswa (lihat saja)
        Route::get('/siswa', [DashboardGuruController::class, 'siswaIndex'])->name('siswa.index');

        // Wali Kelas
        Route::get('/datakelas', [DashboardGuruController::class, 'kelasIndex'])->name('walikelas.kelas');
        Route::get('/nilaisosial', [DashboardGuruController::class, 'nilaiSosialIndex'])->name('walikelas.nilaiSosial');
        Route::get('/nilaisosial/{kelas}/edit', [DashboardGuruController::class, 'nilaiSosialEdit'])->name('walikelas.nilaiSosial.edit');
        Route::put('/nilaisosial/{kelas}', [DashboardGuruController::class, 'nilaiSosialUpdate'])->name('walikelas.nilaiSosial.update');

        Route::get('/nilaispiritual', [DashboardGuruController::class, 'nilaiSpiritualIndex'])->name('walikelas.nilaiSpiritual');
        Route::get('/nilaispiritual/{kelas}/edit', [DashboardGuruController::class, 'nilaiSpiritualEdit'])->name('walikelas.nilaiSpiritual.edit');
        Route::put('/nilaispiritual/{kelas}', [DashboardGuruController::class, 'nilaiSpiritualUpdate'])->name('walikelas.nilaiSpiritual.update');

        Route::get('/ketidakhadiran', [DashboardGuruController::class, 'ketidakhadiranIndex'])->name('walikelas.ketidakhadiran');
        Route::get('/ketidakhadiran/{kelas}/edit', [DashboardGuruController::class, 'ketidakhadiranEdit'])->name('walikelas.ketidakhadiran.edit');
        Route::put('/ketidakhadiran/{kelas}', [DashboardGuruController::class, 'ketidakhadiranUpdate'])->name('walikelas.ketidakhadiran.update');

        Route::get('/catatan', [DashboardGuruController::class, 'catatanIndex'])->name('walikelas.catatan');
        Route::get('/catatan/{kelas}/edit', [DashboardGuruController::class, 'catatanEdit'])->name('walikelas.catatan.edit');
        Route::put('/catatan/{kelas}', [DashboardGuruController::class, 'catatanUpdate'])->name('walikelas.catatan.update');

        Route::get('/prestasi', [DashboardGuruController::class, 'prestasiIndex'])->name('walikelas.prestasi');
        Route::get('/prestasi/{kelas}/edit', [DashboardGuruController::class, 'prestasiEdit'])->name('walikelas.prestasi.edit');
        Route::put('/prestasi/{kelas}', [DashboardGuruController::class, 'prestasiUpdate'])->name('walikelas.prestasi.update');

        // Guru Mapel
        Route::get('/nilaipelajaran', [DashboardGuruController::class, 'nilaiMapelIndex'])->name('mapel.nilai');

        // Pembina Ekskul
        Route::get('/nilaieskul', [DashboardGuruController::class, 'nilaiEkskulIndex'])->name('ekskul.nilai');

        // Nilai Akhir & Raport
        Route::get('/nilaiakhir', [DashboardGuruController::class, 'nilaiAkhir'])->name('nilaiakhir');
        Route::get('/raport', [DashboardGuruController::class, 'raport'])->name('raport');
    });
});