<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model {
    protected $table    = 'kehadiran';
    protected $fillable = ['siswa_id','tahun_pelajaran_id','sakit','izin','tanpa_keterangan'];

    public function siswa()          { return $this->belongsTo(Siswa::class); }
    public function tahunPelajaran() { return $this->belongsTo(TahunPelajaran::class); }
}
