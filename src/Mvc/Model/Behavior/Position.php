<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Model\Behavior;

use Phalcon\Db\RawValue;
use Phalcon\Mvc\EntityInterface;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\ModelInterface;
use PhalconKit\Mvc\Model;
use PhalconKit\Mvc\Model\Behavior\Traits\ProgressTrait;
use PhalconKit\Mvc\Model\Behavior\Traits\SkippableTrait;

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
    #[\Override]
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
                $this->afterSave($model, $field, $rawSql);
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
        if (property_exists($model, $field) && $model instanceof EntityInterface) {
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
        if (!$this->inProgress() && $model->hasSnapshotData() && $model->hasUpdated($field)) {
            self::staticStart();
            
            $snapshot = $model->getOldSnapshotData() ?: $model->getSnapshotData();
            $modelPosition = $model->readAttribute($field);
            $modelPrimaryKeys = $model->getPrimaryKeysValues();
            
            if ($modelPosition instanceof RawValue) {
                $modelPosition = $modelPosition->getValue();
            }
            
            if (!empty($modelPosition) || $modelPosition === '0') {
                $modelPosition = (int)$modelPosition;
                
                $positionField = $field;
                if (ini_get('phalcon.orm.column_renaming')) {
                    $columnMap = $model->getModelsMetaData()->getReverseColumnMap($model);
                    $positionFieldRaw = $columnMap[$field] ?? $field;
                } else {
                    $positionFieldRaw = $field;
                }
                
                $primaryKeyCondition = $rawSql
                    ? implode_sprintf($modelPrimaryKeys, ' and ', '`' . $model->getSource() . '`.`%2$s` <> ?')
                    : implode_sprintf($modelPrimaryKeys, ' and ', '[' . get_class($model) . '].[%2$s] <> :%2$s:');
                
                $positionKey = uniqid('_position_') . '_';
                $oldPositionKey = uniqid('_oldPosition_') . '_';
                
                $updatePositionQuery = null;
                $updatePositionParams = [$positionKey => $modelPosition, $oldPositionKey => (int)$snapshot[$field]];
                if ($snapshot[$field] > $modelPosition) {
                    $updatePositionQuery = $rawSql
                        ? 'UPDATE `' . $model->getSource() . '` SET `' . $positionFieldRaw . '` = `' . $positionFieldRaw . '`+1 WHERE `' . $positionFieldRaw . '` >= ? and `' . $positionFieldRaw . '` < ? and ' . $primaryKeyCondition
                        : 'UPDATE [' . get_class($model) . '] SET [' . $positionField . '] = [' . $positionField . ']+1 WHERE [' . $positionField . '] >= :' . $positionKey . ': and [' . $positionField . '] < :' . $oldPositionKey . ': and ' . $primaryKeyCondition;
                    $updatePositionParams = $rawSql
                        ? [$modelPosition, $snapshot[$field]]
                        : $updatePositionParams;
                }
                elseif ($snapshot[$field] < $modelPosition) {
                    $updatePositionQuery = $rawSql
                        ? 'UPDATE `' . $model->getSource() . '` SET `' . $positionFieldRaw . '` = `' . $positionFieldRaw . '`-1 WHERE `' . $positionFieldRaw . '` > ? and `' . $positionFieldRaw . '` <= ? and ' . $primaryKeyCondition
                        : 'UPDATE [' . get_class($model) . '] SET [' . $positionField . '] = [' . $positionField . ']-1 WHERE [' . $positionField . '] > :' . $oldPositionKey . ': and [' . $positionField . '] <= :' . $positionKey . ': and ' . $primaryKeyCondition;
                    $updatePositionParams = $rawSql
                        ? [$snapshot[$field], $modelPosition]
                        : $updatePositionParams;
                }
                
                if (!empty($updatePositionQuery)) {
                    if ($rawSql) {
                        $model->getWriteConnection()->query($updatePositionQuery, [
                            ...$updatePositionParams,
                            ...array_values($modelPrimaryKeys),
                        ]);
                    }
                    else {
                        $save = $model->getModelsManager()->executeQuery($updatePositionQuery, array_merge(
                            $updatePositionParams,
                            $modelPrimaryKeys,
                        ));
                        $messages = $save->getMessages();
                        if (!empty($messages)) {
                            $model->appendMessages($messages, 'afterSave');
                        }
                    }
                }
            }
            
            self::staticStop();
        }
    }
}
