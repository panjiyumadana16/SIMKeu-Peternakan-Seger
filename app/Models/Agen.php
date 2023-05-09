<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agen extends Model
{
    use HasFactory;

    protected $table = 'agens';
    protected $fillable = [
        'user_id', 'nama', 'no_hp', 'kota', 'alamat'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
