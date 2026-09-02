<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailTabungan extends Model
{
    protected $table = 'detail_tabungan';
    public $timestamps = true; 
    
    protected $fillable = ['no_rek', 'id_petugas', 'id_jenis_transaksi', 'jumlah', 'tanggal_transaksi'];
    
    public function nasabah() {
        return $this->hasOneThrough(
            Nasabah::class,
            RekeningTabungan::class,
            'no_rek', 
            'id_nasabah', 
            'no_rek', 
            'id_nasabah' 
        );
    }
    
    public function jenisTransaksi() {
        return $this->belongsTo(Jenis::class, 'id_jenis_transaksi', 'id_jenis_transaksi');
    }

    public function rekening() {
    return $this->belongsTo(RekeningTabungan::class, 'no_rek', 'no_rek');
}
}