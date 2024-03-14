<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query;

use Phalcon\Support\Collection;

trait AbstractCache
{
    abstract public function initializeCache(): void;
    
    abstract public function initializeCacheKey(): void;
    
    abstract public function setCacheKey(?string $cacheKey): void;
    
    abstract public function getCacheKey(): ?string;
    
    abstract public function setCache(?Collection $cache): void;
    
    abstract public function getCache(): ?Collection;
}
