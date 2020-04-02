<?php

namespace Zemit\Mvc\Model;

trait DeletedAt {

    protected function _setDeletedAt($field = 'deleted_at', $format = 'Y-m-d H:i:s', $deletedField = null) {
        $deletedField ??= $this->_softDeleteSettings['field'];
        
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($field, $format, $deletedField) {
                switch ($event->getType()) {
                    case 'beforeSave':
                        if (property_exists($entity, $field) && property_exists($entity, $deletedField)) {
                            if ($entity->hasChanged($deletedField) && $this->_isDeleted()) {
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
