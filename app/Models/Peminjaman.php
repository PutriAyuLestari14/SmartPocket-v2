<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjaman';

    protected $fillable = [
        'id_nasabah',
        'id_petugas',
        'tanggal_ajuan',
        'tanggal_jatuh_tempo',
        'jumlah_pinjaman',
        'tenor',
        'sisa_pinjaman',
        'total_jasa',
        'jasa_per_bulan',
        'sisa_jasa',
        'keterangan',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_ajuan' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id_nasabah');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    // TAMBAHKAN METHOD INI
    public function angsurans()
    {
        return $this->hasMany(Angsuran::class, 'id_pinjaman', 'id_pinjaman');
    }
}