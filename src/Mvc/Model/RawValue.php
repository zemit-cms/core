<?php

namespace Zemit\Mvc\Model;

trait RawValue
{
    public function _setRawValues(array $fields = null, array $eventTypes = ['beforeValidationOnCreate'])
    {
        $this->getEventsManager()->attach('model', function($event, $entity) use ($fields, $eventTypes) {
            if (in_array($event->getType(), $eventTypes)) {
                foreach ($fields as $field) {
                    if (property_exists($this, $field) && is_null($entity->$field)) {
                        $entity->$field = new \Phalcon\Db\RawValue('default');
                    }
                }
            }
            
            return true;
        });
    }
    
}
