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
use Zemit\Mvc\Model\Snapshots;
use Zemit\Mvc\Model\SoftDelete;

trait Restored
{
    use AbstractBehavior;
    use Options;
    use Identity;
    use Snapshots;
    use SoftDelete;
    
    public Transformable $restoredBehavior;
    
    /**
     * Initializing Restored
     */
    public function initializeRestored(?array $options = null): void
    {
        $options ??= $this->getOptionsManager()->get('restored') ?? [];
        
        $fieldBy = $options['fieldBy'] ?? 'restoredBy';
        $fieldAs = $options['fieldAs'] ?? 'restoredAs';
        $fieldAt = $options['fieldAt'] ?? 'restoredAt';
        
        $this->setRestoredBehavior(new Transformable([
            'beforeRestore' => [
                $fieldBy => $this->getCurrentUserIdCallback(),
                $fieldAs => $this->getCurrentUserIdCallback(true),
                $fieldAt => date(Model::DATETIME_FORMAT),
            ],
        ]));
    }
    
    /**
     * Set Restored Behavior
     */
    public function setRestoredBehavior(Transformable $restoredBehavior): void
    {
        $this->restoredBehavior = $restoredBehavior;
        $this->addBehavior($this->restoredBehavior);
    }
    
    /**
     * Get Restored Behavior
     */
    public function getRestoredBehavior(): Transformable
    {
        return $this->restoredBehavior;
    }
}
