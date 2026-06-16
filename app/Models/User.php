<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden   = ['password'];
    protected $casts    = ['password' => 'hashed'];

    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isGuru(): bool   { return $this->role === 'guru'; }
    public function isKepsek(): bool { return $this->role === 'kepsek'; }

    public function guru()   { return $this->hasOne(Guru::class); }
    public function kepsek() { return $this->hasOne(Kepsek::class); }
    public function siswa()  { return $this->hasOne(Siswa::class); }
}
