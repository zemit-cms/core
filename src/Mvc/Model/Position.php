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

use Exception;
use Zemit\Mvc\Model;
use Zemit\Mvc\Model\AbstractTrait\AbstractEventsManager;
use Zemit\Mvc\Model\Behavior\Position as PositionBehavior;

trait Position
{
    use AbstractEventsManager;
    use Behavior;
    use Options;
    
    /**
     * Initializing Position
     */
    public function initializePosition(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('position') ?? [];
        
        $this->setPositionBehavior(new PositionBehavior($options));
    }
    
    /**
     * Set Position Behavior
     */
    public function setPositionBehavior(PositionBehavior $positionBehavior): void
    {
        $this->setBehavior('position', $positionBehavior);
    }
    
    /**
     * Get Position Behavior
     */
    public function getPositionBehavior(): PositionBehavior
    {
        $behavior = $this->getBehavior('position');
        assert($behavior instanceof PositionBehavior);
        return $behavior;
    }
    
    /**
     * Reorders the current object's position in the list.
     * - Update position+1 done using afterSave event
     *
     * @param int|null $position The new position for the object. If not provided, the default behavior's position field will be used.
     * @param string|null $positionField The field on which the position is stored. If not provided, the default behavior's field will be used.
     *
     * @return bool Returns true if the reorder operation was successful, false otherwise.
     * @throws Exception
     */
    public function reorder(?int $position = null, ?string $positionField = null): bool
    {
        assert($this instanceof Model);
        
        $positionField ??= $this->getPositionBehavior()->getField();
        
        if ($this->fireEventCancel('beforeReorder') === false) {
            return false;
        }
        
        $this->assign([$positionField => $position], [$positionField]);
        $saved = $this->save() && (!$this->hasSnapshotData() || $this->hasUpdated($positionField));
        
        if ($saved) {
            $this->fireEvent('afterReorder');
        }
        
        return $saved;
    }
}
