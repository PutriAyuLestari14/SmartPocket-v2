<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'username',
        'nama_lengkap',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}