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

class IPv6
{
    public function __invoke(?string $input = null): ?string
    {
        return filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ?: null;
    }
}
