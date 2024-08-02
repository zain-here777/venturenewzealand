<?php

namespace App\Helpers;

class Sanitizer
{
    /**
     * @param string|null $text
     * @return string|null
     */
    public static function sanitizeText(?string $text): ?string
    {
        if($text === null) return null;

        // Remove control characters and limit to printable characters
        return preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
    }


    /**
     * Sanitize text by stripping HTML tags and removing extra whitespace.
     *
     * @param string|null $text
     * @return string|null
     */
    public static function sanitizeHtmlToPlainText(?string $text): ?string
    {
        if (!$text) {
            return null;
        }

        // Strip HTML tags
        $plainText = strip_tags($text);

        // Remove \r\n and replace multiple spaces with a single space
        $plainText = preg_replace('/\s+/', ' ', $plainText);

        return trim($plainText);
    }
}
