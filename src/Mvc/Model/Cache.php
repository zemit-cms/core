<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model;

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
