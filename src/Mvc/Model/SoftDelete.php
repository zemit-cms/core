<?php

namespace Zemit\Mvc\Model;

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Db\RawValue;

trait SoftDelete {
    
    protected $_softDeleteSettings;
    
    protected function _setSoftDelete($field = 'deleted', $deletedValue = 1, $notDeletedValue = 0) {
        $this->_softDeleteSettings['field'] = $field;
        $this->_softDeleteSettings['deletedValue'] = $deletedValue;
        $this->_softDeleteSettings['notDeletedValue'] = $notDeletedValue;
        
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
    
    /**
     * Helper method to check if the row is soft deleted
     * @param null $field
     * @param null $deletedValue
     * @param null $notDeletedValue
     *
     * @return bool|null Bool if we know for sure, null if abnormal
     */
    public function _isDeleted($field = null, $deletedValue = null, $notDeletedValue = null) {
        $field ??= $this->_softDeleteSettings['field'];
        $deletedValue ??= $this->_softDeleteSettings['deletedValue'];
        $notDeletedValue ??= $this->_softDeleteSettings['notDeletedValue'];
        
        if (property_exists($this, $field)) {
            if ($this->$field === $deletedValue) {
                return true;
            }
            if ($this->$field === $notDeletedValue) {
                return false;
            }
            
            return null;
        }
        
        return false;
    }
    
    public function restore($field = null, $notDeletedValue = null) {
        $field ??= $this->_softDeleteSettings['field'];
        $notDeletedValue ??= $this->_softDeleteSettings['notDeletedValue'];
        $this->assign([$field => $notDeletedValue], [$field]);
        return $this->save();
    }

}
