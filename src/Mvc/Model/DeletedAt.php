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

use Phalcon\Mvc\Model;
use Phalcon\Mvc\ModelInterface;

trait DeletedAt
{

    protected function _setDeletedAt($field = 'deletedAt', $format = self::DATETIME_FORMAT, $deletedField = null)
    {
        $deletedField ??= $this->_softDeleteSettings['field'] ?? 'deleted';
    
        if (property_exists($this, $field) && property_exists($this, $deletedField)) {
            $this->getEventsManager()->attach('model', function ($event, Model $entity) use ($field, $format, $deletedField) {
                switch ($event->getType()) {
                    case 'beforeDelete':
//                        if ((!$entity->hasSnapshotData() || $entity->hasChanged($deletedField)) && $this->isDeleted()) {
                            $entity->assign([$field => date($format)]);
//                        }
                        break;
                }
                return true;
            });
        }
    }
}
