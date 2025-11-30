<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'user_id', 'category_id', 'body',
        'link_postingan', 'featured_image', 'excerpt',
        'status', 'published_at', 'meta_title', 'meta_description', 'views',
    ];

    protected $with = ['user', 'category'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    // ✅ PERBAIKAN LOGIKA PENCARIAN (SCOPE)
    public function scopeFilter(Builder $query, array $filters): void
    {
        // 1. Logika Search (Judul, Body, Penulis, Kategori)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('body', 'like', '%' . $search . '%')
                  // Cari berdasarkan nama Penulis
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  })
                  // Cari berdasarkan nama Kategori
                  ->orWhereHas('category', function($catQuery) use ($search) {
                      $catQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        });

        // 2. Logika Filter Kategori (Dropdown/Link)
        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        });

        // 3. Logika Filter Author (Dropdown/Link)
        $query->when($filters['author'] ?? false, function ($query, $author) {
            $query->whereHas('user', function($q) use ($author) {
                $q->where('username', $author);
            });
        });
    }
}