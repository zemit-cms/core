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
use Zemit\Mvc\Model\Behavior\Position as PositionBehavior;

trait Position
{
    use Model\AbstractTrait\AbstractBehavior;
    use Attribute;
    use Options;
    
    public Model\Behavior\Position $positionBehavior;
    
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
        $this->positionBehavior = $positionBehavior;
        $this->addBehavior($this->positionBehavior);
    }
    
    /**
     * Get Position Behavior
     */
    public function getPositionBehavior(): PositionBehavior
    {
        return $this->positionBehavior;
    }
    
    /**
     * Re-ordering an entity
     * - Update position+1 done using afterSave event
     *
     * @return mixed
     * @throws Exception
     */
    public function reorder(?int $position = null, ?string $positionField = null)
    {
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
