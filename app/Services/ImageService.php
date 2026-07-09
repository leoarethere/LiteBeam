<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * Processes, compresses and stores an image.
     *
     * @param  UploadedFile  $file  The uploaded image file.
     * @param  string  $folder  The storage folder (e.g., 'post-images').
     * @return string|null The path to the stored image.
     *
     * @throws \Exception
     */
    public function processAndStore(UploadedFile $file, string $folder): ?string
    {
        try {
            $filename = Str::random(40).'.jpg';
            $path = $folder.'/'.$filename;

            $manager = new ImageManager(new Driver);
            $image = $manager->read($file);

            // Resize if too large (max width 1200px)
            $image->scale(width: 1200);

            // Encode to JPEG with 70% quality
            $encodedImage = $image->toJpeg(quality: 70);

            Storage::disk('public')->put($path, (string) $encodedImage);

            return $path;
        } catch (\Exception $e) {
            Log::error("Image processing error in folder {$folder}: ".$e->getMessage());
            throw $e;
        }
    }

    /**
     * Deletes an image from public storage.
     *
     * @param  string|null  $path  The path to the image.
     */
    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
