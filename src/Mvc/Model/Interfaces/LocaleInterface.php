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

namespace Zemit\Mvc\Model\Interfaces;

// @todo __isset etc...
interface LocaleInterface
{
    public function _(string $translateKey, array $placeholders = []): string;

    public function __call(string $method, array $arguments): mixed;
    
    public function __set(string $property, mixed $value): void;
    
    public function __get(string $property): mixed;
}
