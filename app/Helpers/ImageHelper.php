<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get image URL with fallback to default
     * 
     * @param string|null $path Path from storage
     * @param string $defaultImage Default image name in public/img (without 'img/' prefix)
     * @return string
     */
    public static function image(?string $path, string $defaultImage = 'default-thumbnail.png'): string
    {
        if ($path) {
            return asset('storage/' . ltrim($path, '/'));
        }
        
        return asset('img/' . $defaultImage);
    }
}
