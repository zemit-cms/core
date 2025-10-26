<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits\Blameable;

trait BlameAt
{
    public function getDateCallback(string $format, ?int $timestamp = null): \Closure
    {
        return function () use ($format, $timestamp): ?string {
            return (isset($timestamp)? date($format, $timestamp) : date($format)) ?: null;
        };
    }
}
