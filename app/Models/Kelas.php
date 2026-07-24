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
    public function riwayatKelas()   { return $this->hasMany(RiwayatKelas::class); }

    /**
     * Daftar siswa yang SEBENARNYA ada di kelas ini pada tahun ajaran kelas
     * ini (bukan siswa yang kelas_id-nya SAAT INI menunjuk ke sini).
     */
    public function rosterSiswa()
    {
        $siswaIds = RiwayatKelas::where('kelas_id', $this->id)
            ->where('tahun_pelajaran_id', $this->tahun_pelajaran_id)
            ->pluck('siswa_id');
        if ($siswaIds->isNotEmpty()) {
            return Siswa::whereIn('id', $siswaIds)->orderBy('nama')->get();
        }
        return $this->siswas()->orderBy('nama')->get();
    }
}