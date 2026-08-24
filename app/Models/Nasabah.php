<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';
    protected $primaryKey = 'id_nasabah';

    protected $fillable = [
        'id_user', 'nama', 'password', 'alamat', 'tanggal_daftar', 'status', 'photo',
    ];

    public function rekening()
    {
        return $this->hasOne(RekeningTabungan::class, 'id_nasabah', 'id_nasabah');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}