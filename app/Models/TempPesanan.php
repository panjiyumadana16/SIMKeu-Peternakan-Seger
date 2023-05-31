<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPesanan extends Model
{
    use HasFactory;
    protected $table = 'temp_pesanans';
    protected $fillable = [
        'user_id', 'produk_id', 'jumlah', 'subtotal'
    ];
}
