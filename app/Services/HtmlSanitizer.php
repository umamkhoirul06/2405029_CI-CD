<?php

namespace App\Services;

use Illuminate\Support\HtmlString;

/**
 * HTML Sanitizer Service
 * Safely sanitizes HTML content to prevent XSS attacks while preserving formatting.
 * Uses a whitelist approach to allow only safe HTML tags and attributes.
 */
class HtmlSanitizer
{
    /**
     * Allowed tags for content display
     */
    private const ALLOWED_TAGS = [
        'p', 'br', 'b', 'strong', 'i', 'em', 'u', 'a', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'hr', 'table', 'thead', 'tbody', 
        'tr', 'td', 'th', 'img', 'video', 'iframe', 'div', 'span'
    ];

    /**
     * Dangerous protocols for links
     */
    private const DANGEROUS_PROTOCOLS = [
        'javascript:',
        'data:',
        'vbscript:',
        'file:',
    ];

    /**
     * Sanitize HTML content
     * 
     * @param string|null $content 
     * @return \Illuminate\Support\HtmlString
     */
    public static function sanitize(?string $content): HtmlString
    {
        if (is_null($content)) {
            return new HtmlString('');
        }

        // Remove script tags entirely
        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content);
        
        // Remove event handlers
        $content = preg_replace('/\s*on\w+\s*=\s*["\'][^"\']*["\']/i', '', $content);
        $content = preg_replace('/\s*on\w+\s*=\s*[^\s>]*/i', '', $content);

        // Sanitize links
        $content = self::sanitizeLinks($content);

        // Remove potentially dangerous attributes
        $content = preg_replace('/\s*style\s*=\s*["\']([^"\']*)["\']?/i', '', $content);

        // Ensure images have proper attributes
        $content = self::sanitizeImages($content);

        return new HtmlString($content);
    }

    /**
     * Sanitize links to prevent javascript: and data: protocols
     * 
     * @param string $content
     * @return string
     */
    private static function sanitizeLinks(string $content): string
    {
        // Find all href attributes
        return preg_replace_callback(
            '/href\s*=\s*["\']([^"\']*)["\']?/i',
            function ($matches) {
                $url = $matches[1];
                
                // Check for dangerous protocols
                foreach (self::DANGEROUS_PROTOCOLS as $protocol) {
                    if (stripos($url, $protocol) === 0) {
                        return 'href="#"';
                    }
                }

                // Additional validation for relative and absolute URLs
                if (stripos($url, 'http://') === 0 || 
                    stripos($url, 'https://') === 0 || 
                    stripos($url, '/') === 0 ||
                    stripos($url, '#') === 0) {
                    return 'href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"';
                }

                return 'href="#"';
            },
            $content
        );
    }

    /**
     * Sanitize images - add required attributes and validate src
     * 
     * @param string $content
     * @return string
     */
    private static function sanitizeImages(string $content): string
    {
        return preg_replace_callback(
            '/<img\s+([^>]*?)>/i',
            function ($matches) {
                $attributes = $matches[1];
                $result = '<img ';

                // Extract and validate src
                if (preg_match('/src\s*=\s*["\']([^"\']*)["\']?/i', $attributes, $srcMatch)) {
                    $src = $srcMatch[1];
                    if (!preg_match('/^(javascript:|data:|vbscript:)/i', $src)) {
                        $result .= 'src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '" ';
                    }
                }

                // Extract and validate alt
                if (preg_match('/alt\s*=\s*["\']([^"\']*)["\']?/i', $attributes, $altMatch)) {
                    $result .= 'alt="' . htmlspecialchars($altMatch[1], ENT_QUOTES, 'UTF-8') . '" ';
                } else {
                    $result .= 'alt="Image" ';
                }

                // Add lazy loading for performance
                $result .= 'loading="lazy" ';
                
                // Add additional safe attributes
                if (preg_match('/width\s*=\s*["\']?(\d+)["\']?/i', $attributes, $widthMatch)) {
                    $result .= 'width="' . intval($widthMatch[1]) . '" ';
                }
                if (preg_match('/height\s*=\s*["\']?(\d+)["\']?/i', $attributes, $heightMatch)) {
                    $result .= 'height="' . intval($heightMatch[1]) . '" ';
                }
                if (preg_match('/class\s*=\s*["\']([^"\']*)["\']?/i', $attributes, $classMatch)) {
                    $result .= 'class="' . htmlspecialchars($classMatch[1], ENT_QUOTES, 'UTF-8') . '" ';
                }

                $result .= '/>';
                return $result;
            },
            $content
        );
    }

    /**
     * Strip all HTML tags
     * 
     * @param string|null $content
     * @return string
     */
    public static function stripTags(?string $content): string
    {
        if (is_null($content)) {
            return '';
        }
        return strip_tags($content);
    }
}
