<?php

declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits;

use Exception;
use Zemit\Mvc\Model;
use Zemit\Mvc\Model\Behavior\Position as PositionBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractEventsManager;

/**
 * The Position trait is used to manage the position behavior of an object.
 * It provides methods to initialize the position behavior set and retrieve
 * the position behavior object, and reorder the object's position in a list.
 */
trait Position
{
    use AbstractEventsManager;
    use Behavior;
    use Options;
    
    /**
     * Initializes the position behavior for the current object.
     * Sets the position options and sets the position behavior accordingly.
     *
     * @param array|null $options The options for the position behavior.
     *                            If not provided, the default position behavior options will be used.
     *
     * @throws Exception
     */
    public function initializePosition(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('position') ?? [];
        
        $this->setPositionBehavior(new PositionBehavior($options));
    }
    
    /**
     * Sets the position behavior for the current object.
     *
     * @param PositionBehavior $positionBehavior The position behavior to be set.
     *
     * @return void
     */
    public function setPositionBehavior(PositionBehavior $positionBehavior): void
    {
        $this->setBehavior('position', $positionBehavior);
    }
    
    /**
     * Retrieves the position behavior attached to the current object.
     *
     * @return PositionBehavior The position behavior object.
     * @throws Exception if the position behavior is not found.
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
