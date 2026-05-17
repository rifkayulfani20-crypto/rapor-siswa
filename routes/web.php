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

    // Admin only
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

        // Raport
        Route::get('/admin/raport', [RaportController::class, 'index'])->name('raport.index');
        Route::get('/admin/raport/cetak/{siswa}', [RaportController::class, 'cetak'])->name('raport.cetak');
    });

    // Admin & Guru
    Route::middleware(['role:admin,guru'])->group(function () {
        Route::get('/admin/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/admin/nilaiakhir', [NilaiController::class, 'nilaiAkhir'])->name('nilai.akhir');
        Route::get('/admin/nilai/{pembelajaran}/input', [NilaiController::class, 'input'])->name('nilai.input');
        Route::post('/admin/nilai/simpan', [NilaiController::class, 'simpan'])->name('nilai.simpan');
    });
});