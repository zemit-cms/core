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

trait Restored
{
    use AbstractBehavior;
    use AbstractBlameable;
    use Options;
    use Identity;
    use Snapshot;
    use SoftDelete;
    use BlameAt;
    
    /**
     * Initializing Restored
     */
    public function initializeRestored(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('restored') ?? [];
        
        $fieldBy = $options['fieldBy'] ?? 'restoredBy';
        $fieldAs = $options['fieldAs'] ?? 'restoredAs';
        $fieldAt = $options['fieldAt'] ?? 'restoredAt';
        
        $this->addUserRelationship($fieldBy, 'RestoredBy');
        $this->addUserRelationship($fieldAs, 'RestoredAs');
        
        $this->setRestoredBehavior(new Transformable([
            'beforeRestore' => [
                $fieldBy => $this->getCurrentUserIdCallback(),
                $fieldAs => $this->getCurrentUserIdCallback(true),
                $fieldAt => $this->getDateCallback(Column::DATETIME_FORMAT),
            ],
        ]));
    }
    
    /**
     * Set Restored Behavior
     */
    public function setRestoredBehavior(Transformable $restoredBehavior): void
    {
        $this->setBehavior('restored', $restoredBehavior);
    }
    
    /**
     * Get Restored Behavior
     */
    public function getRestoredBehavior(): Transformable
    {
        $behavior = $this->getBehavior('restored');
        assert($behavior instanceof Transformable);
        return $behavior;
    }
}
