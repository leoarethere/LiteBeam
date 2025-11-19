<?php

namespace App\Models;

use App\Models\User;
use App\Models\BroadcastCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Broadcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'broadcast_category_id',
        'title',
        'slug',
        'synopsis',
        'poster',
        'youtube_link',
        'status',
        'published_at',
    ];

    protected $with = ['user', 'broadcastCategory'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function broadcastCategory(): BelongsTo
    {
        return $this->belongsTo(BroadcastCategory::class, 'broadcast_category_id');
    }

    /**
     * Accessor untuk mengubah link YouTube biasa menjadi link embed.
     */
    protected function youtubeEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $url = $this->youtube_link;
                if (!$url) {
                    return null;
                }

                $videoId = null;
                // Cek jika formatnya 'watch?v='
                if (str_contains($url, 'watch?v=')) {
                    // ▼▼▼ [PERBAIKAN] Tambahkan '\' di depan PHP_URL_QUERY ▼▼▼
                    parse_str(parse_url($url, \PHP_URL_QUERY), $query);
                    $videoId = $query['v'] ?? null;
                } 
                // Cek jika formatnya 'youtu.be/'
                elseif (str_contains($url, 'youtu.be/')) {
                    // ▼▼▼ [PERBAIKAN] Tambahkan '\' di depan PHP_URL_PATH ▼▼▼
                    $videoId = ltrim(parse_url($url, \PHP_URL_PATH), '/');
                }

                if ($videoId) {
                    // Hapus parameter tambahan (seperti &list=... atau &t=...)
                    $videoId = explode('&', $videoId)[0]; 
                    return 'https://www.youtube.com/embed/' . $videoId;
                }
                
                return null; // Kembalikan null jika URL tidak valid
            },
        );
    }
}