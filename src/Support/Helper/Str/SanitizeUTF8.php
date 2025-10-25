<?php

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
     * Invokes the method to process the given string by detecting its encoding,
     * converting it to UTF-8, and removing invalid UTF-8 characters.
     *
     * @param string $string The input string to sanitize.
     * @return string The sanitized string with invalid UTF-8 characters removed.
     */
    public function __invoke(string $string): string
    {
        // Detect encoding; fallback to UTF-8
        $encoding = mb_detect_encoding($string, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true) ?: 'UTF-8';
        
        // Convert safely to UTF-8; mb_convert_encoding can return false
        $string = mb_convert_encoding($string, 'UTF-8', $encoding) ?: '';
        
        // Remove invalid UTF-8 characters
        $sanitized = mb_ereg_replace('[^\x20-\x7E\xA0-\xFF]', '', $string);
        
        return $sanitized ?: '';
    }
}
