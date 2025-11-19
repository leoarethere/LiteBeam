<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'title',
        'subtitle',
        'link',
        'button_text',
        'image_path',
        'order',
        'is_active',
    ];

    /**
     * Tipe data asli untuk atribut.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Model events untuk membersihkan cache secara otomatis.
     */
    protected static function booted()
    {
        // Fungsi ini akan berjalan setiap kali banner disimpan (dibuat atau diupdate)
        static::saved(function () {
            // Hapus kunci cache yang benar untuk slider di beranda
            Cache::forget('homepage.slides');
        });
        
        // Fungsi ini akan berjalan setiap kali banner dihapus
        static::deleted(function ($banner) {
            // Hapus kunci cache yang benar
            Cache::forget('homepage.slides');
            
            // Hapus juga file gambar dari storage
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
        });
    }
}