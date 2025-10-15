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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    
    protected function colorClasses(): Attribute
    {
        return Attribute::make(
            get: function () {
                $colors = [
                    // Mengganti text-blue-900 -> text-gray-800
                    'bg-blue-100 text-gray-800 dark:bg-blue-900 dark:text-blue-300',
                    // Mengganti text-pink-900 -> text-gray-800
                    'bg-pink-100 text-gray-800 dark:bg-pink-900 dark:text-pink-300',
                    // Mengganti text-green-900 -> text-gray-800
                    'bg-green-100 text-gray-800 dark:bg-green-900 dark:text-green-300',
                    // Mengganti text-yellow-900 -> text-gray-800
                    'bg-yellow-100 text-gray-800 dark:bg-yellow-900 dark:text-yellow-300',
                    // Mengganti text-indigo-900 -> text-gray-800
                    'bg-indigo-100 text-gray-800 dark:bg-indigo-900 dark:text-indigo-300',
                    // Mengganti text-purple-900 -> text-gray-800
                    'bg-purple-100 text-gray-800 dark:bg-purple-900 dark:text-purple-300',
                ];

                return $colors[$this->id % count($colors)];
            }
        );
    }
}