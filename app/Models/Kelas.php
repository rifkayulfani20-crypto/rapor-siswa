<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model {
    protected $table    = 'kelas';
    protected $fillable = ['nama','tingkat','wali_kelas_id','tahun_pelajaran_id'];

    public function waliKelas()      { return $this->belongsTo(Guru::class, 'wali_kelas_id'); }
    public function tahunPelajaran() { return $this->belongsTo(TahunPelajaran::class); }
    public function siswas()         { return $this->hasMany(Siswa::class); }
    public function pembelajaran()   { return $this->hasMany(Pembelajaran::class); }

    public function riwayatKelas() { return $this->hasMany(RiwayatKelas::class); }

    public function siswaHistoris()
    {
        return $this->belongsToMany(Siswa::class, 'riwayat_kelas', 'kelas_id', 'siswa_id')
            ->withPivot('tahun_pelajaran_id')
            ->withTimestamps();
    }
}