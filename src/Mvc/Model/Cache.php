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
use Zemit\Bootstrap\Config;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\Session;

/**
 * Trait Cache
 * Flush Cache on changes
 * @todo improve to delete only necessary keys
 * @todo improve whiteList system
 * @todo precache
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
     * @param null $whiteList
     */
    public function addCacheBehavior($modelsCacheService = null, $whiteList = null): void
    {
        $modelsCacheService ??= 'modelsCache';
        $whiteList ??= [];
        
        /** @var Config $config */
        $config = $this->getDI()->get('config');
        
        // Set default whiteList
        $whiteList = array_merge($whiteList, [
            $config->getModelClass(Session::class),
            $config->getModelClass(Audit::class),
            $config->getModelClass(AuditDetail::class),
        ]);
        
        // Prevent adding behavior to whiteListed models
        foreach ($whiteList as $className) {
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
                $modelsCache = $this->getDI()->get($modelsCacheService);
                
                // Flush the entire cache
                return $modelsCache->clear();
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
