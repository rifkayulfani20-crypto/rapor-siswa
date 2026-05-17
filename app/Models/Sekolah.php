<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model {
    protected $fillable = [
        'nama','npsn','nss','kode_pos','telepon','alamat',
        'email','website','kepala_sekolah','nip_kepala_sekolah','logo'
    ];
}