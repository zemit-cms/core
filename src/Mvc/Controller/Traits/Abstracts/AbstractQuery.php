<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts;

use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Support\Collection;

trait AbstractQuery
{
    abstract public function initializeFind(): void;
    
    abstract public function setFind(?Collection $find): void;
    
    abstract public function getFind(): ?Collection;
    
    abstract public function find(?array $find = null);
    
    abstract public function findWith(?array $with = null, ?array $find = null): array;
    
    abstract public function findFirst(?array $find = null): mixed;
    
    abstract public function findFirstWith(?array $with = null, ?array $find = null): mixed;
    
    abstract public function average(?array $find = null): float|ResultsetInterface;
    
    abstract public function count(?array $find = null): int|ResultsetInterface;
    
    abstract public function sum(?array $find = null): float|ResultsetInterface;
    
    abstract public function maximum(?array $find = null): float|ResultsetInterface;
    
    abstract public function minimum(?array $find = null): float|ResultsetInterface;
    
    abstract protected function getCalculationFind(?array $find = null): array;
    
    abstract public function generateBindKey(string $prefix): string;
}
