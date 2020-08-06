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
 * Trait CreatedBy
 * @todo to be removed
 * @deprecated use behavior instead
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait CreatedBy
{
    protected function _setCreatedBy($field = 'created_by')
    {
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function ($event, $entity) use ($field) {
                switch ($event->getType()) {
                    case 'beforeValidationOnCreate':
                        /** @var ResultSet\Simple $user */
                        $user = $this->_getUser();
                        if (property_exists($entity, $field) && empty($entity->$field) && $user) {
                            $entity->$field = $user->id;
                        }
                        break;
                }
                return true;
            });
        }
    }
}
