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
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 
        'slug', 
        'author_id',
        'category_id',
        'body'
    ];

    /**
     * ✅ OPTIMIZATION: Eager load relationships by default
     * Mencegah N+1 query problem
     */
    protected $with = ['author', 'category'];

    /**
     * Model events untuk auto-clear cache
     */
    protected static function booted()
    {
        // Clear cache saat post dibuat atau diupdate
        static::saved(function ($post) {
            static::clearHomeCache();
            
            // Clear specific post cache jika ada
            Cache::forget('post.' . $post->slug);
            
            // Log untuk debugging (optional)
            logger()->info('Post saved, cache cleared', [
                'post_id' => $post->id,
                'action' => $post->wasRecentlyCreated ? 'created' : 'updated'
            ]);
        });
        
        // Clear cache saat post dihapus
        static::deleted(function ($post) {
            static::clearHomeCache();
            Cache::forget('post.' . $post->slug);
            
            logger()->info('Post deleted, cache cleared', [
                'post_id' => $post->id
            ]);
        });
    }

    /**
     * Clear all homepage related caches
     */
    protected static function clearHomeCache(): void
    {
        // Clear standard caches
        Cache::forget('homepage.data');
        Cache::forget('homepage.stats');
        
        // Clear tagged caches (jika menggunakan Redis)
        if (config('cache.default') === 'redis') {
            Cache::tags(['homepage', 'posts'])->flush();
        }
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Setiap post dimiliki oleh satu author (User).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Mendefinisikan relasi "belongsTo" ke model Category.
     * Setiap post termasuk dalam satu kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Menerapkan filter pada query berdasarkan request.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        // Filter berdasarkan kata kunci pencarian (search)
        $query->when(
            $filters['search'] ?? false,
            function ($query, $search) {
                return $query->where(function($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                          ->orWhere('body', 'like', '%' . $search . '%');
                });
            }
        );

        // Filter berdasarkan kategori
        $query->when(
            $filters['category'] ?? false,
            fn ($query, $category) =>
                $query->whereHas('category', fn ($query) => $query->where('slug', $category))
        );

        // Filter berdasarkan author
        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
                $query->whereHas('author', fn ($query) => $query->where('username', $author))
        );
    }

    /**
     * ✅ OPTIMIZATION: Scope untuk published posts
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * ✅ OPTIMIZATION: Scope untuk popular posts
     */
    public function scopePopular(Builder $query, int $limit = 10): Builder
    {
        return $query->orderByDesc('views')->limit($limit);
    }

    /**
     * ✅ OPTIMIZATION: Get cached popular posts
     */
    public static function getCachedPopular(int $limit = 10)
    {
        return Cache::remember('posts.popular.' . $limit, 3600, function () use ($limit) {
            return static::with(['author:id,name', 'category:id,name,slug'])
                ->popular($limit)
                ->get();
        });
    }

    /**
     * ✅ OPTIMIZATION: Get cached latest posts
     */
    public static function getCachedLatest(int $limit = 6)
    {
        return Cache::remember('posts.latest.' . $limit, 3600, function () use ($limit) {
            return static::with(['author:id,name', 'category:id,name,slug'])
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    /**
     * ✅ OPTIMIZATION: Get single post with cache
     */
    public static function getCachedBySlug(string $slug)
    {
        return Cache::remember('post.' . $slug, 3600, function () use ($slug) {
            return static::with(['author', 'category'])
                ->where('slug', $slug)
                ->firstOrFail();
        });
    }

    /**
     * Accessor untuk excerpt
     */
    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->body), 150);
    }

    /**
     * Accessor untuk reading time
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->body));
        return ceil($wordCount / 200); // Assuming 200 words per minute
    }
}