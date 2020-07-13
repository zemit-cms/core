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

trait CreatedAt
{

    protected function _setCreatedAt($field = 'created_at', $format = 'Y-m-d H:i:s')
    {
        
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function ($event, $entity) use ($field, $format) {
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
