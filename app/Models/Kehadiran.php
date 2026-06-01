<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';
    
    protected $fillable = [
        'siswa_id',
        'tahun_pelajaran_id',
        'sakit',
        'izin',
        'tanpa_keterangan',
    ];
}