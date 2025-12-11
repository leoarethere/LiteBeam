<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoKunjunganFaq extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'info_kunjungan_faqs';

    // Daftar kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'question',
        'answer',
        'order',
        'is_active',
    ];

    // Konversi tipe data otomatis
    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];
}