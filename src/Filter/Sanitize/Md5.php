<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Filter\Sanitize;

class Md5
{
    public function __invoke(?string $input = null): ?string
    {
        return preg_replace('/[^0-9a-f]/', '', $input);
    }
}
