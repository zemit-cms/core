<?php

namespace Zemit\Mvc\Model;

trait Snapshots {

    protected function _setSnapshots($keepSnapshots = true) {
        $this->keepSnapshots($keepSnapshots);
        if ($keepSnapshots) {
            $this->getEventsManager()->attach('model', function($event, $entity) {
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
