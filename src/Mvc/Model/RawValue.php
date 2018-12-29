<?php

namespace Zemit\Mvc\Model;

trait RawValue {
    
    public function _setRawValuesOnCreate($fields = array()) {
        if (!is_array($fields)) {
            $fields = array();
        }
        $this->getEventsManager()->attach('model', function($event, $entity) use ($fields) {
            if ($event->getType() === 'beforeValidationOnCreate') {
                foreach ($fields as $field) {
                    if (property_exists($this, $field) && empty($entity->$field)) {
                        $entity->$field = new RawValue('default');
                    }
                }
            }
            return true;
        });
    }
    
}