<?php

namespace Zemit\Mvc\Model;

trait UpdatedBy {
    
    protected function _setUpdatedBy($field = 'updated_by') {
    
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($field) {
                switch ($event->getType()) {
                    case 'beforeValidationOnUpdate':
                        /** @var ResultSet\Simple $user */
                        $user = $this->_getUser();
                        if (property_exists($entity, $field) && $user) {
                            $entity->$field = $user->id;
                        }
                        break;
                }
                return true;
            });
        }
    }
}
