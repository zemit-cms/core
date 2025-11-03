<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support\Helper\Str;

/**
 * Sanitize and convert to UTF-8
 */
class SanitizeUTF8
{
    /**
     * Invokes the function to sanitize a given string by detecting its encoding,
     * converting it to UTF-8, and removing invalid UTF-8 characters.
     *
     * @param string $string The input string to be sanitized.
     * @param string $invalidUtf8Regex A regular expression pattern to identify invalid UTF-8 characters. Default: '[^\\x20-\\x7E\\xA0-\\xFF]'.
     * @return string The sanitized string in UTF-8 encoding, with invalid characters removed.
     */
    public function __invoke(string $string, string $invalidUtf8Regex = '[^\x20-\x7E\xA0-\xFF]'): string
    {
        // Detect encoding; fallback to UTF-8
        $encoding = mb_detect_encoding($string, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true) ?: 'UTF-8';
        
        // Convert safely to UTF-8; mb_convert_encoding can return false
        $string = mb_convert_encoding($string, 'UTF-8', $encoding) ?: '';
        
        // Remove invalid UTF-8 characters
        $sanitized = mb_ereg_replace($invalidUtf8Regex, '', $string);
        
        return $sanitized ?: '';
    }
}
