<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model {
    protected $fillable = ['nama','jenis_kelamin','nip','nuptk','tempat_lahir',
        'tanggal_lahir','no_hp','alamat','user_id'];
    protected $casts = ['tanggal_lahir' => 'date'];

    public function user()          { return $this->belongsTo(User::class); }
    public function kelasWali()     { return $this->hasMany(Kelas::class, 'wali_kelas_id'); }
    public function pembelajaran()  { return $this->hasMany(Pembelajaran::class); }
}