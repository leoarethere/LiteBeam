<?php

namespace App\Models;

use App\Models\Broadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BroadcastCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color'];

    public function broadcasts()
    {
        return $this->hasMany(Broadcast::class);
    }

    /**
     * Accessor untuk class warna, disamakan dengan Category.php
     */
    protected function colorClasses(): Attribute
    {
        return Attribute::make(
            get: function () {
                $colorName = $this->color ?? 'gray';

                // Disamakan persis dengan logic di Category.php
                $colorMap = [
                    'blue'   => 'bg-blue-100 text-gray-800 dark:bg-blue-700/80 dark:text-gray-800',
                    'pink'   => 'bg-pink-100 text-gray-800 dark:bg-pink-700/80 dark:text-gray-800',
                    'green'  => 'bg-green-100 text-gray-800 dark:bg-green-700/80 dark:text-gray-800',
                    'yellow' => 'bg-yellow-100 text-gray-800 dark:bg-yellow-700/80 dark:text-gray-800',
                    'indigo' => 'bg-indigo-100 text-gray-800 dark:bg-indigo-700/80 dark:text-gray-800',
                    'purple' => 'bg-purple-100 text-gray-800 dark:bg-purple-700/80 dark:text-gray-800',
                    'red'    => 'bg-red-100 text-gray-800 dark:bg-red-700/80 dark:text-gray-800',
                    'gray'   => 'bg-gray-100 text-gray-800 dark:bg-gray-600/80 dark:text-gray-800',
                ];

                return $colorMap[$colorName] ?? $colorMap['gray'];
            }
        );
    }
}