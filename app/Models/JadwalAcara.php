<?php

namespace App\Models;

use App\Models\JadwalCategory;
use App\Models\BroadcastCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalAcara extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'start_time',
        'broadcast_category_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_time' => 'datetime:H:i', // Casting otomatis format jam
    ];

    // Eager loading otomatis agar performa query cepat
    protected $with = ['broadcastCategory'];

    public function broadcastCategory(): BelongsTo
    {
        return $this->belongsTo(BroadcastCategory::class, 'broadcast_category_id');
    }

    public function jadwalCategory()
    {
        return $this->belongsTo(JadwalCategory::class, 'jadwal_category_id');
    }
}