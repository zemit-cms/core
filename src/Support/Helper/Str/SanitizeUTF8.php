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
    public function __invoke(string $string): string
    {
        // Detect encoding and convert to UTF-8 if necessary
        $encoding = mb_detect_encoding($string, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true) ?: 'UTF-8';
        $string = mb_convert_encoding($string, 'UTF-8', $encoding);
        
        // Remove invalid UTF-8 characters
        return mb_ereg_replace('[^\x20-\x7E\xA0-\xFF]', '', $string) ?: '';
    }
}
