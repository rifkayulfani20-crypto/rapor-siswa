<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model {
    protected $table    = 'pembelajaran';
    protected $fillable = ['guru_id','mata_pelajaran_id','kelas_id','tahun_pelajaran_id','status'];

    public function guru()           { return $this->belongsTo(Guru::class); }
    public function mataPelajaran()  { return $this->belongsTo(MataPelajaran::class); }
    public function kelas()          { return $this->belongsTo(Kelas::class); }
    public function tahunPelajaran() { return $this->belongsTo(TahunPelajaran::class); }
}