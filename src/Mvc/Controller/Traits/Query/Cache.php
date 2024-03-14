<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query;

use Phalcon\Filter\Exception;
use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;

/**
 * This trait provides methods for caching data for the query.
 */
trait Cache
{
    use AbstractParams;
    
    public ?Collection $cache;
    public ?string $cacheKey;
    
    /**
     * Initializes the cache.
     *
     * This method initializes the cache by setting the cache key and lifetime.
     *
     * @return void
     * @throws Exception
     */
    public function initializeCache(): void
    {
        $this->initializeCacheKey();
        
        $lifetime = $this->getParam('lifetime', [Filter::FILTER_ABSINT]);
        
        if (!isset($lifetime)) {
            $this->setCache(null);
            return;
        }
        
        $this->setCache(new Collection([
            'lifetime' => $lifetime,
            'key' => $this->getCacheKey()
        ]));
    }
    
    /**
     * Initializes the cache key based on the current parameters and user identity.
     *
     * This method generates a cache key by concatenating the user identity and a hash of the current parameters.
     * The generated cache key is then set as the value of the cache key for the current instance of the object.
     *
     * @return void
     */
    public function initializeCacheKey(): void
    {
        $paramsKey = md5(json_encode($this->getParams()));
        $identityKey = $this->identity->getUserId();
        $this->setCacheKey($identityKey . '-' . $paramsKey);
    }
    
    /**
     * Sets the cache key.
     *
     * @param string|null $cacheKey The cache key.
     * @return void
     */
    public function setCacheKey(?string $cacheKey): void
    {
        $this->cacheKey = $cacheKey;
    }
    
    /**
     * Retrieves the cache key.
     *
     * @return string|null The cache key.
     */
    public function getCacheKey(): ?string
    {
        return $this->cacheKey;
    }
    
    /**
     * Set the cache collection for the query.
     *
     * @param Collection|null $cache The cache collection, or null to disable.
     * @return void
     */
    public function setCache(?Collection $cache): void
    {
        $this->cache = $cache;
    }
    
    /**
     * Retrieves the cache collection for the query.
     *
     * @return Collection|null The cache, or null if no cache is set.
     */
    public function getCache(): ?Collection
    {
        return $this->cache;
    }
}
