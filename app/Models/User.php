<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden   = ['password'];
    protected $casts    = ['password' => 'hashed'];

    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isGuru(): bool   { return $this->role === 'guru'; }
    public function isKepsek(): bool { return $this->role === 'kepsek'; }  
    public function isSiswa(): bool  { return $this->role === 'siswa'; }  

    public function guru()   { return $this->hasOne(Guru::class); }
    public function siswa()  { return $this->hasOne(Siswa::class); }
    public function kepsek() { return $this->hasOne(Kepsek::class); }  
}