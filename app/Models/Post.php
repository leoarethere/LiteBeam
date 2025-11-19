<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     * Diperbarui untuk mencakup semua kolom dari migrasi baru.
     */
    protected $fillable = [
        'title',
        'slug',
        'user_id', // Diubah dari author_id
        'category_id',
        'body',
        'link_postingan',
        'featured_image',
        'excerpt',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'views',
    ];

    /**
     * Eager load relationships by default untuk mencegah N+1 query.
     */
    protected $with = ['user', 'category']; // Diubah dari 'author'

    /**
     * Casts atribut ke tipe data native.
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi "belongsTo" ke model User.
     * Setiap post dimiliki oleh satu user.
     */
    public function user(): BelongsTo // Diubah dari author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi "belongsTo" ke model Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Menerapkan filter pada query berdasarkan request.
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['category'] ?? false, fn ($query, $category) =>
            $query->whereHas('category', fn ($query) => $query->where('slug', $category))
        );

        // Diubah dari 'author' ke 'user'
        $query->when($filters['author'] ?? false, fn ($query, $author) =>
            $query->whereHas('user', fn ($query) => $query->where('username', $author))
        );
    }

    // Metode lain seperti booted(), scopePublished(), caching, dan accessor
    // dapat tetap sama karena sudah ditulis dengan baik.
    // ... (sisa kode model Anda)
}
