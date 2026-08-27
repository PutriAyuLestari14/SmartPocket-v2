<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'nasabah';
    protected $primaryKey = 'id_nasabah';

    // PASTIKAN 'kategori' ADA DI SINI!
    protected $fillable = [
        'id_user',
        'nama',
        'password',
        'alamat',
        'tanggal_daftar',
        'status',
        'photo',
        'kategori', 
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function rekening() {
        return $this->hasOne(RekeningTabungan::class, 'id_nasabah', 'id_nasabah');
    }
}