<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoKunjungan extends Model
{
    use HasFactory;

    protected $table = 'info_kunjungans';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'source_link',
        'cover_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}   