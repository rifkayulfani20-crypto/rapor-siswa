<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model {
    protected $fillable = [
        'user_id',
        'nama','nis','nisn','jenis_kelamin','tempat_lahir','tanggal_lahir',
        'alamat','nama_ayah','nama_ibu','nama_wali','no_hp_ortu','kelas_id','status'
    ];
    protected $casts = ['tanggal_lahir' => 'date'];

    public function user()      { return $this->belongsTo(User::class); }
    public function kelas()     { return $this->belongsTo(Kelas::class); }
    public function nilais()    { return $this->hasMany(Nilai::class); }
    public function kehadiran() { return $this->hasOne(Kehadiran::class); }

    // Riwayat kelas siswa di setiap tahun pelajaran (tidak ketimpa saat naik kelas)
    public function riwayatKelas() { return $this->hasMany(RiwayatKelas::class); }

    // Ambil kelas siswa pada tahun pelajaran tertentu (bukan kelas saat ini)
    public function kelasPada($tahunPelajaranId) {
        return $this->riwayatKelas()
            ->where('tahun_pelajaran_id', $tahunPelajaranId)
            ->first()?->kelas;
    }
}
