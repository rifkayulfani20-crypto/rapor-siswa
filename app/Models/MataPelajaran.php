<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model {
    protected $fillable = ['nama','kode','kelompok','kkm','tahun_pelajaran_id', 'guru_id'];

    public function tahunPelajaran() { return $this->belongsTo(TahunPelajaran::class); }
    public function pembelajaran()   { return $this->hasMany(Pembelajaran::class); }
    public function nilais()         { return $this->hasMany(Nilai::class); }
}