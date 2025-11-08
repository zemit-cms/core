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

namespace PhalconKit\Mvc\Model\Traits;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\ModelInterface;
use PhalconKit\Mvc\Model\Behavior\Action;
use PhalconKit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use PhalconKit\Mvc\Model\Traits\Abstracts\AbstractModelsCache;
use PhalconKit\Support\Models;

/**
 * Flush Cache on changes
 *
 * @todo improve model cache trait
 * - set cache keys
 * - improve to delete only necessary keys
 * - improve whiteList system
 * - precache system
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
        $flushAction = function (Model $model) use ($modelsCache): bool {
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
