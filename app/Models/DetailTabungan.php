<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTabungan extends Model
{
    protected $table = 'detail_tabungan';
    
    protected $fillable = [
        'no_rek',
        'id_petugas',
        'id_jenis_transaksi',
        'jumlah',
        'status',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function rekening()
    {
        return $this->belongsTo(RekeningTabungan::class, 'no_rek', 'no_rek');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    public function jenisTransaksi()
{
    return $this->belongsTo(JenisTransaksi::class, 'id_jenis_transaksi', 'id_jenis_transaksi');
}
}