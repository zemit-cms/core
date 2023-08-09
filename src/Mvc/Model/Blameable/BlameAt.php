<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Blameable;

trait BlameAt
{
    public function getDateCallback(string $format, ...$args): \Closure
    {
        return function () use ($format, $args) {
            return date($format, ...$args);
        };
    }
}
