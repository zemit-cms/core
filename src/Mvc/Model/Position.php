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

use Phalcon\Text;
use Zemit\Mvc\Model;

trait Position {
    
    protected $_positionSettings;
    
    protected function _setPosition($field = 'position', $idField = 'id') {
    
        $this->_positionSettings['field'] = $field;
        $this->_positionSettings['idField'] = $idField;
        
        if (property_exists($this, $field) && property_exists($this, $idField)) {
            $this->getEventsManager()->attach('model', function($event, Model $entity) use ($field, $idField) {
                switch ($event->getType()) {
                    case 'beforeValidation':
                        // if position field is empty, force current max(position)+1
                        $lastPosition = self::findFirst(['order' => $field . ' DESC']);
                        $this->$field = $lastPosition ? $lastPosition->$field + 1 : 1;
                        break;
                    case 'afterSave':
                        if ($entity->hasSnapshotData() && $entity->hasUpdated($field)) {
                            $snapshot = $entity->getOldSnapshotData() ?: $entity->getSnapshotData();
                            $entityPosition = $entity->{'get' . ucfirst($field)}();
                            $entityId = $entity->{'get' . ucfirst($idField)}();
                            
                            if ($entityPosition instanceof \Phalcon\Db\RawValue) {
                            
                            } else {
                                $uField = Text::uncamelize($field);
//                                ini_set('xdebug.max_nesting_level', 0);
                                if ($snapshot[$field] > $entityPosition) {
//                                    $updatePositionQuery = 'UPDATE [' . get_class($entity) . '] SET ['.$field.'] = ['.$field.']+1 WHERE ['.$field.'] >= ?1 and ['.$field.'] < ?2 and ['.$idField.'] <> ?0';
                                    $updatePositionRaw = 'UPDATE `'.$entity->getSource().'` SET `'.$uField.'` = `'.$uField.'`+1 WHERE `'.$uField.'` >= :position and `'.$uField.'` < :oldPosition and `'.$idField.'` <> :id';
                                }
                                else if ($snapshot[$field] < $entityPosition) {
//                                    $updatePositionQuery = 'UPDATE [' . get_class($entity) . '] SET ['.$field.'] = ['.$field.']-1 WHERE ['.$field.'] > ?2 and ['.$field.'] <= ?1 and ['.$idField.'] <> ?0';
                                    $updatePositionRaw = 'UPDATE `' . $entity->getSource() . '` SET `'.$uField.'` = `'.$uField.'`-1 WHERE `'.$uField.'` > :oldPosition and `'.$uField.'` <= :position and `'.$idField.'` <> :id';
                                }
//                                $entity->getModelsManager()->executeQuery($updatePositionQuery, [$entityId, $entityPosition, $snapshot[$field]]);
                                if (!empty($updatePositionRaw)) {
                                    $entity->getWriteConnection()->query($updatePositionRaw, [
                                        'id' => $entityId,
                                        'position' => $entityPosition,
                                        'oldPosition' => $snapshot[$field],
                                    ]);
                                }
                            }
                        }
                        break;
                }
                return true;
            });
        }
    }
    
    /**
     * Re-ordering an entity
     * - Update position+1 done using afterSave event
     *
     * @param int|null $position
     * @param string|null $field
     *
     * @return mixed
     */
    public function reorder(int $position = null, string $field = null) {
        $field ??= $this->_positionSettings['field'] ?? 'position';
        $this->assign([$field => $position], [$field]);
        return $this->save() && (!$this->hasSnapshotData() || $this->hasUpdated($field));
    }
}
