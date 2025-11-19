<?php

namespace App\Models;

use App\Models\Broadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Penting untuk color_classes

class BroadcastCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color'];

    /**
     * Relasi ke model Broadcast (satu kategori punya banyak broadcast)
     */
    public function broadcasts()
    {
        return $this->hasMany(Broadcast::class);
    }

    protected function colorClasses(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->color) {
                'blue'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400',
                'pink'   => 'bg-pink-100 text-pink-800 dark:bg-pink-900/50 dark:text-pink-400',
                'green'  => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400',
                'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-400',
                'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-400',
                'red'    => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400',
                'gray'   => 'bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-300',
                default  => 'bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-300',
            },
        );
    }
}