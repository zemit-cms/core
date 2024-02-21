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

use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\AbstractTrait\AbstractEntity;
use Zemit\Mvc\Model\AbstractTrait\AbstractEventsManager;
use Zemit\Mvc\Model\AbstractTrait\AbstractModelsManager;

trait SoftDelete
{
    use AbstractModelsManager;
    use AbstractBehavior;
    use AbstractEventsManager;
    use AbstractEntity;
    use Options;
    use Behavior;
    
    /**
     * Initializing SoftDelete
     */
    public function initializeSoftDelete(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('softDelete') ?? [];
        
        $options['field'] ??= 'deleted';
        $options['value'] ??= 1;
        
        $this->setSoftDeleteBehavior(new Behavior\SoftDelete($options));
    }
    
    /**
     * Set the SoftDeleteBehavior variable
     * Attach the SoftDelete behavior class
     */
    public function setSoftDeleteBehavior(Behavior\SoftDelete $softDeleteBehavior): void
    {
        $this->setBehavior('softDelete', $softDeleteBehavior);
    }
    
    /**
     * Return the soft delete behavior instance
     */
    public function getSoftDeleteBehavior(): Behavior\SoftDelete
    {
        $behavior = $this->getBehavior('softDelete');
        assert($behavior instanceof Behavior\SoftDelete);
        return $behavior;
    }
    
    /**
     * Disable the soft delete for the current instance
     * Note: Zemit SoftDelete behavior must be attached
     */
    public function disableSoftDelete(): void
    {
        $this->getSoftDeleteBehavior()->disable();
    }
    
    /**
     * Enable the soft delete for the current instance
     * Note: Zemit SoftDelete behavior must be attached
     */
    public function enableSoftDelete(): void
    {
        $this->getSoftDeleteBehavior()->enable();
    }
    
    /**
     * Helper method to check if the row is soft deleted
     */
    public function isDeleted(?string $field = null, ?int $deletedValue = null): bool
    {
        $field ??= $this->getSoftDeleteBehavior()->getField() ?? 'deleted';
        $deletedValue ??= $this->getSoftDeleteBehavior()->getValue() ?? 1;
        return $this->readAttribute($field) === $deletedValue;
    }
    
    /**
     * Restore a previously Soft-deleted entry and fire events
     * Events:
     * - beforeRestore
     * - notRestored
     * - afterRestore
     *
     * @todo add a check from orm.events setup state
     */
    public function restore(?string $field = null, ?int $notDeletedValue = null): bool
    {
        $ormEvents = (bool)ini_get('phalcon.orm.events');
        
        if ($ormEvents) {
            $this->skipped = false;
            
            // fire event, allowing to stop options or skip the current operation
            if ($this->fireEventCancel('beforeRestore') === false) {
                return false;
            }
            
            if ($this->skipped) {
                return true;
            }
        }
        
        $field ??= $this->getSoftDeleteBehavior()->getField();
        $notDeletedValue ??= 0;
        
        // restore (unset soft delete value and save)
        $this->writeAttribute($field, $notDeletedValue);
        $save = $this->save();
        
        // check if the entity is restored
        $value = $this->readAttribute($field);
        $restored = $save && $value === $notDeletedValue;
        
        // fire events
        if ($ormEvents) {
            if (!$restored) {
                $this->fireEvent('notRestored');
            }
            else {
                $this->fireEvent('afterRestore');
            }
        }
        
        return $restored;
    }
}
