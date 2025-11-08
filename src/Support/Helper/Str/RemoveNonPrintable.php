<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Support\Helper\Str;

/**
 * Remove non-printable characters
 */
class RemoveNonPrintable
{
    public function __invoke(string $string, string $nonPrintableRegex = '[[:cntrl:]' . PHP_EOL . ']', string $replacement = ''): string
    {
        return mb_ereg_replace($nonPrintableRegex, $replacement, $string) ?: '';
    }
}
