<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stoks';
    protected $fillable = [
        'kandang_id', 'kategori_id', 'tgl_diambil', 'jml_stok'
    ];
}
