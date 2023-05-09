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
        'nama_produk', 'kategori_id', 'harga_jual', 'kandang_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }
}
