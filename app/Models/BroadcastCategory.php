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

    protected function colorClasses(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->color) {
                'blue'   => 'bg-blue-100 text-gray-800 dark:bg-blue-900/50 dark:text-gray-800',
                'pink'   => 'bg-pink-100 text-gray-800 dark:bg-pink-900/50 dark:text-gray-800',
                'green'  => 'bg-green-100 text-gray-800 dark:bg-green-900/50 dark:text-gray-800',
                'yellow' => 'bg-yellow-100 text-gray-800 dark:bg-yellow-900/50 dark:text-gray-800',
                'indigo' => 'bg-indigo-100 text-gray-800 dark:bg-indigo-900/50 dark:text-gray-800',
                'purple' => 'bg-purple-100 text-gray-800 dark:bg-purple-900/50 dark:text-gray-800',
                'red'    => 'bg-red-100 text-gray-800 dark:bg-red-900/50 dark:text-gray-800',
                'gray'   => 'bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-800',
                default  => 'bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-800',
            },
        );
    }
}