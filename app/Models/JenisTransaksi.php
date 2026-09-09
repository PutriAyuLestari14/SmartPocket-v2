<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    protected $table = 'jenis_transaksi';
    protected $primaryKey = 'id_jenis_transaksi';
    
    protected $fillable = [
        'setoran',
        'penarikan',
    ];

    public $timestamps = true;

    public function detailTabungans()
    {
        return $this->hasMany(DetailTabungan::class, 'id_jenis_transaksi', 'id_jenis_transaksi');
    }
}