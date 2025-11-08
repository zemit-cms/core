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

namespace PhalconKit\Mvc\Controller\Traits\Abstracts\Query;

use Phalcon\Support\Collection;

trait AbstractCache
{
    abstract public function initializeCacheConfig(): void;
    
    abstract public function initializeCacheKey(): void;

    abstract public function initializeCacheLifetime(): void;
    
    abstract public function setCacheKey(?string $cacheKey): void;
    
    abstract public function getCacheKey(): ?string;
    
    abstract public function setCacheLifetime(?int $cacheLifetime): void;
    
    abstract public function getCacheLifetime(): ?int;
    
    abstract public function setCacheConfig(?Collection $cacheConfig): void;
    
    abstract public function getCacheConfig(): ?Collection;
}
