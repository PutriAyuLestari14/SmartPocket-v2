<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    
    protected $fillable = [
        'id_nasabah',
        'judul',
        'pesan',
        'tanggal_kirim',
        'status',
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    // Relasi ke Nasabah
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id_nasabah');
    }
}