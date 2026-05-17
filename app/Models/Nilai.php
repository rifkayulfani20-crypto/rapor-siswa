<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model {
    protected $fillable = ['siswa_id','mata_pelajaran_id','tahun_pelajaran_id',
        'nilai_pengetahuan','nilai_keterampilan','nilai_pts','nilai_pas','nilai_akhir','deskripsi'];

    public function siswa()          { return $this->belongsTo(Siswa::class); }
    public function mataPelajaran()  { return $this->belongsTo(MataPelajaran::class); }
    public function tahunPelajaran() { return $this->belongsTo(TahunPelajaran::class); }

    public function hitungNilaiAkhir(): float {
        return round(
            (($this->nilai_pengetahuan  ?? 0) * 0.25) +
            (($this->nilai_keterampilan ?? 0) * 0.25) +
            (($this->nilai_pts          ?? 0) * 0.25) +
            (($this->nilai_pas          ?? 0) * 0.25),
        2);
    }

    public function getPredikat(): string {
        $na = $this->nilai_akhir ?? 0;
        if ($na >= 90) return 'A';
        if ($na >= 80) return 'B';
        if ($na >= 70) return 'C';
        return 'D';
    }
}
