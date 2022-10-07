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

use Phalcon\Support\HelperFactory;
use Zemit\Mvc\Model;

/**
 * Trait Position
 * @todo add a setting to do either raw sql query or use the complete orm with events
 * @todo fix it to make it work again
 * @todo refactor to use behavior instead
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Model
 */
trait Position
{
    
    protected $_positionSettings;
    
    protected function _setPosition($field = 'position', $idField = 'id')
    {
    
        $this->_positionSettings['field'] = $field;
        $this->_positionSettings['idField'] = $idField;
        
        if (property_exists($this, $field) && property_exists($this, $idField)) {
            $this->getEventsManager()->attach('model', function ($event, Model $entity) use ($field, $idField) {
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
                                $uField = (new HelperFactory)->uncamelize($field);
//                                ini_set('xdebug.max_nesting_level', 0);
                                if ($snapshot[$field] > $entityPosition) {
//                                    $updatePositionQuery = 'UPDATE [' . get_class($entity) . '] SET ['.$field.'] = ['.$field.']+1 WHERE ['.$field.'] >= ?1 and ['.$field.'] < ?2 and ['.$idField.'] <> ?0';
                                    $updatePositionRaw = 'UPDATE `'.$entity->getSource().'` SET `'.$uField.'` = `'.$uField.'`+1 WHERE `'.$uField.'` >= :position and `'.$uField.'` < :oldPosition and `'.$idField.'` <> :id';
                                } elseif ($snapshot[$field] < $entityPosition) {
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
    public function reorder(int $position = null, string $field = null)
    {
        $field ??= $this->_positionSettings['field'] ?? 'position';
    
        /**
         * Call the beforeReorder
         */
        if ($this->fireEventCancel('beforeReorder') === false) {
            return false;
        }
        
        $this->assign([$field => $position], [$field]);
        $saved = $this->save() && (!$this->hasSnapshotData() || $this->hasUpdated($field));
    
        /**
         * Call the afterReorder
         */
        if ($saved) {
            $this->fireEvent('afterReorder');
        }
        
        
        return $saved;
    }
}
