<?php

namespace Zemit\Mvc\Model;

trait UpdatedDate {

    protected function _setUpdatedDate($field = 'updated_date', $format = 'Y-m-d H:i:s') {
        
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($field, $format) {
                switch ($event->getType()) {
                    case 'beforeValidationOnUpdate':
                        if (property_exists($entity, $field)) {
                            if (!$entity->hasSnapshotData() || $entity->hasChanged()) {
                                $entity->$field = date($format);
                            }
                        }
                        break;
                }
                return true;
            });
        }
    }

}
