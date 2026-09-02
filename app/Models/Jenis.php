<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis_transaksi';
    protected $primaryKey = 'id_jenis_transaksi';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = ['setoran', 'penarikan'];
}