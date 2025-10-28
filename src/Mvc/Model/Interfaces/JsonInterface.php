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

interface JsonInterface
{
    public function jsonEncode(mixed $value, int $flags = JSON_UNESCAPED_SLASHES, int $depth = 512): string|false;
    
    public function jsonDecode(string $json, ?bool $associative = null, int $depth = 512, int $flags = 0): mixed;
}
