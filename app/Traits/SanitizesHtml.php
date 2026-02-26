<?php

namespace App\Traits;

use App\Services\HtmlSanitizer;
use Illuminate\Support\HtmlString;

/**
 * Trait for the HTML content attribute sanitization
 * Use this trait in models to automatically sanitize HTML content attributes
 */
trait SanitizesHtml
{
    /**
     * Boot the trait
     */
    public static function bootSanitizesHtml()
    {
        // Sanitize HTML content on model save
        static::saving(function ($model) {
            // Find attributes that contain HTML content 
            // You can modify these attribute names as needed
            $htmlAttributes = ['content', 'body', 'description'];

            foreach ($htmlAttributes as $attribute) {
                if ($model->hasAttribute($attribute) && !empty($model->{$attribute})) {
                    // Get the raw value before sanitization
                    $rawContent = $model->getRawOriginal($attribute) ?? $model->{$attribute};
                    
                    // Only sanitize if it looks like HTML (contains tags)
                    if (stripos($rawContent, '<') !== false) {
                        $sanitizer = new HtmlSanitizer();
                        $model->{$attribute} = $sanitizer->sanitize($rawContent);
                    }
                }
            }
        });
    }

    /**
     * Get sanitized content attribute
     * 
     * @param string $attribute
     * @return \Illuminate\Support\HtmlString
     */
    public function getSanitizedContent(string $attribute = 'content'): HtmlString
    {
        if (!$this->hasAttribute($attribute)) {
            return new HtmlString('');
        }

        $content = $this->{$attribute};
        return HtmlSanitizer::sanitize($content);
    }
}
