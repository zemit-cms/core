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

use Exception;
use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Db\Column;
use Phalcon\Messages\Message;
use Phalcon\Mvc\Model as PhalconModel;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\RelationInterface;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Zemit\Mvc\Model\AbstractTrait\AbstractEntity;
use Zemit\Mvc\Model\AbstractTrait\AbstractMetaData;
use Zemit\Mvc\Model\AbstractTrait\AbstractModelsManager;

/**
 * Allow to automagically save relationship
 */
trait Relationship2
{
    use AbstractEntity;
    use AbstractMetaData;
    use AbstractModelsManager;
    
    private array $keepMissingRelated = [];
    
    private string $relationshipContext = '';
    
    protected $dirtyRelated;
    
    /**
     * Set the missing related configuration list
     */
    public function setKeepMissingRelated(array $keepMissingRelated): void
    {
        $this->keepMissingRelated = $keepMissingRelated;
    }
    
    /**
     * Return the missing related configuration list
     */
    public function getKeepMissingRelated(): array
    {
        return $this->keepMissingRelated;
    }
    
    /**
     * Return the keepMissing configuration for a specific relationship alias
     */
    public function getKeepMissingRelatedAlias(string $alias): bool
    {
        return (bool)$this->keepMissingRelated[$alias];
    }
    
    /**
     * Set the keepMissing configuration for a specific relationship alias
     */
    public function setKeepMissingRelatedAlias(string $alias, bool $keepMissing): void
    {
        $this->keepMissingRelated[$alias] = $keepMissing;
    }
    
    /**
     * Get the current relationship context
     */
    public function getRelationshipContext(): string
    {
        return $this->relationshipContext;
    }
    
    /**
     * Set the current relationship context
     */
    public function setRelationshipContext(string $context): void
    {
        $this->relationshipContext = $context;
    }
    
    /**
     * Return the dirtyRelated entities
     */
    public function getDirtyRelated(): ?array
    {
        return $this->dirtyRelated;
    }
    
    /**
     * Set the dirtyRelated entities
     */
    public function setDirtyRelated(?array $dirtyRelated = null): void
    {
        $this->dirtyRelated = $dirtyRelated;
    }
    
    /**
     * Return the dirtyRelated entities
     */
    public function getDirtyRelatedAlias(string $alias)
    {
        return $this->dirtyRelated[$alias];
    }
    
    /**
     * Return the dirtyRelated entities
     */
    public function setDirtyRelatedAlias(string $alias, $value): void
    {
        $this->dirtyRelated[$alias] = $value;
    }
    
    /**
     * Check whether the current entity has dirty related or not
     */
    public function hasDirtyRelated(): bool
    {
        return (bool)count($this->dirtyRelated);
    }
    
    /**
     * Check whether the current entity has dirty related or not
     */
    public function hasDirtyRelatedAlias(string $alias): bool
    {
        return isset($this->dirtyRelated[$alias]);
    }
    
    /**
     * {@inheritDoc}}
     * @throws Exception
     */
    public function assign(array $data, $whiteList = null, $dataColumnMap = null): ModelInterface
    {
        $this->assignRelated(...func_get_args());
        return parent::assign(...func_get_args());
    }
    
    /**
     * Assign related
     *
     * Single
     * [alias => new Alias()] // create new alias
     *
     * Many
     * [alias => [new Alias()]] // create new alias
     * [alias => [1, 2, 3, 4]] // append / merge 1, 2, 3, 4
     * [alias => [false, 1, 2, 4]]; // delete 3
     *
     * @param array $data
     * @param null $whiteList
     * @param null $dataColumnMap
     *
     * @return $this|ModelInterface
     * @throws Exception
     */
    public function assignRelated(array $data, $whiteList = null, $dataColumnMap = null): ModelInterface
    {
        // no data, nothing to do
        if (empty($data)) {
            return $this;
        }
        
        // Get the current model class name
        $modelClass = get_class($this);
        
        $modelsManager = $this->getModelsManager();
        
        foreach ($data as $alias => $relationData) {
            
            $relation = $modelsManager->getRelationByAlias($modelClass, $alias);
            
            // @todo add a recursive whiteList check & columnMap support
            if ($relation) {
                $type = $relation->getType();
                
                $fields = $relation->getFields();
                $fields = is_array($fields) ? $fields : [$fields];
                
                $referencedFields = $relation->getReferencedFields();
                $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
                
                $referencedModel = $relation->getReferencedModel();
                $assign = null;
                
                if (is_int($relationData) || is_string($relationData)) {
                    $relationData = [$referencedFields[0] => $relationData];
                }
                
                if ($relationData instanceof ModelInterface) {
                    if ($relationData instanceof $referencedModel) {
                        $assign = $relationData;
                    }
                    else {
                        throw new Exception('Instance of `' . get_class($relationData) . '` received on model `' . $modelClass . '` in alias `' . $alias . ', expected instance of `' . $referencedModel . '`', 400);
                    }
                }
                
                // array | traversable | resultset
                elseif (is_array($relationData) || $relationData instanceof \Traversable) {
                    $assign = [];
                    $getEntityParams = [
                        'alias' => $alias,
                        'fields' => $referencedFields,
                        'modelClass' => $referencedModel,
                        'readFields' => $fields,
                        'type' => $type,
                        'whiteList' => $whiteList,
                        'dataColumnMap' => $dataColumnMap,
                    ];
                    if (empty($relationData) && !in_array($type, [Relation::HAS_MANY_THROUGH, Relation::HAS_MANY])) {
                        $assign = $this->getEntityFromData($relationData, $getEntityParams);
                    }
                    else {
                        foreach ($relationData as $traversedKey => $traversedData) {
                            // Array of things
                            if (is_int($traversedKey)) {
                                $entity = null;
                                
                                // Using bool as behaviour to delete missing relationship or keep them
                                // @TODO find a better way
                                // if [alias => [true, ...]
                                if ($traversedData === 'false') {
                                    $traversedData = false;
                                }
                                if ($traversedData === 'true') {
                                    $traversedData = true;
                                }
                                
                                if (is_bool($traversedData)) {
                                    $this->keepMissingRelated[$alias] = $traversedData;
                                    continue;
                                }
                                
                                // if [alias => [1, 2, 3, ...]]
                                if (is_int($traversedData) || is_string($traversedData)) {
                                    $traversedData = [$referencedFields[0] => $traversedData];
                                }
                                
                                // if [alias => AliasModel]
                                if ($traversedData instanceof ModelInterface) {
                                    if ($traversedData instanceof $referencedModel) {
                                        $entity = $traversedData;
                                    }
                                    else {
                                        throw new Exception('Instance of `' . get_class($traversedData) . '` received on model `' . $modelClass . '` in alias `' . $alias . ', expected instance of `' . $referencedModel . '`', 400);
                                    }
                                }
                                
                                // if [alias => [[id => 1], [id => 2], [id => 3], ....]]
                                elseif (is_iterable($traversedData)) {
                                    $entity = $this->getEntityFromData((array)$traversedData, $getEntityParams);
                                }
                                
                                if ($entity) {
                                    $assign [] = $entity;
                                }
                            }
                            
                            // if [alias => [id => 1]]
                            else {
                                $assign = $this->getEntityFromData((array)$relationData, $getEntityParams);
                                break;
                            }
                        }
                    }
                }
                
                // we got something to assign
                $keepMissingRelationship = $this->keepMissingRelated[$alias] ?? null;
                if (!empty($assign) || $keepMissingRelationship === false) {
                    $assign = is_array($assign) ? array_values(array_filter($assign)) : $assign;
                    $this->{$alias} = $assign;
                    
                    // fix to force recursive parent save from children entities within _preSaveRelatedRecords method
                    if ($this->{$alias} && $this->{$alias} instanceof ModelInterface) {
                        $this->{$alias}->setDirtyState(self::DIRTY_STATE_TRANSIENT);
                    }
                    
                    $this->dirtyRelated[mb_strtolower($alias)] = $this->{$alias} ?? false;
                    if (empty($assign)) {
                        $this->dirtyRelated[mb_strtolower($alias)] = [];
                    }
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Saves related records that must be stored prior to save the master record
     * Refactored based on the native cphalcon version, so we can support :
     * - combined keys on relationship definition
     * - relationship context within the model messages based on the alias definition
     * @throws Exception
     */
    protected function preSaveRelatedRecords(AdapterInterface $connection, $related): bool
    {
        $nesting = false;
        
        /**
         * Start an implicit transaction
         */
        $connection->begin($nesting);
        $className = get_class($this);
        
        $modelsManager = $this->getModelsManager();
        
        /**
         * @var string $alias alias
         * @var ModelInterface $record
         */
        if ($related && is_iterable($related)) {
            foreach ($related as $alias => $record) {
                
                // Try to get a relation with the same name
                $relation = $modelsManager->getRelationByAlias($className, $alias);
                
                if ($relation) {
                    $type = $relation->getType();
                    
                    // Only belongsTo are stored before save the master record
                    if ($type === Relation::BELONGS_TO) {
                        
                        // We only support model interface for the belongs-to relation
                        if (!($record instanceof ModelInterface)) {
                            $connection->rollback($nesting);
                            throw new Exception('Instance of `' . get_class($record) . '` received on model `' . $className . '` in alias `' . $alias .
                                ', expected instance of `' . ModelInterface::class . '` as part of the belongs-to relation', 400);
                        }
                        
                        // Get relationFields and referencedFields as array
                        $relationFields = $relation->getFields();
                        $relationFields = is_array($relationFields) ? $relationFields : [$relationFields];
                        
                        $referencedFields = $relation->getReferencedFields();
                        $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
                        
                        // Set the relationship context
                        // @todo review this
                        $currentRelationshipContext = $this->getRelationshipContext();
                        $relationshipPrefix = !empty($currentRelationshipContext)? $currentRelationshipContext . '.' : '';
                        $record->setRelationshipContext($relationshipPrefix . $alias);
                        
                        /**
                         * If dynamic update is enabled, saving the record must not take any action
                         * Only save if the model is dirty to prevent circular relations causing an infinite loop
                         */
                        if ($record->getDirtyState() !== PhalconModel::DIRTY_STATE_PERSISTENT && !$record->save()) {
                            $this->appendMessagesFromRecord($record, $alias);
                            $this->appendMessage(new Message('Unable to save related record', $alias, 'Bad Request', 400));
                            $connection->rollback($nesting);
                            return false;
                        }
                        
                        // Read the attributes from the referenced model and assign it to the current model
                        foreach ($referencedFields as $key => $referencedField) {
                            $this->{$relationFields[$key]} = $record->readAttribute($referencedField);
                        }
                    }
                }
            }
        }
        
        
        return true;
    }
    
    /**
     * NOTE: we need this, this behaviour only happens:
     * - in many to many nodes
     * Fix uniqueness on combined keys in node entities, and possibly more...
     * @link https://forum.phalconphp.com/discussion/2190/many-to-many-expected-behaviour
     * @link http://stackoverflow.com/questions/23374858/update-a-records-n-n-relationships
     * @link https://github.com/phalcon/cphalcon/issues/2871
     */
    protected function postSaveRelatedRecords(AdapterInterface $connection, $related = null): bool
    {
        $nesting = false;
        
        if ($related && is_iterable($related)) {
            foreach ($related as $lowerCaseAlias => $assign) {
                
                $modelsManager = $this->getModelsManager();
                $modelsMetaData = $this->getModelsMetaData();
                
                $relation = $modelsManager->getRelationByAlias(get_class($this), $lowerCaseAlias);
                
                // Append error if relation is not defined
                if (!($relation instanceof RelationInterface)) {
                    $this->appendMessage(new Message(
                        'There are no defined relations for the model `' . get_class($this) . '` using alias `' . $lowerCaseAlias . '`',
                        $lowerCaseAlias,
                        404
                    ));
                    continue;
                }
                
                // Discard belongsTo relations
                if ($relation->getType() === Relation::BELONGS_TO) {
                    continue;
                }
                
                if (!is_array($assign) && !is_object($assign)) {
                    $this->appendMessage(new Message(
                        'Only objects/arrays can be stored as part of has-many/has-one/has-one-through/has-many-to-many relations',
                        $lowerCaseAlias,
                        400
                    ));
                    continue;
                }
                
                $relationFields = $relation->getFields();
                $relationFields = is_array($relationFields) ? $relationFields : [$relationFields];
                
                // Custom logic for many-to-many relationships
                if ($relation->getType() === Relation::HAS_MANY_THROUGH) {
                    
                    $intermediateModelClass = $relation->getIntermediateModel();
                    $intermediateModel = $modelsManager->load($intermediateModelClass);
                    
                    $intermediateFields = $relation->getIntermediateFields();
                    $intermediateFields = is_array($intermediateFields) ? $intermediateFields : [$intermediateFields];
                    
                    $intermediateReferencedFields = $relation->getIntermediateReferencedFields();
                    $intermediateReferencedFields = is_array($intermediateReferencedFields) ? $intermediateReferencedFields : [$intermediateReferencedFields];
                    
                    $referencedFields = $relation->getReferencedFields();
                    $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
                    
                    $intermediatePrimaryKeyAttributes = $modelsMetaData->getPrimaryKeyAttributes($intermediateModel);
                    $intermediateBindTypes = $modelsMetaData->getBindTypes($intermediateModel);
                    
                    // get current model bindings
                    $relationBind = [];
                    foreach ($relationFields as $relationField) {
                        $relationBind [] = $this->readAttribute($relationField) ?? null;
                    }
                    
                    $nodeIdListToKeep = [];
                    foreach ($assign as $key => $entity) {
                        
                        // get referenced model bindings
                        $referencedBind = [];
                        foreach ($referencedFields as $referencedField) {
                            $referencedBind [] = $entity->readAttribute($referencedField) ?? null;
                        }
                        
                        $nodeEntity = $intermediateModel::findFirst([
                            'conditions' => implode_mb_sprintf(array_merge($intermediateFields, $intermediateReferencedFields), ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s'),
                            'bind' => [...$relationBind, ...$referencedBind],
                            'bindTypes' => array_fill(0, count($intermediateFields) + count($intermediateReferencedFields), Column::BIND_PARAM_STR),
                        ]);
                        
                        if ($nodeEntity) {
                            $buildPrimaryKey = [];
                            foreach ($intermediatePrimaryKeyAttributes as $intermediatePrimaryKey => $intermediatePrimaryKeyAttribute) {
                                $buildPrimaryKey [] = $nodeEntity->readAttribute($intermediatePrimaryKeyAttribute);
                            }
                            $nodeIdListToKeep [] = implode('.', $buildPrimaryKey);
                            
                            // Restoring node entities if previously soft deleted
                            if (method_exists($nodeEntity, 'restore') && method_exists($nodeEntity, 'isDeleted')) {
                                if ($nodeEntity->isDeleted() && !$nodeEntity->restore()) {
                                    $this->appendMessagesFromRecord($nodeEntity, $lowerCaseAlias);
                                    $this->appendMessage(new Message('Unable to restore node model `'.$intermediateModelClass.'` entity', $lowerCaseAlias . '.' . $key, 'Bad Request', 400));
                                    $connection->rollback($nesting);
                                    return false;
                                }
                            }
                            
                            // save edge record
                            if (!$entity->save()) {
                                $this->appendMessagesFromRecord($entity, $lowerCaseAlias);
                                $this->appendMessage(new Message('Unable to save entity', $lowerCaseAlias . '.' . $key, 'Bad Request', 400));
                                $connection->rollback($nesting);
                                return false;
                            }
                            
                            // remove it
                            unset($assign[$key]);
                            unset($related[$lowerCaseAlias][$key]);
                        }
                    }
                    
                    if (!($this->keepMissingRelated[$lowerCaseAlias] ?? true)) {
                        
                        // handle if we empty the related
                        if (empty($nodeIdListToKeep)) {
                            $nodeIdListToKeep = [0];
                        }
                        else {
                            $nodeIdListToKeep = array_values(array_filter(array_unique($nodeIdListToKeep)));
                        }
                        
                        $idBindType = count($intermediatePrimaryKeyAttributes) === 1 ? $intermediateBindTypes[$intermediatePrimaryKeyAttributes[0]] : Column::BIND_PARAM_STR;
                        
                        /** @var ModelInterface|string $intermediateModelClass */
                        $nodeEntityToDeleteList = $intermediateModelClass::find([
                            'conditions' => implode_mb_sprintf(array_merge($intermediateFields), ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s')
                                . ' and concat(' . implode_mb_sprintf($intermediatePrimaryKeyAttributes, ', \'.\', ', '[' . $intermediateModelClass . '].[%s]') . ') not in ({id:array})',
                            'bind' => [...$relationBind, 'id' => $nodeIdListToKeep],
                            'bindTypes' => [...array_fill(0, count($intermediateFields), Column::BIND_PARAM_STR), 'id' => $idBindType],
                        ]);
                        
                        // delete missing related
                        if (!$nodeEntityToDeleteList->delete()) {
                            $this->appendMessagesFromResultset($nodeEntityToDeleteList, $lowerCaseAlias);
                            $this->appendMessage(new Message('Unable to delete node model `' . $intermediateModelClass . '` entities', $lowerCaseAlias, 'Bad Request', 400));
                            $connection->rollback($nesting);
                            return false;
                        }
                    }
                }
                
                // Create an implicit array for has-many/has-one records
                $relatedRecords = $assign instanceof ModelInterface ? [$assign] : $assign;
                foreach ($relationFields as $relationField) {
                    if (!property_exists($this, $relationField)) {
                        $connection->rollback($nesting);
                        throw new Exception("The column '" . $relationField . "' needs to be present in the model.");
                    }
                }
                
                if ($relation->isThrough()) {
                    if (!$this->saveRelatedThrough($relatedRecords, $lowerCaseAlias, $relation)) {
                        $connection->rollback($nesting);
                        return false;
                    }
                }
                elseif (!$this->saveRelatedRecords($relatedRecords, $lowerCaseAlias, $relation)) {
                    $connection->rollback($nesting);
                    return false;
                }
            }
        }
        
        // Commit the implicit transaction
        return $connection->commit($nesting);
    }
    
    public function saveRelatedRecords(iterable $relatedRecords, string $alias, RelationInterface $relation): bool
    {
        $referencedFields = $relation->getReferencedFields();
        $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
        
        $relationFields = $relation->getFields();
        $relationFields = is_array($relationFields) ? $relationFields : [$relationFields];
        
        foreach ($relatedRecords as $recordAfterIndex => $recordAfter) {
            foreach ($relationFields as $key => $column) {
                $recordAfter->writeAttribute($referencedFields[$key], $this->readAttribute($column));
            }
            
            if (!$recordAfter->save()) {
                $this->appendMessagesFromRecord($recordAfter, $alias, $recordAfterIndex);
                $this->appendMessage(new Message('Unable to save related record', $alias . '.' . $recordAfterIndex, 'Bad Request', 400));
                return false;
            }
        }
        return true;
    }
    
    public function saveRelatedThrough(iterable $relatedRecords, string $alias, RelationInterface $relation): bool
    {
        $referencedFields = $relation->getReferencedFields();
        $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
        
        $relationFields = $relation->getFields();
        $relationFields = is_array($relationFields) ? $relationFields : [$relationFields];
        
        $intermediateModelClass = $relation->getIntermediateModel();
        
        $intermediateFields = $relation->getIntermediateFields();
        $intermediateFields = is_array($intermediateFields) ? $intermediateFields : [$intermediateFields];
        
        $intermediateReferencedFields = $relation->getIntermediateReferencedFields();
        $intermediateReferencedFields = is_array($intermediateReferencedFields) ? $intermediateReferencedFields : [$intermediateReferencedFields];
        
        foreach ($relatedRecords as $recordAfterIndex => $recordAfter) {
            
            $intermediateModel = $this->getModelsManager()->load($intermediateModelClass);
            
            if (!$recordAfter->save()) {
                $this->appendMessagesFromRecord($recordAfter, $alias, $recordAfterIndex);
                $this->appendMessage(new Message('Unable to save related record', $alias . '.' . $recordAfterIndex, 'Bad Request', 400));
                return false;
            }
            
            /**
             *  Has-one-through relations can only use one intermediate model.
             *  If it already exists, it can be updated with the new referenced key.
             */
            if ($relation->getType() === Relation::HAS_ONE_THROUGH) {
                
                $bind = [];
                foreach ($relationFields as $column) {
                    $bind[] = $this->readAttribute($column);
                }
                
                $existingIntermediateModel = $intermediateModel::findFirst([
                    'conditions' => implode_mb_sprintf($intermediateFields, ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s'),
                    'bind' => $bind,
                    'bindTypes' => array_fill(0, count($bind), Column::BIND_PARAM_STR),
                ]);
                if ($existingIntermediateModel) {
                    $intermediateModel = $existingIntermediateModel;
                }
            }
            
            foreach ($relationFields as $key => $column) {
                
                // Write value in the intermediate model
                $intermediateModel->writeAttribute($intermediateFields[$key], $this->readAttribute($column));
                
                // Get the value from the referenced model
                $intermediateValue = $recordAfter->readAttribute($referencedFields[$key]);
                
                // Write the intermediate value in the intermediate model
                $intermediateModel->writeAttribute($intermediateReferencedFields[$key], $intermediateValue);
            }
            
            // Save the record and get messages
            if (!$intermediateModel->save()) {
                $this->appendMessagesFromRecord($intermediateModel, $alias);
                $this->appendMessage(new Message('Unable to save intermediate model `'.$intermediateModelClass.'` for the related record', $alias . '.' . $recordAfterIndex, 'Bad Request', 400));
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get an entity from data
     */
    public function getEntityFromData(array $data, array $configuration = []): ModelInterface
    {
        $alias = $configuration['alias'] ?? null;
        $fields = $configuration['fields'] ?? null;
        $modelClass = $configuration['modelClass'] ?? null;
        $readFields = $configuration['readFields'] ?? null;
        $type = $configuration['type'] ?? null;
        $whiteList = $configuration['whiteList'] ?? null;
        $dataColumnMap = $configuration['dataColumnMap'] ?? null;
        
        $entity = false;
        
        if ($type === Relation::HAS_ONE || $type === Relation::BELONGS_TO) {
            
            // Set value to compare
            if (!empty($readFields)) {
                
                foreach ($readFields as $key => $field) {
                    
                    if (empty($data[$fields[$key]])) {
                        
                        // @todo maybe remove this if
                        $value = $this->readAttribute($field);
                        if (!empty($value)) {
                            
                            // @todo maybe remove this if
                            $data [$fields[$key]] = $value;
                        }
                    }
                }
            }
        }
        
        // array_keys_exists (if $referencedFields keys exists)
        $dataKeys = array_intersect_key($data, array_flip($fields));
        
        // all keys were found
        if (count($dataKeys) === count($fields)) {
            
            if ($type === Relation::HAS_MANY) {
                
                $modelsMetaData = $this->getModelsMetaData();
                $primaryKeys = $modelsMetaData->getPrimaryKeyAttributes($this);
                
                // Force primary keys for single to many
                foreach ($primaryKeys as $primaryKey) {
                    
                    if (!in_array($primaryKey, $fields, true)) {
                        $dataKeys [$primaryKey] = $data[$primaryKey] ?? null;
                        $fields [] = $primaryKey;
                    }
                }
            }
            
            /** @var ModelInterface|string $modelClass */
            $className = is_string($modelClass) ? $modelClass : get_class($modelClass);
            $entity = $modelClass::findFirst([
                'conditions' => implode_mb_sprintf($fields, ' and ', '[' . $className . '].[%s] = ?%s'),
                'bind' => array_values($dataKeys),
                'bindTypes' => array_fill(0, count($dataKeys), Column::BIND_PARAM_STR),
            ]);
        }
        
        if (!$entity) {
            $entity = new $modelClass();
        }
        
        // assign new values
        // can be null to bypass, empty array for nothing or filled array
        $assignWhiteList = isset($whiteList[$modelClass]) || isset($whiteList[$alias]);
        $assignColumnMap = isset($dataColumnMap[$modelClass]) || isset($dataColumnMap[$alias]);
        $assignWhiteList = $assignWhiteList ? array_merge_recursive($whiteList[$modelClass] ?? [], $whiteList[$alias] ?? []) : null;
        $assignColumnMap = $assignColumnMap ? array_merge_recursive($dataColumnMap[$modelClass] ?? [], $dataColumnMap[$alias] ?? []) : null;
        $entity->assign($data, $assignWhiteList, $assignColumnMap);
//        $entity->setDirtyState(self::DIRTY_STATE_TRANSIENT);
        
        return $entity;
    }
    
    /**
     * Append a message to this model from another record,
     * also prepend a context to the previous context
     */
    public function appendMessagesFromRecord(ModelInterface $record, ?string $context = null, ?int $index = 0): void
    {
        foreach ($record->getMessages() as $message) {
            
            $message->setMetaData([
                'index' => $index,
                'context' => $this->rebuildMessageContext($message, $context),
            ]);
            
            $this->appendMessage($message);
        }
    }
    
    /**
     * Append a message to this model from another record,
     * also prepend a context to the previous context
     */
    public function appendMessagesFromResultset(?ResultsetInterface $recordList = null, ?string $context = null): void
    {
        if ($recordList) {
            foreach ($recordList as $key => $record) {
                $this->appendMessagesFromRecord($record, $context, $key);
            }
        }
    }
    
    /**
     * Append a message to this model from another record,
     * also prepend a context to the previous context
     */
    public function appendMessagesFromRecordList(?iterable $recordList = null, ?string $context = null): void
    {
        if ($recordList) {
            foreach ($recordList as $key => $record) {
                $this->appendMessagesFromRecord($record, $context, $key);
            }
        }
    }
    
    /**
     * Rebuilding context for meta data
     */
    public function rebuildMessageContext(Message $message, string $context): ?string
    {
        $metaData = $message->getMetaData();
        $previousContext = $metaData['context'] ?? '';
        return $context . (empty($previousContext) ? '' : '.' . $previousContext);
    }
    
    /**
     * Rebuilding context for meta data
     */
    public function rebuildMessageIndex(Message $message, ?int $index): ?string
    {
        $metaData = $message->getMetaData();
        $previousIndex = $metaData['index'] ?? '';
        return $index . (empty($previousIndex) ? '' : '.' . $previousIndex);
    }
    
    /**
     * Return the related instances as an array representation
     */
    public function relatedToArray(?array $relationFields = null): array
    {
        $ret = [];
        
        $columnMap = $this->getModelsMetaData()->getColumnMap($this);
        
        foreach ($this->getDirtyRelated() as $attribute => $related) {
            
            // Map column if defined
            if ($columnMap && isset($columnMap[$attribute])) {
                $attributeField = $columnMap[$attribute];
            }
            else {
                $attributeField = $attribute;
            }
            
            // Skip or set the related columns
            if ($relationFields) {
                if (!key_exists($attributeField, $relationFields) && !in_array($attributeField, $relationFields)) {
                    continue;
                }
            }
            $relatedColumns = $relationFields[$attributeField] ?? null;
            
            // Run toArray on related records
            if ($related instanceof ModelInterface) {
                $ret[$attributeField] = $related->toArray($relatedColumns);
            }
            elseif (is_iterable($related)) {
                $ret[$attributeField] = [];
                foreach ($related as $entity) {
                    if ($entity instanceof ModelInterface) {
                        $ret[$attributeField][] = $entity->toArray($relatedColumns);
                    }
                    elseif (is_array($entity)) {
                        $ret[$attributeField][] = $entity;
                    }
                }
            }
            else {
                $ret[$attributeField] = null;
            }
        }
        
        return $ret;
    }
    
    /**
     * {@inheritDoc}
     */
    public function toArray($relationFields = null): array
    {
        return array_merge(parent::toArray($relationFields), $this->relatedToArray($relationFields));
    }
}
