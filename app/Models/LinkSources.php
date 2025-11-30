<?php

namespace App\Models;

use App\Models\TvSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinkSource extends Model
{
    use HasFactory;

    protected $table = 'link_sources';

    protected $fillable = [
        'name',
        'url',
        'is_active',
    ];

    /**
     * Relasi: Satu Link Source bisa dipakai di banyak Jadwal TV
     */
    public function tvSchedules()
    {
        return $this->hasMany(TvSchedule::class);
    }
}