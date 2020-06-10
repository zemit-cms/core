<?php

namespace Zemit\Mvc\Model;

use Exception;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Mvc\Model\Transaction;
use Phalcon\Mvc\ModelInterface;
use Zemit\Utils\Sprintf;

trait Relationship
{
    protected array $_keepMissingRelated = [];
    
    /**
     * Assign relationships
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
                    
                    foreach ($relationData as $traversedKey => $traversedData) {
                        
                        // Array of things
                        if (is_int($traversedKey)) {
                            $entity = null;
                            
                            // Using bool as behaviour to delete missing relationship or keep them
                            // @TODO find a better way... :(
                            // if [alias => [true, ...]
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
                            if (empty($idListToKeep)) {
                                $idListToKeep = [0];
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
    
//    public function save($keepMissingRelationships = true): bool
//    {
//        /** @var Transaction $connection */
//        $connection = $this->getWriteConnection();
//
//        $connection->begin();
//
//        $save = parent::save();
//
//        if ($save) {
//            $connection->commit();
//        }
//        else {
//            $connection->rollback();
//        }
//
//        return $save;
//    }
    
    /**
     * Phalcon doesn't register a ResultSetInterface into a ManyToMany property
     *
     * https://forum.phalconphp.com/discussion/2190/many-to-many-expected-behaviour
     * http://stackoverflow.com/questions/23374858/update-a-records-n-n-relationships
     *
     * @param Phalcon\Mvc\Model\ResultSetInterface $property
     * @param type $value
     */
//    public function __set($property, $value) {
//        if ($value instanceof \Phalcon\Mvc\Model\ResultSetInterface) {
//            $value = $value->filter(function($result) {
//                return $result;
//            });
//        }
//        parent::__set($property, $value);
//    }

//    public function _setDatas($datas) {
//        foreach ($datas as $key => $value) {
//            if (property_exists($this, $key)) {
//                $this->$key = $value;
//            }
//        }
//    }

//    public function save($data = null, $whiteList = null): bool
//    {
////        $this->_setDatas($data);
//
//        //@TODO edit whitelist to welcome the relations and their whitelists
//        // get the current model manager
//        $modelManager = $this->getModelsManager();
//
//        // get the relations
//        $modelRelations = $modelManager->getRelations(get_class($this));
//        $manyToManyRelations = $modelManager->getHasManyToMany($this);
//
//// if ($this->getSource() !== self::LOG_TABLE) {
////     if (method_exists($this, '_getLog')) {
////         $log = $this->_getLog()->save();
////     }
//// }
//$log = true; //TODO: This is a temp fix
//
//        if (count($modelRelations) && count($manyToManyRelations)) {
//            // Démarre une transaction pour être certain
//            // que la suavegarde des relations fonctionne
//            // pour sauvegarder les changements des relations
//            $db = $this->getDI()->getDb();
//            $db->begin();
//            $delete = true;
//        }
//
//        //@TODO réviser ce bloque pour voir si ça fait exactement ce qu'on veut
//        // get the many to many relations
//        foreach ($manyToManyRelations as $manyToManyRelation) {
//
//            // get all other relations
//            foreach ($modelRelations as $modelRelation) {
//
//                // try to match the many to many with the intermediate field of the referenced model
//                if (($modelRelation->getType() === 2 && $manyToManyRelation->getType() === 4) && ($modelRelation->getReferencedModel() === $manyToManyRelation->getIntermediateModel()) && ($modelRelation->getReferencedFields() === $manyToManyRelation->getIntermediateFields())) {
//
//                    // Many to many info
//                    $options = $manyToManyRelation->getOptions();
//                    $alias = isset($options['alias']) ? $options['alias'] : null;
//                    $aliasModel = $manyToManyRelation->getReferencedModel();
//                    $nodeModel = $manyToManyRelation->getIntermediateModel();
//
//                    // Node relation info
//                    $nodeOptions = $modelRelation->getOptions();
//                    $nodeAlias = isset($nodeOptions['alias']) ? $nodeOptions['alias'] : null;
//
//                    // get the relation fields (string|array)
//                    $relationFields = $manyToManyRelation->getFields();
//                    if (!is_array($relationFields)) {
//                        $relationFields = array($relationFields);
//                    }
//
//                    // get the relation fields (string|array)
//                    $referencedFields = $manyToManyRelation->getIntermediateReferencedFields();
//                    if (!is_array($referencedFields)) {
//                        $referencedFields = array($referencedFields);
//                    }
//
//                    $intermediateFields = $manyToManyRelation->getIntermediateFields();
//                    if (!is_array($intermediateFields)) {
//                        $intermediateFields = array($intermediateFields);
//                    }
//
//                    if (count($relationFields)) {
//                        $relationField = array_pop($relationFields);
//                        $referencedField = array_pop($referencedFields);
//                        $intermediateField = array_pop($intermediateFields);
//
//                        if ($alias) {
//                            $uncamelizedAlias = Text::uncamelize($alias);
//                            $lowerAlias = Text::lower($alias);
//
//                            $aliasDatas = array();
//                            if (isset($data[$alias])) {
//                                $aliasDatas = $data[$alias];
//                            } else if (isset($data[$lowerAlias])) {
//                                $aliasDatas = $data[$lowerAlias];
//                            } else if (isset($data[$uncamelizedAlias])) {
//                                $aliasDatas = $data[$uncamelizedAlias];
//                            }
//
//                            if (count($aliasDatas)) {
//
//                                $ids = array();
//                                $subData = array();
//                                $refetchIds = array();
//                                if (isset($aliasDatas[0]) && (is_string($aliasDatas[0]) || is_int($aliasDatas[0]))) {
//                                    $ids = is_array($aliasDatas) ? $aliasDatas : array($aliasDatas);
//                                } else {
//                                    foreach ($aliasDatas as $relationEntity) {
//                                        if (isset($relationEntity[$relationField])) {
//                                            $ids [] = $relationEntity[$relationField];
//                                            $subData [$relationEntity[$relationField]] = $relationEntity;
//                                        }
//                                    }
//                                }
//
//                                // Si aucun ID supprime tous les nodes
//                                if (empty($ids)) {
//                                    $delete = $this->$nodeAlias->delete();
//                                } else {
//
//                                    // Si au moins un ID passe au travers des nodes
//                                    foreach ($this->$nodeAlias as $node) {
//
//                                        // Vérifie si la relation existe toujours
//                                        if (isset($node->$referencedField)) {
//                                            if (!in_array($node->$referencedField, $ids, true)) {
//
//                                                // La relation n'existe plus, supprimer
//                                                $delete = $node->delete();
//                                                if (!$delete) {
//                                                    break;
//                                                }
//
//                                            // La relation existe déjà
//                                            } else if (($key = array_search($node->$referencedField, $ids)) !== false) {
//                                                //@TODO faire en sorte que si l'ID existe déjà, de l'updater à la place
////                                                unset($ids[$key]);
//                                                $delete = $node->delete();
//                                                if (!$delete) {
//                                                    break;
//                                                }
//                                            }
//                                        }
//                                    }
//
//                                    if ($delete) {
//                                        // Ajoute tous les nouvelles relations pour ce type de node
//                                        // @TODO faire en sorte que si aucun subData, utiliser la façon implicite de phalcon directement
////                                        $this->$alias = $aliasModel::findInById(is_array($ids) ? $ids : array($ids));
//
//                                        $nodeAliasArray = array();
//                                        foreach ($ids as $id) {
//                                            if (!empty($id)) {
//                                                if (!isset($subData[$id])) {
//                                                    $subData[$id] = array();
//                                                }
//                                                unset($subData[$id][$relationField]);
//                                                $subData[$id][$referencedField] = $id;
//                                                $subData[$id][$intermediateField] = $this->$relationField;
//                                                $nodeAliasArray[]= new $nodeModel($subData[$id]);
//                                            }
//                                        }
//                                        $this->$nodeAlias = $nodeAliasArray;
//
////                                        foreach ($this->$alias as $fetchedRelation) {
////                                            $subData = isset($subData[$fetchedRelation->$relationField])? $subData[$fetchedRelation->$relationField] : null;
////                                            if ($subData) {
////                                                // @TODO test both and see if more request or not
////        //                                        $fetchedRelation->save($subData);
////                                                $fetchedRelation->_setDatas($subData);
////                                            }
////                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
//
//        // if there's an active db transaction on the way
//        if (isset($db) && $db) {
//
//            // proceed with the normal save if the delete/save of the related entities worked
//            $save = ($log && $delete) ? parent::save($data, $whiteList) : false;
//
//            //  commit or rollback if something went wrong
//            $db->{$save ? 'commit' : 'rollback'}();
//
//            // return the normal parent value
//            return $save;
//        }
//
//        // Sauvegarde normale sans relation
//        return isset($save) ? $save : parent::save($data, $whiteList);
//    }

//    public function toArray($columns = null)
//    {
//        $arrData = array();
//        $reflect = new \ReflectionClass($this);
//        $props   = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
//        foreach ($props as $attribute) {
//            $attribute = trim($attribute->getName());
//            if (isset($this->$attribute) && substr($attribute, 0, 1) !== '_') {
//                $arrData[$attribute] = $this->$attribute; 
//            }
//        }
//        return $arrData;
//    }


}
