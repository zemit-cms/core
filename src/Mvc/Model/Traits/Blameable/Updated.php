<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits\Blameable;

use Zemit\Db\Column;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBehavior;
use Zemit\Mvc\Model\Traits\Abstracts\AbstractBlameable;
use Zemit\Mvc\Model\Traits\Identity;
use Zemit\Mvc\Model\Traits\Options;
use Zemit\Mvc\Model\Traits\Snapshot;
use Zemit\Mvc\Model\Traits\SoftDelete;

trait Updated
{
    use AbstractBehavior;
    use AbstractBlameable;
    use Options;
    use Identity;
    use Snapshot;
    use SoftDelete;
    use BlameAt;
    
    /**
     * Initializing Updated
     */
    public function initializeUpdated(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('updated') ?? [];
        
        $fieldBy = $options['fieldBy'] ?? 'updatedBy';
        $fieldAs = $options['fieldAs'] ?? 'updatedAs';
        $fieldAt = $options['fieldAt'] ?? 'updatedAt';
        
        $this->addUserRelationship($fieldBy, 'UpdatedBy');
        $this->addUserRelationship($fieldAs, 'UpdatedAs');
        
        $this->setUpdatedBehavior(new Transformable([
            'beforeValidationOnUpdate' => [
                $fieldBy => $this->hasChangedCallback(function () {
                    return $this->getCurrentUserIdCallback(false)();
                }),
                $fieldAs => $this->hasChangedCallback(function () {
                    return $this->getCurrentUserIdCallback(true)();
                }),
                $fieldAt => $this->hasChangedCallback(function () {
                    return $this->getDateCallback(Column::DATETIME_FORMAT)();
                }),
            ],
        ]));
    }
    
    /**
     * Set Updated Behavior
     */
    public function setUpdatedBehavior(Transformable $updatedBehavior): void
    {
        $this->setBehavior('updated', $updatedBehavior);
    }
    
    /**
     * Get Updated Behavior
     */
    public function getUpdatedBehavior(): Transformable
    {
        $behavior = $this->getBehavior('updated');
        assert($behavior instanceof Transformable);
        return $behavior;
    }
}
