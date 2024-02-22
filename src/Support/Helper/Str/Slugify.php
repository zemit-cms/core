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

use Zemit\Support\Slug;

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
