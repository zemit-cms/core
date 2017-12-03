<?php

namespace Zemit\Core\Mvc\Model;

trait CreatedDate {

    protected function _setCreatedDate($field = 'created_date', $format = 'Y-m-d H:i:s') {
        
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($field, $format) {
                switch ($event->getType()) {
                    case 'beforeValidationOnCreate':
                        if (property_exists($entity, $field) && empty($entity->$field)) {
                            $entity->$field = date($format);
                        }
                        break;
                }
                return true;
            });
        }
    }
    
}
