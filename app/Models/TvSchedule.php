<?php

namespace App\Models;

use App\Models\LinkSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TvSchedule extends Model
{
    use HasFactory;

    protected $table = 'tv_schedules';

    protected $fillable = [
        'day',
        'time',
        'program_name',
        'link_source_id',
        'is_active',
    ];

    /**
     * Relasi: Setiap Jadwal milik satu Link Source (Opsional)
     */
    public function linkSource()
    {
        return $this->belongsTo(LinkSource::class, 'link_source_id');
    }
}