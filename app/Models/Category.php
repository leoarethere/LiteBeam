<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    /**
     * Mendefinisikan relasi "hasMany" ke model Post.
     * Satu Kategori memiliki banyak Postingan.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * Accessor untuk 'color_classes' dengan kontras tinggi di mode gelap.
     * Background lebih solid dan text lebih terang untuk keterbacaan maksimal.
     */
    protected function colorClasses(): Attribute
    {
        return Attribute::make(
            get: function () {
                $colorName = $this->color ?? 'gray';

                // Peta warna dengan kontras MAKSIMAL untuk Dark Mode
                // Light Mode: bg-100 text-800 (standar)
                // Dark Mode: bg-700/80 text-50/200 (lebih solid dan terang)
                $colorMap = [
                    'blue'   => 'bg-blue-100 text-blue-800 dark:bg-blue-700/80 dark:text-blue-200',
                    'pink'   => 'bg-pink-100 text-pink-800 dark:bg-pink-700/80 dark:text-pink-200',
                    'green'  => 'bg-green-100 text-green-800 dark:bg-green-700/80 dark:text-green-200',
                    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700/80 dark:text-yellow-100',
                    'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-700/80 dark:text-indigo-200',
                    'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-700/80 dark:text-purple-200',
                    'red'    => 'bg-red-100 text-red-800 dark:bg-red-100 dark:text-red-800',
                    'gray'   => 'bg-gray-100 text-gray-800 dark:bg-gray-600/80 dark:text-gray-100',
                ];

                return $colorMap[$colorName] ?? $colorMap['gray'];
            }
        );
    }
}