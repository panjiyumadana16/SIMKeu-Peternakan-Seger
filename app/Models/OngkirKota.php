<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngkirKota extends Model
{
    use HasFactory;
    protected $table = 'ongkir_kotas';
    protected $fillable = [
        'nama_kota', 'biaya_ongkir'
    ];
}
