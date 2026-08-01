<?php

namespace App\Traits;

trait HasImageAttribute
{
    /**
     * Normalize image path/URL to be dynamic with current host.
     * Fixes issues where localhost or old domain IP/URL was hardcoded into database.
     */
    public static function normalizeImageUrl(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // Return untouched if it's external URL without /uploads/ (e.g. YouTube thumbnails)
        if ((str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) && !str_contains($value, 'uploads/')) {
            return $value;
        }

        // Extract relative uploads path if it contains 'uploads/'
        if (str_contains($value, 'uploads/')) {
            $parts = explode('uploads/', $value);
            $relativePath = 'uploads/' . end($parts);
            return asset($relativePath);
        }

        return asset($value);
    }
}
