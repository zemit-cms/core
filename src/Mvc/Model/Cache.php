<?php

namespace Zemit\Core\Mvc\Model;

trait Cache {

    protected function _flushCacheOnChange($cacheAdapter = null) {
        if (empty($cacheAdapter)) {
            $cacheAdapter = $this->getDI()->getCache();
        }
        if ($cacheAdapter) {
            $this->getEventsManager()->attach('model', function($event, $entity) use ($cacheAdapter) {
                switch ($event->getType()) {
                    case 'afterSave':
                        $cacheAdapter->flush();
                        break;
                }
                return true;
            });
        }
    }

}
