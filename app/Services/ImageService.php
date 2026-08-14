<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ImageService
{
    /**
     * Upload, resize, convert to WebP, and optionally delete old file.
     *
     * Intervention Image v4 API:
     *   - Constructor: new ImageManager(Driver::class)
     *   - Decode: $manager->decodePath($path)
     *   - Encode: $image->encode(new WebpEncoder(quality: 82))
     */
    public static function uploadAndConvert(
        UploadedFile $file,
        string $directory = 'uploads',
        int $width = 1200,
        int $height = 800,
        ?string $oldImagePath = null
    ): string {
        // Delete old image if exists
        static::deleteOldImage($oldImagePath);

        // Ensure target directory exists in public/storage
        $targetDir = public_path('storage/' . trim($directory, '/'));
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true, true);
        }

        // Generate unique webp filename
        $filename = uniqid() . '_' . time() . '.webp';
        $fullPath = $targetDir . '/' . $filename;

        // Initialize Intervention Image v4 with full GD Driver class name
        $manager = new ImageManager(Driver::class);

        // Decode uploaded file via file path
        $image = $manager->decodePath($file->getRealPath());

        // Cover-crop to requested dimensions
        $image->cover($width, $height);

        // Encode as WebP at 82% quality and save
        $encoded = $image->encode(new WebpEncoder(quality: 82));
        $encoded->save($fullPath);

        return 'storage/' . trim($directory, '/') . '/' . $filename;
    }

    /**
     * Upload inline image for TinyMCE editor (proportional resize, WebP conversion).
     */
    public static function uploadEditorImage(UploadedFile $file, string $directory = 'uploads/editor', int $maxWidth = 1200): string
    {
        $targetDir = public_path('storage/' . trim($directory, '/'));
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true, true);
        }

        $filename = 'editor_' . uniqid() . '_' . time() . '.webp';
        $fullPath = $targetDir . '/' . $filename;

        $manager = new ImageManager(Driver::class);
        $image = $manager->decodePath($file->getRealPath());

        // Scale down proportionally if image width exceeds maxWidth
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encode(new WebpEncoder(quality: 85));
        $encoded->save($fullPath);

        return 'storage/' . trim($directory, '/') . '/' . $filename;
    }

    /**
     * Delete image file from public storage if exists.
     */
    public static function deleteOldImage(?string $path = null): bool
    {
        if (!$path) {
            return false;
        }

        // Normalize path
        $cleanPath = ltrim(str_replace('storage/', '', $path), '/');
        $fullPath = public_path('storage/' . $cleanPath);

        if (File::exists($fullPath) && is_file($fullPath)) {
            return File::delete($fullPath);
        }

        return false;
    }
}
