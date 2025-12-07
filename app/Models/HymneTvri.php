<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HymneTvri extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'info',
        'poster',
        'synopsis',
        'link',
    ];
}