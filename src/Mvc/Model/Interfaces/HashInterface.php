<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Mvc\Model\Interfaces;

interface HashInterface
{
    public function hash(string $string, ?string $salt = null, ?string $workFactor = null): string;

    public function checkHash(?string $hash = null, ?string $string = null, int $maxPassLength = 0): bool;
}
