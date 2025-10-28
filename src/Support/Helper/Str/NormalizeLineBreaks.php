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
 * Normalize Line Breaks
 */
class NormalizeLineBreaks
{
    /**
     * Replaces line breaks in the given string based on a specified regular expression and replacement string.
     *
     * @param string $string The input string where line breaks will be replaced.
     * @param string $lineBreaksRegex The regular expression pattern to match line breaks. Defaults to "/\r\n|\r/".
     * @param string $replacement The string to replace matched line breaks with. Defaults to "\n".
     *
     * @return string The processed string with line breaks replaced.
     */
    public function __invoke(string $string, string $lineBreaksRegex = "/\r\n|\r/", string $replacement = "\n"): string
    {
        return $lineBreaksRegex === '' ? $string : preg_replace($lineBreaksRegex, $replacement, $string) ?? '';
    }
}
