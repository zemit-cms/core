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

use PhalconKit\Support\Slug;

/**
 * Creates a slug to be used for pretty URLs
 */
class Slugify
{
    public function __invoke(string $string, array $replace = [], string $delimiter = '-'): string
    {
        return Slug::generate($string, $replace, $delimiter);
    }
}
