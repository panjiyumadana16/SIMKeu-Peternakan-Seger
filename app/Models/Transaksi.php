<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksies';
    protected $fillable = [
        'user_id', 'tgl_transaksi', 'jenis_pengiriman', 'alamat_pengiriman', 'ongkir', 'total', 'status' ,'ongkir_kota_id'
    ];
}
