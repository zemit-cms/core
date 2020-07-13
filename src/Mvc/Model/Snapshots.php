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

trait Snapshots
{

    protected function _setSnapshots($keepSnapshots = true)
    {
        $this->keepSnapshots($keepSnapshots);
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
