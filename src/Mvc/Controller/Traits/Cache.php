<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits;

use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Support\Slug;

/**
 * This trait provides methods for caching data.
 */
trait Cache
{
    use AbstractParams;
    
    /**
     * Returns the cache key for the given parameters.
     *
     * @param array|null $params The parameters to be used for generating the cache key. If null, it will use $this->getParams().
     * @return string|null The cache key generated from the parameters. If the parameters are null, it will return null.
     */
    public function getCacheKey(?array $params = null): ?string
    {
        $params ??= $this->getParams();
        
        return Slug::generate(json_encode($params, JSON_UNESCAPED_SLASHES));
    }
    
    /**
     * Returns the cache configuration for the given parameters.
     *
     * @param array|null $params The parameters to be used for generating the cache configuration. If null, it will use $this->getParams().
     * @return array|null The cache configuration array with 'lifetime' and 'key' keys. If the parameters are null or the 'cache' key is empty, it will return null.
     */
    public function getCache(?array $params = null)
    {
        $params ??= $this->getParams();
        
        if (!empty($params['cache'])) {
            return [
                'lifetime' => (int)$params['cache'],
                'key' => $this->getCacheKey($params),
            ];
        }
        
        return null;
    }
}
