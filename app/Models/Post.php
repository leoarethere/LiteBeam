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
        'title',
        'slug',
        'user_id', 
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
    
    public function scopeFilter(Builder $query, array $filters): void
    {
        // Scope bisa dibiarkan kosong atau dihapus jika logika sudah pindah ke Controller
    }
}