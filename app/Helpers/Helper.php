<?php

use Illuminate\Support\Facades\Route;

use App\Models\Setting;


function getCleanText(?string $value, int $maxLength = 0): string
{
    if (empty($value)) {
        return '';
    }

    // 1. Double-pass decode to catch double-encoded entities (&amp;amp; etc.)
    $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // 2. Strip all HTML tags
    $value = strip_tags($value);

    // 3. Normalize smart/curly quotes and typography
    $value = str_replace(
        ["\u{201C}", "\u{201D}", "\u{2018}", "\u{2019}", "\u{2026}", "\u{2014}", "\u{2013}"],
        ['"',        '"',        "'",         "'",        '...',      '-',        '-'],
        $value
    );

    // 4. Remove zero-width and invisible Unicode characters
    $value = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $value);

    // 5. Remove control characters that break JSON (\x00-\x1F, DEL, non-breaking space)
    $value = preg_replace('/[\x00-\x1F\x7F\xA0]/u', ' ', $value);

    // 6. Normalize all whitespace to single space
    $value = preg_replace('/\s+/', ' ', $value);

    $value = trim($value);

    // 7. Optional: truncate for SEO best practices (description max ~160 chars)
    if ($maxLength > 0 && mb_strlen($value) > $maxLength) {
        $value = mb_substr($value, 0, $maxLength);
        // Cut at last word boundary to avoid mid-word truncation
        $value = preg_replace('/\s+\S+$/', '', $value) . '...';
    }

    return $value;
}

if (!function_exists('get_setting')) {
    function get_setting($key)
    {
        return \App\Models\Setting::get($key);
    }
}



if (!function_exists('get_Seo_Tags')) {
    function get_Seo_Tags($case)
    {
        return [
            'landing_page_seo_info' => [
                'meta_title' => '',
                'meta_description' => '',
                'seo_tags' => '',
            ],
        ][$case] ?? [];
    }
}








