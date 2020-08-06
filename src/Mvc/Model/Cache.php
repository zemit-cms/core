<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

use Phalcon\Mvc\ModelInterface;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\Session;

/**
 * Trait Cache
 * Flush Cache on changes
 * @todo improve to delete only necessary keys
 * @todo improve whitelist system
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait Cache
{
    /**
     * Initializing Cache
     */
    public function initializeCache()
    {
        $this->addCacheBehavior();
    }
    
    /**
     * Adding Cache Behavior
     *
     * @param null $modelsCacheService
     * @param null $whitelist
     */
    public function addCacheBehavior($modelsCacheService = null, $whitelist = null): void
    {
        $modelsCacheService ??= 'modelsCache';
        $whitelist ??= [];
        
        // Set default whitelist
        $whitelist = array_merge($whitelist, [
            Session::class,
            Audit::class,
            AuditDetail::class,
        ]);
        
        // Prevent adding behavior to whitelisted models
        foreach ($whitelist as $className) {
            if ($this instanceof $className) {
                return;
            }
        }
        
        $actions = [
            'flush' => function(ModelInterface $model, $action) use ($modelsCacheService) {
            
                // Do not flush cache if nothing has changed
                if ($this->hasSnapshotData() && !($this->hasUpdated() || $this->hasChanged())) {
                    return false;
                }
            
                /** @var \Phalcon\Cache $modelsCache */
                $cache = $this->getDI()->get($modelsCacheService);
                
                // Flush the entire cache
                return $cache->clear();
            },
        ];
        $this->addBehavior(new Behavior\Action([
            'afterSave' => $actions,
            'afterCreate' => $actions,
            'afterUpdate' => $actions,
            'afterDelete' => $actions,
            'afterRestore' => $actions,
            'afterReorder' => $actions,
        ]));
    }
}
