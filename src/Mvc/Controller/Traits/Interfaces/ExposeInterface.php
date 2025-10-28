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

namespace Zemit\Mvc\Controller\Traits\Interfaces;

interface ExposeInterface
{
    public function expose(mixed $item, ?array $expose = null): array;
    
    public function listExpose(iterable $items, ?array $listExpose = null): array;
    
    public function exportExpose(iterable $items, ?array $exportExpose = null): array;
}
