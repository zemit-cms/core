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
 * Normalize Line Breaks
 */
class NormalizeLineBreaks
{
    public function __invoke(string $string, string $lineBreaksRegex = "/\r\n|\r/", string $replacement = "\n"): string
    {
        return preg_replace($lineBreaksRegex, $replacement, $string) ?? '';
    }
}
