<?php

namespace App\Models;

use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = [
        'title', 'slug', 'user_id', 'news_category_id', 'body',
        'link_berita', 'featured_image', 'excerpt',
        'status', 'published_at', 'meta_title', 'meta_description', 'views',
    ];

    // Eager loading otomatis setiap kali model dipanggil agar lebih ringan
    protected $with = ['user', 'newsCategory'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relasi ke User (Penulis)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori Berita
    // Kita sebut fungsinya 'newsCategory' agar jelas, dan definisikan FK-nya 'news_category_id'
    public function newsCategory(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }
    
    // Fungsi untuk menambah jumlah view
    public function incrementViews()
    {
        $this->increment('views');
    }

    // LOGIKA FILTER & PENCARIAN (Adaptasi dari Post)
    public function scopeFilter(Builder $query, array $filters): void
    {
        // 1. Logika Search (Judul, Body, Penulis, Kategori)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('body', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('newsCategory', function($catQuery) use ($search) { // Perhatikan nama relasi 'newsCategory'
                      $catQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        });

        // 2. Filter Kategori
        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('newsCategory', function($q) use ($category) {
                $q->where('slug', $category);
            });
        });

        // 3. Filter \PharIo\Manifest\Author
        $query->when($filters['author'] ?? false, function ($query, $author) {
            $query->whereHas('user', function($q) use ($author) {
                $q->where('username', $author);
            });
        });
    }
}