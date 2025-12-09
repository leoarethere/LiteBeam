<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_medias';

    protected $fillable = [
        'email',
        'phone', // Pastikan kolom ini ada di database (migration)
        'instagram',
        'twitter',
        'facebook',
        'tiktok',
        'youtube',
    ];
}