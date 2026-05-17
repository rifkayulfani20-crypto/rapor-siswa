<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model {
    protected $fillable = ['nama','nis','nisn','jenis_kelamin','tempat_lahir','tanggal_lahir',
        'alamat','nama_ayah','nama_ibu','nama_wali','no_hp_ortu','kelas_id','status'];
    protected $casts = ['tanggal_lahir' => 'date'];

    public function kelas()     { return $this->belongsTo(Kelas::class); }
    public function nilais()    { return $this->hasMany(Nilai::class); }
    public function kehadiran() { return $this->hasOne(Kehadiran::class); }
    public function prestasi()  { return $this->hasMany(Prestasi::class); }
    public function catatan()   { return $this->hasOne(CatatanSiswa::class); }
}