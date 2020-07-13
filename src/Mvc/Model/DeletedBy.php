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

trait DeletedBy
{
    
    protected function _setDeletedBy($field = 'deletedBy', $deletedField = null)
    {
        $deletedField ??= $this->_softDeleteSettings['field'] ?? null;
        
        if (property_exists($this, $field)) {
            $this->getEventsManager()->attach('model', function ($event, $entity) use ($field, $deletedField) {
                switch ($event->getType()) {
                    case 'beforeValidationOnSave':
                        /** @var ResultSet\Simple $user */
                        $user = $this->_getUser();
                        if ($user && $entity->isDeleted() && $entity->hasChanged($deletedField)) {
                            $entity->$field = $user->id;
                        }
                        break;
                }
                return true;
            });
        }
    }
}
