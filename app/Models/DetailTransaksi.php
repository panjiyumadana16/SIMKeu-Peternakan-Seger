<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksies';
    protected $fillable = [
        'transaksi_id', 'produk_id', 'jumlah_produk', 'sub_total_harga'
    ];
}
