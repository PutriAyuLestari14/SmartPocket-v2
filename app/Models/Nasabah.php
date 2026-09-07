<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'nasabah';
    protected $primaryKey = 'id_nasabah';
    
    protected $fillable = [
        'username',
        'nama',
        'kategori', 
        'alamat',
        'tanggal_daftar',
        'status',
        'photo',
        'kategori', 
    ];

    public function user() {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function rekening() {
        return $this->hasOne(RekeningTabungan::class, 'id_nasabah', 'id_nasabah');
    }
}