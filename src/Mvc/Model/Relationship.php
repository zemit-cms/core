<?php

namespace Zemit\Mvc\Model;

use Exception;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\ModelInterface;
use Zemit\Utils\Sprintf;

trait Relationship
{
    protected array $_keepMissingRelated = [];
    
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
        
        /** @var Manager $modelManager */
        $modelManager = $this->getModelsManager();
        
        foreach ($data as $alias => $relationData) {
            
            /** @var \Phalcon\Mvc\Model\Relation $relation */
            $relation = $modelManager->getRelationByAlias($modelClass, $alias);
            
            // @todo add a resursive whitelist check & columnMap support
            if ($relation) {
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
                else if (is_array($relationData) || $relationData instanceof \Traversable) {
                    $assign = [];
                    
                    if (empty($relationData)) {
                        $assign = $this->_getEntityFromData($relationData, $referencedFields, $referencedModel);
                    }
                    else {
                        foreach ($relationData as $traversedKey => $traversedData) {
        
                            // Array of things
                            if (is_int($traversedKey)) {
                                $entity = null;
            
                                // Using bool as behaviour to delete missing relationship or keep them
                                // @TODO find a better way... :(
                                // if [alias => [true, ...]
                                switch ($traversedData) {
                                    case 'false':
                                        $traversedData = false;
                                        break;
                                    case 'true':
                                        $traversedData = true;
                                        break;
                                }
                                if (is_bool($traversedData)) {
                                    $this->_keepMissingRelated[$alias] = $traversedData;
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
                                else if (is_array($traversedData) || is_object($traversedData)) {
                
                                    $entity = $this->_getEntityFromData($traversedData, $referencedFields, $referencedModel);
                                }
            
                                if ($entity) {
                                    $assign [] = $entity;
                                }
                            }
        
                            // if [alias => [id => 1]]
                            else {
            
                                $assign = $this->_getEntityFromData($relationData, $referencedFields, $referencedModel);
                                break;
                            }
                        }
                    }
                }
                
                // we got something to assign
                if (!empty($assign)) {
                    $this->$alias = is_array($assign) ? array_values(array_filter($assign)) : $assign;
                }
                
            } // END RELATION
            
        } // END DATA LOOP
        
        return $this;
    }
    
    /**
     * NOTE: we need this, this behaviour only happens:
     * - in many to many nodes
     * Fix uniqueness on combined keys in node entities, and possibly more...
     * @link https://forum.phalconphp.com/discussion/2190/many-to-many-expected-behaviour
     * @link http://stackoverflow.com/questions/23374858/update-a-records-n-n-relationships
     * @link https://github.com/phalcon/cphalcon/issues/2871
     *
     * @param \Phalcon\Db\Adapter\AdapterInterface $connection
     * @param $related
     *
     * @return array|bool
     */
    protected function _prePostSaveRelatedRecords(\Phalcon\Db\Adapter\AdapterInterface $connection, $related)
    {
        
        if ($related) {
            foreach ($related as $lowerCaseAlias => $assign) {
                
                /** @var Manager $modelManager */
                $modelManager = $this->getModelsManager();
                
                /** @var Relation $relation */
                $relation = $modelManager->getRelationByAlias(get_class($this), $lowerCaseAlias);
                $alias = $relation->getOption('alias');
                
                // only many to many
                if ($relation) {
                    if ($relation->getType() === Relation::HAS_MANY_THROUGH) {
                        
                        $nodeAssign = [];
                        
                        $originFields = $relation->getFields();
                        $originFields = is_array($originFields) ? $originFields : [$originFields];
                        
                        $intermediateModelClass = $relation->getIntermediateModel();
                        $intermediateFields = $relation->getIntermediateFields();
                        $intermediateFields = is_array($intermediateFields) ? $intermediateFields : [$intermediateFields];
                        
                        $intermediateReferencedFields = $relation->getIntermediateReferencedFields();
                        $intermediateReferencedFields = is_array($intermediateReferencedFields) ? $intermediateReferencedFields : [$intermediateReferencedFields];
                        
                        $referencedFields = $relation->getReferencedFields();
                        $referencedFields = is_array($referencedFields) ? $referencedFields : [$referencedFields];
                        
                        /** @var ModelInterface $intermediate */
                        $intermediate = new $intermediateModelClass();
                        $intermediatePrimaryKey = $intermediate->getModelsMetaData()->getPrimaryKeyAttributes($intermediate);
                        $intermediateBindTypes = $intermediate->getModelsMetaData()->getBindTypes($intermediate);
                        
                        // get current model bindings
                        $originBind = [];
                        foreach ($originFields as $originField) {
                            $originBind [] = $this->{'get' . ucfirst($originField)} ?? $this->$originField;
                        }
                        
                        $nodeIdListToKeep = [];
                        foreach ($assign as $key => $entity) {
                            
                            // get referenced model bindings
                            $referencedBind = [];
                            foreach ($referencedFields as $referencedField) {
                                $referencedBind [] = $entity->{'get' . ucfirst($referencedField)} ?? $entity->$referencedField;
                            }
                            
                            /** @var ModelInterface $nodeEntity */
                            $nodeEntity = $intermediateModelClass::findFirst([
                                'conditions' => Sprintf::implodeArrayMapSprintf(array_merge($intermediateFields, $intermediateReferencedFields), ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s'),
                                'bind' => [...$originBind, ...$referencedBind],
                                'bindTypes' => array_fill(0, count($intermediateFields) + count($intermediateReferencedFields), Column::BIND_PARAM_STR),
                            ]);
                            
                            if ($nodeEntity) {
                                $nodeIdListToKeep []= $nodeEntity->{'get' . ucfirst($intermediatePrimaryKey[0])}() ?? $nodeEntity->{$intermediatePrimaryKey[0]}; // @todo fix this for combined keys,
                                
                                // Restoring node entities if previously soft deleted
                                if (method_exists($nodeEntity, 'restore')) {
                                    if (!$nodeEntity->restore()) {
                                        
                                        foreach ($entity->getMessages() as $message) {
                                            $message->setMetaData(['model' => get_class($entity)]);
                                            $this->appendMessage($message);
                                        }
                                        
                                        $connection->rollback(false);
                                        
                                        return false;
                                    }
                                }
                                
                                // save edge record
                                if (!$entity->save()) {
                                    
                                    foreach ($entity->getMessages() as $message) {
                                        $message->setMetaData(['model' => get_class($entity)]);
                                        $this->appendMessage($message);
                                    }
                                    
                                    $connection->rollback(false);
                                    
                                    return false;
                                }
                                
                                // remove it
                                unset($related[$lowerCaseAlias][$key]);
                                
                                // add to assign
                                $nodeAssign [] = $nodeEntity;
                            }
                        }
    
                        // @todo do the logic if we have more than one primary key
                        if (!($this->_keepMissingRelated[$alias] ?? true) && count($intermediatePrimaryKey) === 1) {

                            // handle if we empty the related
                            if (empty($nodeIdListToKeep)) {
                                $nodeIdListToKeep = [0];
                            }
                            
                            /** @var ModelInterface $nodeEntity */
                            // @TODO fix this to support combined primary keys
                            $nodeEntityToDeleteList = $intermediateModelClass::find([
                                'conditions' => Sprintf::implodeArrayMapSprintf(array_merge($intermediateFields), ' and ', '[' . $intermediateModelClass . '].[%s] = ?%s')
                                    . ' and ['.$intermediateModelClass.'].[' . $intermediatePrimaryKey[0] . '] not in ({id:array})',
                                'bind' => [...$originBind, 'id' => $nodeIdListToKeep],
                                'bindTypes' => [...array_fill(0, count($intermediateFields), Column::BIND_PARAM_STR), 'id' => $intermediateBindTypes[$intermediatePrimaryKey[0]]],
                            ]);
                            
                            // delete missing related
                            if (!$nodeEntityToDeleteList->delete()) {
    
                                foreach ($entity->getMessages() as $message) {
                                    $message->setMetaData(['model' => get_class($entity)]);
                                    $this->appendMessage($message);
                                }
    
                                $connection->rollback(false);
    
                                return false;
                            }
                        }
                        
                    }
                }
            }
        }
        
        // no commit here cuz parent::_postSaveRelatedRecords will fire it
        
        return [true, $connection, array_filter($related ?? [])];
    }
    
    public function _getEntityFromData(array $data, array $fields, string $modelClass): ModelInterface
    {
        $entity = null;
        
        // array_keys_exists (if $referencedFields keys exists)
        $dataKeys = array_intersect_key($data, array_flip($fields));
        
        // all keys were found
        if (count($dataKeys) === count($fields)) {
            
            /** @var ModelInterface $entity */
            $entity = $modelClass::findFirst([
                'conditions' => Sprintf::implodeArrayMapSprintf($fields, ' and ', '[' . $modelClass . '].[%s] = ?%s'),
                'bind' => array_values($dataKeys),
                'bindTypes' => array_fill(0, count($dataKeys), Column::BIND_PARAM_STR),
            ]);
        }
        
        if (!$entity) {
            /** @var ModelInterface $entity */
            $entity = new $modelClass();
        }
        
        // assign new values
        if ($entity) {
            $entity->assign($data);
        }
        
        return $entity;
    }
    
    public function assign(array $data, $whiteList = null, $dataColumnMap = null): ModelInterface
    {
        $this->assignRelated(...func_get_args());
        
        return parent::assign(...func_get_args());
    }
}
