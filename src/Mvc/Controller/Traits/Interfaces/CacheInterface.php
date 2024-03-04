<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Interfaces;

use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Support\Slug;

interface CacheInterface
{
    public function getCacheKey(?array $params = null): ?string;
    
    public function getCache(?array $params = null);
}
