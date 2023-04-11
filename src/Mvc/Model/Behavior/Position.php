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

use Phalcon\Text;
use Phalcon\Db\RawValue;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
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
    public function notify(string $type, ModelInterface $model): ?bool
    {
        if (!$this->isEnabled()) {
            return null;
        }
        
        $field = $this->getField();
        $rawSql = $this->getRawSql();
        
        // skip if the current model doesn't have the position property defined
        if (!$this->hasProperty($model, $field)) {
            return null;
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
                $lastRecord = $model::findFirst(['order' => $field . ' DESC']);
                if ($lastRecord && assert($lastRecord instanceof $model)) {
                    $lastPosition = (int)$lastRecord->readAttribute($field);
                    $model->writeAttribute($field, $lastPosition + 1);
                }
            }
        }
    }
    
    public function afterSave(ModelInterface $model, string $field, bool $rawSql): void
    {
        assert($model instanceof Model);
        if (!$this->getProgress() && $model->hasSnapshotData() && $model->hasUpdated($field)) {
            self::staticStart();
            
            $snapshot = $model->getOldSnapshotData() ?: $model->getSnapshotData();
            $modelPosition = $model->readAttribute($field);
            $modelPrimaryKeys = $model->getPrimaryKeysValues();
            
            if (!($modelPosition instanceof RawValue)) {
                
                $positionField = $field;
                if (ini_get('phalcon.orm.column_renaming')) {
                    $columnMap = $model->getModelsMetaData()->getReverseColumnMap($model);
                    $positionFieldRaw = $columnMap[$field] ?? $field;
                } else {
                    $positionFieldRaw = $field;
                }
                
                $primaryKeyConditionRaw = implode_mb_sprintf($modelPrimaryKeys, ' and ', '`' . $model->getSource() . '`.`%s` <> ?%s');
                $primaryKeyCondition = implode_mb_sprintf($modelPrimaryKeys, ' and ', '[' . get_class($model) . '].[%s] <> ?%s');
                
                $updatePositionQuery = null;
                if ($snapshot[$field] > $modelPosition) {
                    $updatePositionQuery = $rawSql
                        ? 'UPDATE `' . $model->getSource() . '` SET `' . $positionFieldRaw . '` = `' . $positionFieldRaw . '`+1 WHERE `' . $positionFieldRaw . '` >= :position and `' . $positionFieldRaw . '` < :oldPosition and ' . $primaryKeyConditionRaw
                        : 'UPDATE [' . get_class($model) . '] SET [' . $positionField . '] = [' . $positionField . ']+1 WHERE [' . $positionField . '] >= ?1 and [' . $positionField . '] < ?2 and ' . $primaryKeyCondition;
                }
                elseif ($snapshot[$field] < $modelPosition) {
                    $updatePositionQuery = $rawSql
                        ? 'UPDATE `' . $model->getSource() . '` SET `' . $positionFieldRaw . '` = `' . $positionFieldRaw . '`-1 WHERE `' . $positionFieldRaw . '` > :oldPosition and `' . $positionFieldRaw . '` <= :position and ' . $primaryKeyConditionRaw
                        : 'UPDATE [' . get_class($model) . '] SET [' . $positionField . '] = [' . $positionField . ']-1 WHERE [' . $positionField . '] > ?2 and [' . $positionField . '] <= ?1 and ' . $primaryKeyCondition;
                }
                
                if (!empty($updatePositionQuery)) {
                    if ($rawSql) {
                        $model->getWriteConnection()->query($updatePositionQuery, [
                            'position' => $modelPosition,
                            'oldPosition' => $snapshot[$field],
                        ]);
                    }
                    else {
                        $model->getModelsManager()->executeQuery($updatePositionQuery, [
                            $modelPosition,
                            $snapshot[$field]
                        ]);
                    }
                }
            }
            
            self::staticStop();
        }
    }
}
