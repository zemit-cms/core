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
use Phalcon\Support\Collection\CollectionInterface;
use Zemit\Mvc\Model\AbstractTrait\AbstractEntity;
use Zemit\Mvc\Model\AbstractTrait\AbstractMetaData;
use Zemit\Mvc\Model\AbstractTrait\AbstractModelsManager;

/**
 * Allow to automagically save relationship
 */
trait Relationship
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
            
            // alias is not whitelisted
            if (!is_null($whiteList) && (!isset($whiteList[$alias]) && !in_array($alias, $whiteList))) {
                continue;
            }
            
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
                                    $this->setKeepMissingRelatedAlias($alias, $traversedData);
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
                                else if (is_array($traversedData) || $traversedData instanceof \Traversable) {
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
    protected function preSaveRelatedRecords(AdapterInterface $connection, $related, CollectionInterface $visited): bool
    {
        $nesting = false;
        
        $connection->begin($nesting);
        $className = get_class($this);
        
        $modelsManager = $this->getModelsManager();
        
        foreach ($related as $alias => $record) {
            $relation = $modelsManager->getRelationByAlias($className, $alias);
            
            if ($relation) {
                $type = $relation->getType();
                
                // Only belongsTo are stored before save the master record
                if ($type === Relation::BELONGS_TO) {
                    
                    // Belongs-to relation: We only support model interface
                    if (!($record instanceof ModelInterface)) {
                        $connection->rollback($nesting);
                        throw new Exception(
                            'Instance of `' . get_class($record) . '` received on model `' . $className . '` in alias `' . $alias .
                            ', expected instance of `' . ModelInterface::class . '` as part of the belongs-to relation',
                            400
                        );
                    }
                    
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
                    if ($record->getDirtyState() !== PhalconModel::DIRTY_STATE_PERSISTENT && !$record->doSave($visited)) {
                        $this->appendMessagesFromRecord($record, $alias);
                        $connection->rollback($nesting);
                        return false;
                    }
                    
                    // assign referenced value to the current model
                    foreach ($referencedFields as $key => $referencedField) {
                        $this->{$relationFields[$key]} = $record->readAttribute($referencedField);
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
    protected function postSaveRelatedRecords(AdapterInterface $connection, $related, CollectionInterface $visited): bool
    {
        $nesting = false;
        
        if ($related) {
            foreach ($related as $lowerCaseAlias => $assign) {
                
                $modelsManager = $this->getModelsManager();
                $relation = $modelsManager->getRelationByAlias(get_class($this), $lowerCaseAlias);
                
                if (!$relation) {
                    if (is_array($assign)) {
                        $connection->rollback($nesting);
                        throw new Exception("There are no defined relations for the model '" . get_class($this) . "' using alias '" . $lowerCaseAlias . "'");
                    }
                }
                
                /**
                 * Discard belongsTo relations
                 */
                if ($relation->getType() === Relation::BELONGS_TO) {
                    continue;
                }
                
                if (!is_array($assign) && !is_object($assign)) {
                    $connection->rollback($nesting);
                    throw new Exception('Only objects/arrays can be stored as part of has-many/has-one/has-one-through/has-many-to-many relations');
                }
                
                /**
                 * Custom logic for single-to-many relationships
                 */
                if ($relation->getType() === Relation::HAS_MANY) {
                    
                    // auto-delete missing related if keepMissingRelated is false
                    if (!($this->keepMissingRelated[$lowerCaseAlias] ?? true)) {
                        $originFields = $relation->getFields();
                        $originFields = is_array($originFields) ? $originFields : [$originFields];
                        
                        $referencedFields = $relation->getReferencedFields();
                        $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
                        
                        $referencedModelClass = $relation->getReferencedModel();
                        $referencedModel = $modelsManager->load($referencedModelClass);
                        
                        $referencedPrimaryKeyAttributes = $referencedModel->getModelsMetaData()->getPrimaryKeyAttributes($referencedModel);
                        $referencedBindTypes = $referencedModel->getModelsMetaData()->getBindTypes($referencedModel);
                        
                        $originBind = [];
                        foreach ($originFields as $originField) {
                            $originBind [] = $this->readAttribute($originField);
                        }
                    
                        $idBindType = count($referencedPrimaryKeyAttributes) === 1 ? $referencedBindTypes[$referencedPrimaryKeyAttributes[0]] : Column::BIND_PARAM_STR;
                        
                        $idListToKeep = [0];
                        foreach ($assign as $entity) {
                            $buildPrimaryKey = [];
                            foreach ($referencedPrimaryKeyAttributes as $referencedPrimaryKey => $referencedPrimaryKeyAttribute) {
                                $buildPrimaryKey [] = $entity->readAttribute($referencedPrimaryKeyAttribute);
                            }
                            $idListToKeep [] = implode('.', $buildPrimaryKey);
                        }
                        
                        // fetch missing related entities
                        $referencedEntityToDeleteResultset = $referencedModel::find([
                            'conditions' => implode_sprintf(array_merge($referencedFields), ' and ', '[' . $referencedModelClass . '].[%s] = ?%s') .
                            ' and concat(' . implode_sprintf($referencedPrimaryKeyAttributes, ', \'.\', ', '[' . $referencedModelClass . '].[%s]') . ') not in ({id:array})',
                            'bind' => [...$originBind, 'id' => $idListToKeep],
                            'bindTypes' => [...array_fill(0, count($referencedFields), Column::BIND_PARAM_STR), 'id' => $idBindType],
                        ]);
                        
                        // delete missing related entities
                        if (!$referencedEntityToDeleteResultset->delete()) {
                            $this->appendMessagesFromResultset($referencedEntityToDeleteResultset, $lowerCaseAlias);
                            $this->appendMessage(new Message('Unable to delete node entity `' . $referencedModelClass . '`', $lowerCaseAlias, 'Bad Request', 400));
                            $connection->rollback($nesting);
                            return false;
                        }
                    }
                }
                
                /**
                 * Custom logic for many-to-many relationships
                 */
                elseif ($relation->getType() === Relation::HAS_MANY_THROUGH) {
                    $originFields = $relation->getFields();
                    $originFields = is_array($originFields) ? $originFields : [$originFields];
                    
                    $intermediateModelClass = $relation->getIntermediateModel();
                    $intermediateModel = $modelsManager->load($intermediateModelClass);
                    
                    $intermediateFields = $relation->getIntermediateFields();
                    $intermediateFields = is_array($intermediateFields) ? $intermediateFields : [$intermediateFields];
                    
                    $intermediateReferencedFields = $relation->getIntermediateReferencedFields();
                    $intermediateReferencedFields = is_array($intermediateReferencedFields) ? $intermediateReferencedFields : [$intermediateReferencedFields];
                    
                    $referencedFields = $relation->getReferencedFields();
                    $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
                    
                    $intermediatePrimaryKeyAttributes = $intermediateModel->getModelsMetaData()->getPrimaryKeyAttributes($intermediateModel);
                    $intermediateBindTypes = $intermediateModel->getModelsMetaData()->getBindTypes($intermediateModel);
                    
                    // get current model bindings
                    $originBind = [];
                    foreach ($originFields as $originField) {
                        $originBind [] = $this->readAttribute($originField);
//                        $originBind [] = $this->{'get' . ucfirst($originField)} ?? $this->$originField ?? null;
                    }
                    
                    $nodeIdListToKeep = [];
                    foreach ($assign as $key => $entity) {
                        assert($entity instanceof ModelInterface);
                        
                        // get referenced model bindings
                        $referencedBind = [];
                        foreach ($referencedFields as $referencedField) {
                            $referencedBind [] = $entity->readAttribute($referencedField);
                        }
                        
                        $nodeEntity = $intermediateModel::findFirst([
                            'conditions' => implode_sprintf(array_merge($intermediateFields, $intermediateReferencedFields), ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s'),
                            'bind' => [...$originBind, ...$referencedBind],
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
                                    $this->appendMessagesFromRecord($nodeEntity, $lowerCaseAlias, $key);
                                    $this->appendMessage(new Message('Unable to restored previously deleted related node `' . $intermediateModelClass . '`', $lowerCaseAlias, 'Bad Request', 400));
                                    $connection->rollback($nesting);
                                    return false;
                                }
                            }
                            
                            // save edge record
                            if (!$entity->doSave($visited)) {
                                $this->appendMessagesFromRecord($entity, $lowerCaseAlias, $key);
                                $this->appendMessage(new Message('Unable to save related entity `' . $intermediateModelClass . '`', $lowerCaseAlias, 'Bad Request', 400));
                                $connection->rollback($nesting);
                                return false;
                            }
                            
                            // remove it
                            unset($assign[$key]);
                            unset($related[$lowerCaseAlias][$key]);

//                            // add to assign
//                            $nodeAssign [] = $nodeEntity;
                        }
                    }
                    
                    if (!($this->keepMissingRelated[$lowerCaseAlias] ?? true)) {
                        $idBindType = count($intermediatePrimaryKeyAttributes) === 1 ? $intermediateBindTypes[$intermediatePrimaryKeyAttributes[0]] : Column::BIND_PARAM_STR;
                        $nodeIdListToKeep = empty($nodeIdListToKeep)? [0] : array_keys(array_flip($nodeIdListToKeep));
                        $nodeEntityToDeleteResultset = $intermediateModel::find([
                            'conditions' => implode_sprintf(array_merge($intermediateFields), ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s')
                                . ' and concat(' . implode_sprintf($intermediatePrimaryKeyAttributes, ', \'.\', ', '[' . $intermediateModelClass . '].[%s]') . ') not in ({id:array})',
                            'bind' => [...$originBind, 'id' => $nodeIdListToKeep],
                            'bindTypes' => [...array_fill(0, count($intermediateFields), Column::BIND_PARAM_STR), 'id' => $idBindType],
                        ]);
                        
                        // delete missing related
                        if (!$nodeEntityToDeleteResultset->delete()) {
                            $this->appendMessagesFromResultset($nodeEntityToDeleteResultset, $lowerCaseAlias);
                            $this->appendMessage(new Message('Unable to delete node entity `' . $intermediateModelClass . '`', $lowerCaseAlias, 'Bad Request', 400));
                            $connection->rollback($nesting);
                            return false;
                        }
                    }
                }
                
                $relationFields = $relation->getFields();
                $relationFields = is_array($relationFields) ? $relationFields : [$relationFields];
                
                foreach ($relationFields as $relationField) {
                    if (!property_exists($this, $relationField)) {
                        $connection->rollback($nesting);
                        throw new Exception("The column '" . $relationField . "' needs to be present in the model");
                    }
                }
                
                $relatedRecords = $assign instanceof ModelInterface ? [$assign] : $assign;
                
                if ($this->postSaveRelatedThroughAfter($relation, $relatedRecords, $visited) === false) {
                    $this->appendMessage(new Message('Unable to save related through after', $lowerCaseAlias, 'Bad Request', 400));
                    $connection->rollback($nesting);
                    return false;
                }
                
                if ($this->postSaveRelatedRecordsAfter($relation, $relatedRecords, $visited) === false) {
                    $this->appendMessage(new Message('Unable to save related records after', $lowerCaseAlias, 'Bad Request', 400));
                    $connection->rollback($nesting);
                    return false;
                }
            }
        }
        
        /**
         * Commit the implicit transaction
         */
        $connection->commit($nesting);
        return true;
    }
    
    public function postSaveRelatedRecordsAfter(RelationInterface $relation, $relatedRecords, CollectionInterface $visited): ?bool
    {
        if ($relation->isThrough()) {
            return null;
        }
        
        $lowerCaseAlias = $relation->getOption('alias');
        
        $relationFields = $relation->getFields();
        $relationFields = is_array($relationFields) ? $relationFields : [$relationFields];
        
        $referencedFields = $relation->getReferencedFields();
        $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
        
        foreach ($relatedRecords as $recordAfter) {
//            $recordAfter->assign($relationFields);
            foreach ($relationFields as $key => $relationField) {
                $recordAfter->writeAttribute($referencedFields[$key], $this->readAttribute($relationField));
            }
            
            // Save the record and get messages
            if (!$recordAfter->doSave($visited)) {
                $this->appendMessagesFromRecord($recordAfter, $lowerCaseAlias);
                return false;
            }
        }
        
        return true;
    }
    
    public function postSaveRelatedThroughAfter(RelationInterface $relation, $relatedRecords, CollectionInterface $visited): ?bool
    {
        if (!$relation->isThrough()) {
            return null;
        }
        
        $modelsManager = $this->getModelsManager();
        $lowerCaseAlias = $relation->getOption('alias');
        
        $relationFields = $relation->getFields();
        $relationFields = is_array($relationFields) ? $relationFields : [$relationFields];
        
        $referencedFields = $relation->getReferencedFields();
        $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
        
        $intermediateModelClass = $relation->getIntermediateModel();
        
        $intermediateFields = $relation->getIntermediateFields();
        $intermediateFields = is_array($intermediateFields) ? $intermediateFields : [$intermediateFields];
        
        $intermediateReferencedFields = $relation->getIntermediateReferencedFields();
        $intermediateReferencedFields = is_array($intermediateReferencedFields) ? $intermediateReferencedFields : [$intermediateReferencedFields];
        
        foreach ($relatedRecords as $relatedAfterKey => $recordAfter) {
            // Save the record and get messages
            if (!$recordAfter->doSave($visited)) {
                $this->appendMessagesFromRecord($recordAfter, $lowerCaseAlias, $relatedAfterKey);
                return false;
            }
            
            // Create a new instance of the intermediate model
            $intermediateModel = $modelsManager->load($intermediateModelClass);
            
            /**
             *  Has-one-through relations can only use one intermediate model.
             *  If it already exists, it can be updated with the new referenced key.
             */
            if ($relation->getType() === Relation::HAS_ONE_THROUGH) {
                $bind = [];
                foreach ($relationFields as $relationField) {
                    $bind[] = $this->readAttribute($relationField);
                }
                
                $existingIntermediateModel = $intermediateModel::findFirst([
                    'conditions' => implode_sprintf($intermediateFields, ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s'),
                    'bind' => $bind,
                    'bindTypes' => array_fill(0, count($bind), Column::BIND_PARAM_STR),
                ]);
                
                if ($existingIntermediateModel) {
                    $intermediateModel = $existingIntermediateModel;
                }
            }
            
            // Set intermediate model columns values
            foreach ($relationFields as $relationFieldKey => $relationField) {
                $intermediateModel->writeAttribute($intermediateFields[$relationFieldKey], $this->readAttribute($relationField));
                $intermediateValue = $recordAfter->readAttribute($referencedFields[$relationFieldKey]);
                $intermediateModel->writeAttribute($intermediateReferencedFields[$relationFieldKey], $intermediateValue);
            }
            
            // Save the record and get messages
            if (!$intermediateModel->doSave($visited)) {
                $this->appendMessagesFromRecord($intermediateModel, $lowerCaseAlias);
                $this->appendMessage(new Message('Unable to save intermediate model `' . $intermediateModelClass . '`', $lowerCaseAlias, 'Bad Request', 400));
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
            $entity = $modelClass::findFirst([
                'conditions' => implode_sprintf($fields, ' and ', '[' . $modelClass . '].[%s] = ?%s'),
                'bind' => array_values($dataKeys),
                'bindTypes' => array_fill(0, count($dataKeys), Column::BIND_PARAM_STR),
            ]);
        }
        
        if (!$entity) {
            $entity = new $modelClass();
        }
        
        // assign new values
        // can be null to bypass, empty array for nothing or filled array
        $entity->assign($data, $whiteList[$alias] ?? null, $dataColumnMap[$alias] ?? null);
//        $entity->setDirtyState(self::DIRTY_STATE_TRANSIENT);
        
        return $entity;
    }
    
    public function appendMessages(array $messages = [], ?string $context = null, ?int $index = 0): void
    {
        foreach ($messages as $message) {
            assert($message instanceof Message);
            
            $message->setMetaData([
                'index' => $this->rebuildMessageIndex($message, $index),
                'context' => $this->rebuildMessageContext($message, $context),
            ]);
            
            $this->appendMessage($message);
        }
    }
    
    /**
     * Append a message to this model from another record,
     * also prepend a context to the previous context
     *
     * @param ResultsetInterface|ModelInterface $record
     * @param string|null $context
     */
    public function appendMessagesFromRecord($record, string $context = null, ?int $index = 0): void
    {
        if ($record) {
            $this->appendMessages($record->getMessages(), $context, $index);
        }
    }
    
    /**
     * Append a message to this model from another record,
     * also prepend a context to the previous context
     */
    public function appendMessagesFromResultset(?ResultsetInterface $resultset = null, ?string $context = null, ?int $index = 0): void
    {
        if ($resultset) {
            $this->appendMessages($resultset->getMessages(), $context, $index);
        }
    }
    
    /**
     * Append a message to this model from another record,
     * also prepend a context to the previous context
     */
    public function appendMessagesFromRecordList(?iterable $recordList = null, ?string $context = null, ?int $index = 0): void
    {
        if ($recordList) {
            foreach ($recordList as $key => $record) {
                $this->appendMessagesFromRecord($record, $context, $index . '.' . $key);
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
    public function relatedToArray(?array $columns = null, $useGetter = true): array
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
            if ($columns) {
                if (!key_exists($attributeField, $columns) && !in_array($attributeField, $columns)) {
                    continue;
                }
            }
            $relatedColumns = $columns[$attributeField] ?? null;
            
            // Run toArray on related records
            if ($related instanceof ModelInterface && method_exists($related, 'toArray')) {
                $ret[$attributeField] = $related->toArray($relatedColumns, $useGetter);
            }
            elseif (is_iterable($related)) {
                $ret[$attributeField] = [];
                foreach ($related as $entity) {
                    if ($entity instanceof ModelInterface && method_exists($entity, 'toArray')) {
                        $ret[$attributeField][] = $entity->toArray($relatedColumns, $useGetter);
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
    public function toArray($columns = null, $useGetter = true): array
    {
        return array_merge(parent::toArray($columns, $useGetter), $this->relatedToArray($columns, $useGetter));
    }
}
