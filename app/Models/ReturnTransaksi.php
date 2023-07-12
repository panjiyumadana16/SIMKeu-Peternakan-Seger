<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnTransaksi extends Model
{
    use HasFactory;
    protected $table = 'return_transaksies';
    protected $fillable = [
        'transaksi_id', 'detail_transaksies_id', 'jml_return', 'total', 'alasan_return', 'status'
    ];
}
