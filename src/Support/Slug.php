<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

use Transliterator;

class Slug
{
    /**
     * Creates a slug to be used for pretty URLs
     */
    public static function generate(string $string, array $replace = [], string $delimiter = '-'): string
    {
        // Save the old locale and set the new locale to UTF-8
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        if (!empty($replace)) {
            $string = str_replace(array_keys($replace), array_values($replace), $string);
        }
        $transliterator = Transliterator::create('Any-Latin; Latin-ASCII');
        $string = $transliterator->transliterate((string)mb_convert_encoding(htmlspecialchars_decode($string), 'UTF-8', 'auto'));
        self::restoreLocale($oldLocale);
        return self::cleanString($string, $delimiter);
    }
    
    /**
     * Revert back to the old locale
     */
    private static function restoreLocale(string $oldLocale): void
    {
        if ((stripos($oldLocale, '=') > 0)) {
            parse_str(str_replace(';', '&', $oldLocale), $locales);
            $oldLocale = array_values($locales);
        }
        setlocale(LC_ALL, $oldLocale);
    }
    
    /**
     * Replace non-letter or non-digits by -
     * Trim trailing -
     */
    public static function cleanString(string $string, string $delimiter): string
    {
        // replace non letter or non digits by -
        $string = preg_replace('#[^\pL\d]+#u', '-', $string);
        
        // Trim trailing -
        $string = trim($string, '-');
        $clean = preg_replace('~[^-\w]+~', '', $string);
        $clean = strtolower($clean);
        $clean = preg_replace('#[\/_|+ -]+#', $delimiter, $clean);
        return trim($clean, $delimiter);
    }
}
