<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Filters;

class Json
{
    public function filter(?string $value = null): ?string
    {
        try {
            $before = json_decode($value);
            $valid = !empty($before);
        } catch (\Exception $e) {
            $valid = false;
        }

        return $valid ? $value : null;
    }
}
