<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kepsek extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'jenis_kelamin',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}