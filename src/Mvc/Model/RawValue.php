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
 * Trait RawValue
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
trait RawValue
{
    public function _setRawValues(array $fields = null, array $eventTypes = ['beforeValidationOnCreate'])
    {
        $this->getEventsManager()->attach('model', function ($event, $entity) use ($fields, $eventTypes) {
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
