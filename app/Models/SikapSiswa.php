<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SikapSiswa extends Model
{
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_pelajaran_id',
        'predikat_sosial',
        'deskripsi_sosial',
        'predikat_spiritual',
        'deskripsi_spiritual',
    ];
}