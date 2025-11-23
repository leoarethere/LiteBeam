<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisiMisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'content',
        'image', // [BARU] Tambahkan ini
        'order',
        'is_active',
    ];
}