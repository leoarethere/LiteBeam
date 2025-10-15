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
    
    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'title', 
        'slug', 
        'author_id',
        'category_id', // Pastikan foreign key untuk kategori juga ada di sini jika diperlukan
        'body'
    ];

    protected $with = ['author', 'category'];

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
                // Diperbarui: Mencari di 'title' dan 'body'
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
}
