<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\Behavior\Action;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractModelsCache;
use Zemit\Support\Models;

/**
 * Flush Cache on changes
 *
 * @todo set cache keys
 * @todo improve to delete only necessary keys
 * @todo improve whiteList system
 * @todo precache system
 */
trait Cache
{
    use AbstractModelsCache;
    use AbstractBehavior;
    
    /**
     * Set true to avoid flushing cache for the current instance
     */
    public bool $preventFlushCache = false;
    
    /**
     * Whitelisted classes to not force global cache flush on change
     */
    public array $flushModelsCacheBlackList = [];
    
    /**
     * Initializing Cache
     */
    public function initializeCache(): void
    {
        $models = $this->getDI()->get('models');
        assert($models instanceof Models);
        
        $this->flushModelsCacheBlackList [] = $models->getSessionClass();
        $this->flushModelsCacheBlackList [] = $models->getAuditClass();
        $this->flushModelsCacheBlackList [] = $models->getAuditDetailClass();
        
        $this->addFlushCacheBehavior($this->flushModelsCacheBlackList);
    }
    
    /**
     * Adding Cache Behavior
     */
    public function addFlushCacheBehavior(?array $flushModelsCacheBlackList = null): void
    {
        $flushModelsCacheBlackList ??= $this->flushModelsCacheBlackList;
        
        // flush cache prevented by current instance
        if ($this->preventFlushCache) {
            return;
        }
        
        // flush cache prevented if current instance class is blacklisted
        if ($this->isInstanceOf($flushModelsCacheBlackList)) {
            return;
        }
        
        $modelsCache = $this->getModelsCache();
        $flushAction = function (Model $model) use ($modelsCache) {
            // Do not flush cache if nothing has changed
            return ($model->hasSnapshotData() && !($model->hasUpdated() || $model->hasChanged()))
                && $modelsCache->clear();
        };
        
        $actions = ['flush' => $flushAction];
        $this->addBehavior(new Action([
            'afterSave' => $actions,
            'afterCreate' => $actions,
            'afterUpdate' => $actions,
            'afterDelete' => $actions,
            'afterRestore' => $actions,
            'afterReorder' => $actions,
        ]));
    }
    
    /**
     * Check whether the current instance is any of the classes
     */
    public function isInstanceOf(array $classes = [], ?ModelInterface $that = null): bool
    {
        $that ??= $this;
        
        // Prevent adding behavior to whiteListed models
        foreach ($classes as $class) {
            if ($that instanceof $class) {
                return true;
            }
        }
        
        return false;
    }
}
