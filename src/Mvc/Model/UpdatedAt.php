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

/**
 * Trait UpdatedAt
 * @deprecated @todo to be removed
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait UpdatedAt
{
    protected function _setUpdatedAt($field = 'updatedAt', $format = 'Y-m-d H:i:s')
    {
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function ($event, $entity) use ($field, $format) {
                switch ($event->getType()) {
                    case 'beforeValidationOnUpdate':
                        if (property_exists($entity, $field)) {
                            if (!$entity->hasSnapshotData() || $entity->hasChanged()) {
                                $entity->$field = date($format);
                            }
                        }
                        break;
                }
                return true;
            });
        }
    }
}
