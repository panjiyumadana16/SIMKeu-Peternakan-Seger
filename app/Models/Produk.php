<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produks';
    protected $fillable = [
        'nama_produk', 'harga_jual', 'stok_id', 'status'
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }
}
