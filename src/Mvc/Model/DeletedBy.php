<?php

namespace Zemit\Mvc\Model;

trait DeletedBy {
    
    protected function _setDeletedBy($field = 'deleted_by', $deletedField = null) {
        $deletedField ??= $this->_softDeleteSettings['field'];
        
        if (property_exists($this, $field) && property_exists($this)) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($field, $deletedField) {
                switch ($event->getType()) {
                    case 'beforeValidationOnSave':
                        /** @var ResultSet\Simple $user */
                        $user = $this->_getUser();
                        if ($user && $entity->_isDeleted() && $entity->hasChanged($deletedField)) {
                            $entity->$field = $user->id;
                        }
                        break;
                }
                return true;
            });
        }
    }
}
