<?php

namespace App\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsCategory extends Model
{
    use HasFactory;

    // Kita gunakan guarded kosong agar semua kolom (name, slug) bisa diisi
    protected $guarded = ['id'];

    // Relasi: Satu kategori memiliki banyak berita
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}