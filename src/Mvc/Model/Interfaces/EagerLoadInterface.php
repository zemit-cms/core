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

use Phalcon\Mvc\ModelInterface;

interface EagerLoadInterface
{
    public static function findWith(array ...$arguments): array;
    
    public static function findFirstWith(array ...$arguments): ?ModelInterface;
    
    public static function with(array ...$arguments): array;
    
    public static function firstWith(array ...$arguments): ?ModelInterface;
    
    public function load(array ...$arguments): ?ModelInterface;
    
    public static function getParametersFromArguments(array &$arguments): mixed;
}
