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
        'youtube_link', // Kolom database tempat user menaruh link
        'status',
        'is_active',
        'published_at',
    ];

    // Eager load relasi agar query lebih efisien
    protected $with = ['user', 'broadcastCategory'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
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
     * Accessor: youtube_embed_url
     * Dipanggil di blade dengan: $broadcast->youtube_embed_url
     * Mengubah berbagai format link YouTube menjadi link Embed yang valid.
     */
    protected function youtubeEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Ambil value langsung dari kolom 'youtube_link' di database
                $url = $attributes['youtube_link'] ?? null;

                if (!$url) {
                    return null;
                }

                // REGEX: Pola untuk mengambil Video ID (11 karakter) dari berbagai jenis link YouTube
                // Support: 
                // - https://www.youtube.com/watch?v=dQw4w9WgXcQ
                // - https://youtu.be/dQw4w9WgXcQ
                // - https://www.youtube.com/embed/dQw4w9WgXcQ
                $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';

                if (preg_match($pattern, $url, $matches)) {
                    // $matches[1] berisi Video ID (contoh: dQw4w9WgXcQ)
                    return 'https://www.youtube.com/embed/' . $matches[1];
                }

                // Jika format tidak dikenali, kembalikan null agar tampilan fallback ke Poster
                return null; 
            },
        );
    }
}