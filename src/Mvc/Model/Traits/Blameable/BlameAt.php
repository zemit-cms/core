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

namespace PhalconKit\Mvc\Model\Traits\Blameable;

trait BlameAt
{
    public function getDateCallback(string $format, ?int $timestamp = null): \Closure
    {
        return function () use ($format, $timestamp): ?string {
            if (empty($timestamp)) {
                return date($format) ?: null;
            }
            
            return date($format, $timestamp) ?: null;
        };
    }
}
