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

use Zemit\Db\Column;
use Zemit\Mvc\Model\AbstractTrait\AbstractBehavior;
use Zemit\Mvc\Model\Behavior\Transformable;
use Zemit\Mvc\Model\Identity;
use Zemit\Mvc\Model\Options;
use Zemit\Mvc\Model\Snapshot;
use Zemit\Mvc\Model\SoftDelete;

trait Created
{
    use AbstractBehavior;
    use Options;
    use Identity;
    use Snapshot;
    use SoftDelete;
    
    /**
     * Initializing Created
     */
    public function initializeCreated(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('created') ?? [];
        
        $fieldBy = $options['fieldBy'] ?? 'createdBy';
        $fieldAs = $options['fieldAs'] ?? 'createdAs';
        $fieldAt = $options['fieldAt'] ?? 'createdAt';
        
        $this->setCreatedBehavior(new Transformable([
            'beforeValidationOnCreate' => [
                $fieldBy => $this->getCurrentUserIdCallback(),
                $fieldAs => $this->getCurrentUserIdCallback(true),
                $fieldAt => date(Column::DATETIME_FORMAT),
            ],
        ]));
    }
    
    /**
     * Set Created Behavior
     */
    public function setCreatedBehavior(Transformable $createdBehavior): void
    {
        $this->setBehavior('created', $createdBehavior);
    }
    
    /**
     * Get Created Behavior
     */
    public function getCreatedBehavior(): Transformable
    {
        $behavior = $this->getBehavior('created');
        assert($behavior instanceof Transformable);
        return $behavior;
    }
}
