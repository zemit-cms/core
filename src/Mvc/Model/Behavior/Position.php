<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Behavior;

use Phalcon\Db\RawValue;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Text;
use Zemit\Mvc\Model;

class Position extends Behavior
{
    use ProgressTrait;
    use SkippableTrait;
    
    public bool $progress = false;
    
    public function setField(string $field): void
    {
        $this->options['field'] = $field;
    }
    
    public function getField(): string
    {
        return $this->options['field'];
    }
    
    public function setRawSql(bool $rawSql): void
    {
        $this->options['rawSql'] = $rawSql;
    }
    
    public function getRawSql(): bool
    {
        return $this->options['rawSql'];
    }
    
    public function hasProperty(ModelInterface $model, string $field): bool
    {
        return property_exists($model, $field);
    }
    
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->setField($options['field'] ?? 'position');
        $this->setRawSql($options['rawSql'] ?? true);
    }
    
    /**
     * Set the default position field value before validation
     * Shift position+1 and position-1 to other records after save
     */
    public function notify(string $type, ModelInterface $model)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        $field = $this->getField();
        $rawSql = $this->getRawSql();
        
        // skip if the current model doesn't have the position property defined
        if (!$this->hasProperty($model, $field)) {
            return;
        }
        
        switch ($type) {
            case 'beforeValidation':
                $this->beforeValidation($model, $field);
                break;
            
            case 'afterSave':
//                $this->afterSave($model, $field, $rawSql);
                break;
        }
        
        return true;
    }
    
    /**
     * Force the current position to max(position)+1 if it's empty
     * will only happen if the position field is present on the current model
     */
    public function beforeValidation(ModelInterface $model, string $field): void
    {
        if (property_exists($model, $field)) {
            $positionValue = $model->readAttribute($field);
            if (is_null($positionValue)) {
                
                // if position field is empty, force current max(position)+1
                $lastPosition = $model::findFirst(['order' => $field . ' DESC']);
                if ($lastPosition && assert($lastPosition instanceof $model)) {
                    $position = (int)$lastPosition->readAttribute($field);
                    $model->writeAttribute($field, $position + 1);
                }
            }
        }
    }
    
    // @todo fix combined primary keys
    public function afterSave(ModelInterface $model, string $field, bool $rawSql): void
    {
        if (!$this->getProgress() && $model->hasSnapshotData() && $model->hasUpdated($field)) {
            self::staticStart();
            
            $snapshot = $model->getOldSnapshotData() ?: $model->getSnapshotData();
            $modelPosition = $model->readAttribute($field);
            $modelPrimaryKeys = $model->getPrimaryKeysValues();
            
            if (!($modelPosition instanceof RawValue)) {
                $uField = Text::uncamelize($field); // @todo use columnMap
                $updatePositionQuery = null;
                
                if ($snapshot[$field] > $modelPosition) {
                    $updatePositionQuery = $rawSql
                        ? 'UPDATE `' . $model->getSource() . '` SET `' . $uField . '` = `' . $uField . '`+1 WHERE `' . $uField . '` >= :position and `' . $uField . '` < :oldPosition and `' . $idField . '` <> :id'
                        : 'UPDATE [' . get_class($model) . '] SET [' . $field . '] = [' . $field . ']+1 WHERE [' . $field . '] >= ?1 and [' . $field . '] < ?2 and [' . $idField . '] <> ?0';
                }
                elseif ($snapshot[$field] < $modelPosition) {
                    $updatePositionQuery = $rawSql
                        ? 'UPDATE `' . $model->getSource() . '` SET `' . $uField . '` = `' . $uField . '`-1 WHERE `' . $uField . '` > :oldPosition and `' . $uField . '` <= :position and `' . $idField . '` <> :id'
                        : 'UPDATE [' . get_class($model) . '] SET [' . $field . '] = [' . $field . ']-1 WHERE [' . $field . '] > ?2 and [' . $field . '] <= ?1 and [' . $idField . '] <> ?0';
                }
                
                if (!empty($updatePositionQuery)) {
                    if ($rawSql) {
                        $model->getWriteConnection()->query($updatePositionQuery, [
                            'primaryKeys' => $modelPrimaryKeys,
                            'position' => $modelPosition,
                            'oldPosition' => $snapshot[$field],
                        ]);
                    }
                    else {
                        $model->getModelsManager()->executeQuery($updatePositionQuery, [$modelId, $modelPosition, $snapshot[$field]]);
                    }
                }
            }
            
            self::staticStop();
        }
    }
}
