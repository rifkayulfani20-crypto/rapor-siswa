<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TahunPelajaran extends Model {
    protected $fillable = ['nama','semester','tempat_pembagian','tanggal_pembagian','aktif','is_locked'];
    protected $casts    = ['aktif' => 'boolean', 'is_locked' => 'boolean', 'tanggal_pembagian' => 'date'];

    public static function aktif() { return self::where('aktif', true)->first(); }
    public function kelas()        { return $this->hasMany(Kelas::class); }
    public function mataPelajarans() { return $this->hasMany(MataPelajaran::class); }
}