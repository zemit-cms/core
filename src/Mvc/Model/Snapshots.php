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

use Zemit\Mvc\Model\AbstractTrait\AbstractEventsManager;

trait Snapshots
{
    use AbstractEventsManager;
    
    abstract protected function keepSnapshots(bool $keepSnapshot): void;
    
    public function initializeSnapshots(): void
    {
        $this->keepSnapshots(true);
        $this->attachSnapshotEvent(true);
    }
    
    protected function attachSnapshotEvent(bool $keepSnapshots = true): void
    {
        if ($keepSnapshots) {
            $this->getEventsManager()->attach('model', function ($event, $entity) {
                
                switch ($event->getType()) {
                    case 'beforeCreate':
                        $entity->setSnapshotData($entity->toArray());
                        break;
                }
                
                return true;
            });
        }
    }
}
