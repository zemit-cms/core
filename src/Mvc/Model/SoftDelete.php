<?php

namespace Zemit\Core\Mvc\Model;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Db\RawValue;

trait SoftDelete {

    protected function _setSoftDelete($field = 'deleted', $deletedValue = '1', $notDeletedValue = '0') {
        
        // make sure the property exists before to add the feature to the model
        if (property_exists($this, $field)) {
            
            // add the SoftDelete behavior
            $this->addBehavior(new Behavior\SoftDelete(array(
                'field' => $field,
                'value' => $deletedValue
            )));

            // attach the event to escape validation error and set the notDeletedValue or the default raw sql value
            $this->getEventsManager()->attach('model', function($event, $entity) use($field, $notDeletedValue) {
                if ($event->getType() === 'beforeValidationOnCreate') {
                    if (property_exists($entity, $field) && empty($entity->$field)) {
                        $entity->$field = is_null($notDeletedValue) ? new RawValue('default') : $notDeletedValue;
                    }
                }
                return true;
            });
        }
    }

}
