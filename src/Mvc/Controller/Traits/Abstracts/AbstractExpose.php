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

namespace PhalconKit\Mvc\Controller\Traits\Abstracts;

trait AbstractExpose
{
    abstract public function expose(mixed $item, ?array $expose = null): array;

    abstract public function listExpose(iterable $items, ?array $expose = null): array;

    abstract public function exportExpose(iterable $items, ?array $expose = null): array;
}
