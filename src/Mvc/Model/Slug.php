<?php

namespace Zemit\Mvc\Model;

use Phalcon\Utils\Slug as PhalconSlug;

trait Slug {
    
    protected function _setSlug($slugField = 'slug', $fromField = 'name') {
        
        if (property_exists($this, $slugField) && property_exists($this, $fromField)) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($slugField, $fromField) {
                switch ($event->getType()) {
                    case 'beforeValidation':
                        if (property_exists($entity, $slugField) && property_exists($entity, $fromField) && !empty($entity->$fromField)) {
                            $entity->$slugField = PhalconSlug::generate($entity->$fromField);
                        }
                        break;
                }
                return true;
            });
        }
        
    }
}
