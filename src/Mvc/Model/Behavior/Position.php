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
    
    public function setProgress(bool $progress): void
    {
        $this->progress = $progress;
    }
    
    public function getProgress(): bool
    {
        return $this->progress;
    }
    
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->setField($options['field'] ?? 'position');
        $this->setRawSql($options['rawSql'] ?? true);
    }
    
    /**
     * @return mixed
     */
    public function notify(string $type, ModelInterface $model)
    {
        if (!$this->isEnabled()) {
            return;
        }
        
        assert($model instanceof Model);
        
        $positionField = $this->getField();
        $rawSql = $this->getRawSql();
        
        switch ($type) {
            case 'beforeValidation':
                // if position field is empty, force current max(position)+1
                $lastPosition = $model::findFirst(['order' => $positionField . ' DESC']);
                if ($lastPosition && assert($lastPosition instanceof $model)) {
                    $position = (int)$lastPosition->getAttribute($positionField);
                    $model->setAttribute($positionField, $position + 1);
                }
                break;
            
            case 'afterSave':
                if (!$this->getProgress() && $model->hasSnapshotData() && $model->hasUpdated($positionField)) {
                    $this->setProgress(true);
                    
                    $snapshot = $model->getOldSnapshotData() ?: $model->getSnapshotData();
                    $modelPosition = $model->getAttribute($positionField);
                    $modelPrimaryKeys = $model->getPrimaryKeysValues();
                    
                    if (!($modelPosition instanceof RawValue)) {
                        $uField = Text::uncamelize($positionField); // @todo use columnMap
                        $updatePositionQuery = null;
                        
                        if ($snapshot[$positionField] > $modelPosition) {
                            $updatePositionQuery = $rawSql
                                ? 'UPDATE `' . $model->getSource() . '` SET `' . $uField . '` = `' . $uField . '`+1 WHERE `' . $uField . '` >= :position and `' . $uField . '` < :oldPosition and `' . $idField . '` <> :id'
                                : 'UPDATE [' . get_class($model) . '] SET [' . $positionField . '] = [' . $positionField . ']+1 WHERE [' . $positionField . '] >= ?1 and [' . $positionField . '] < ?2 and [' . $idField . '] <> ?0';
                        }
                        elseif ($snapshot[$positionField] < $modelPosition) {
                            $updatePositionQuery = $rawSql
                                ? 'UPDATE `' . $model->getSource() . '` SET `' . $uField . '` = `' . $uField . '`-1 WHERE `' . $uField . '` > :oldPosition and `' . $uField . '` <= :position and `' . $idField . '` <> :id'
                                : 'UPDATE [' . get_class($model) . '] SET [' . $positionField . '] = [' . $positionField . ']-1 WHERE [' . $positionField . '] > ?2 and [' . $positionField . '] <= ?1 and [' . $idField . '] <> ?0';
                        }
                        
                        if (!empty($updatePositionQuery)) {
                            if ($rawSql) {
                                $model->getWriteConnection()->query($updatePositionQuery, [
                                    'primaryKeys' => $modelPrimaryKeys,
                                    'position' => $modelPosition,
                                    'oldPosition' => $snapshot[$positionField],
                                ]);
                            }
                            else {
                                $model->getModelsManager()->executeQuery($updatePositionQuery, [$modelId, $modelPosition, $snapshot[$positionField]]);
                            }
                        }
                    }
                    
                    $this->setProgress(false);
                }
                break;
        }
        
        return true;
    }
}
