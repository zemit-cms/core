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

namespace Zemit\Filter\Sanitize;

class Json
{
    public function __invoke(?string $input = null): ?string
    {
        if (is_null($input)) {
            return $input;
        }

        return json_validate($input) ? $input : null;
    }
}
