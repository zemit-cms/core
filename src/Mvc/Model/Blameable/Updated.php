<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Blameable;

use Zemit\Mvc\Model;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Identity;
use Zemit\Mvc\Model\Options;
use Zemit\Mvc\Model\Snapshot;
use Zemit\Mvc\Model\SoftDelete;

trait Updated
{
    use AbstractBehavior;
    use Options;
    use Identity;
    use Snapshot;
    use SoftDelete;
    
    /**
     * Initializing Updated
     */
    public function initializeUpdated(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('updated') ?? [];
        
        $fieldBy = $options['fieldBy'] ?? 'updatedBy';
        $fieldAs = $options['fieldAs'] ?? 'updatedAs';
        $fieldAt = $options['fieldAt'] ?? 'updatedAt';
        
        $this->setUpdatedBehavior(new Transformable([
            'beforeValidationOnUpdate' => [
                $fieldBy => $this->hasChangedCallback(function () {
                    return $this->getCurrentUserIdCallback(false)();
                }),
                $fieldAs => $this->hasChangedCallback(function () {
                    return $this->getCurrentUserIdCallback(true)();
                }),
                $fieldAt => $this->hasChangedCallback(function () {
                    return date(Model::DATETIME_FORMAT);
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
