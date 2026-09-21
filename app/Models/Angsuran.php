<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;

    protected $table = 'angsuran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_pinjaman',
        'id_petugas',
        'tanggal_pembayaran',
        'jumlah',
    ];

    // Relasi ke tabel peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_pinjaman', 'id_pinjaman');
    }

    // Relasi ke tabel petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}