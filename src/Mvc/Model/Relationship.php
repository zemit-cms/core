<?php

namespace Zemit\Mvc\Model;

use Phalcon\Text;

trait Relationship {

    /**
     * Phalcon doesn't register a ResultSetInterface into a ManyToMany property
     * 
     * https://forum.phalconphp.com/discussion/2190/many-to-many-expected-behaviour
     * http://stackoverflow.com/questions/23374858/update-a-records-n-n-relationships
     * 
     * @param Phalcon\Mvc\Model\ResultSetInterface $property
     * @param type $value
     */
    public function __set($property, $value) {
        if ($value instanceof \Phalcon\Mvc\Model\ResultSetInterface) {
            $value = $value->filter(function($result) {
                return $result;
            });
        }
        parent::__set($property, $value);
    }

    public function _setDatas($datas) {
        foreach ($datas as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function save($data = null, $whiteList = null) {

        //@TODO edit whitelist to welcome the relations and their whitelists
        // get the current model manager
        $modelManager = $this->getModelsManager();

        // get the relations
        $modelRelations = $modelManager->getRelations(get_class($this));
        $manyToManyRelations = $modelManager->getHasManyToMany($this);

// if ($this->getSource() !== self::LOG_TABLE) {
//     if (method_exists($this, '_getLog')) {
//         $log = $this->_getLog()->save();
//     }
// }
$log = true; //TODO: This is a temp fix

        if (count($modelRelations) && count($manyToManyRelations)) {
            // Démarre une transaction pour être certain
            // que la suavegarde des relations fonctionne
            // pour sauvegarder les changements des relations
            $db = $this->getDI()->getDb();
            $db->begin();
            $delete = true;
        }

        //@TODO réviser ce bloque pour voir si ça fait exactement ce qu'on veut
        // get the many to many relations
        foreach ($manyToManyRelations as $manyToManyRelation) {

            // get all other relations
            foreach ($modelRelations as $modelRelation) {

                // try to match the many to many with the intermediate field of the referenced model
                if (($modelRelation->getType() === 2 && $manyToManyRelation->getType() === 4) && ($modelRelation->getReferencedModel() === $manyToManyRelation->getIntermediateModel()) && ($modelRelation->getReferencedFields() === $manyToManyRelation->getIntermediateFields())) {

                    // Many to many info
                    $options = $manyToManyRelation->getOptions();
                    $alias = isset($options['alias']) ? $options['alias'] : null;
                    $aliasModel = $manyToManyRelation->getReferencedModel();
                    $nodeModel = $manyToManyRelation->getIntermediateModel();

                    // Node relation info
                    $nodeOptions = $modelRelation->getOptions();
                    $nodeAlias = isset($nodeOptions['alias']) ? $nodeOptions['alias'] : null;

                    // get the relation fields (string|array)
                    $relationFields = $manyToManyRelation->getFields();
                    if (!is_array($relationFields)) {
                        $relationFields = array($relationFields);
                    }

                    // get the relation fields (string|array)
                    $referencedFields = $manyToManyRelation->getIntermediateReferencedFields();
                    if (!is_array($referencedFields)) {
                        $referencedFields = array($referencedFields);
                    }
    
                    $intermediateFields = $manyToManyRelation->getIntermediateFields();
                    if (!is_array($intermediateFields)) {
                        $intermediateFields = array($intermediateFields);
                    }

                    if (count($relationFields)) {
                        $relationField = array_pop($relationFields);
                        $referencedField = array_pop($referencedFields);
                        $intermediateField = array_pop($intermediateFields);

                        if ($alias) {
                            $uncamelizedAlias = Text::uncamelize($alias);
                            $lowerAlias = Text::lower($alias);

                            $aliasDatas = array();
                            if (isset($data[$alias])) {
                                $aliasDatas = $data[$alias];
                            } else if (isset($data[$lowerAlias])) {
                                $aliasDatas = $data[$lowerAlias];
                            } else if (isset($data[$uncamelizedAlias])) {
                                $aliasDatas = $data[$uncamelizedAlias];
                            }
                            
                            if (count($aliasDatas)) {
                                
                                $ids = array();
                                $subData = array();
                                $refetchIds = array();
                                if (isset($aliasDatas[0]) && (is_string($aliasDatas[0]) || is_int($aliasDatas[0]))) {
                                    $ids = is_array($aliasDatas) ? $aliasDatas : array($aliasDatas);
                                } else {
                                    foreach ($aliasDatas as $relationEntity) {
                                        if (isset($relationEntity[$relationField])) {
                                            $ids [] = $relationEntity[$relationField];
                                            $subData [$relationEntity[$relationField]] = $relationEntity;
                                        }
                                    }
                                }
                                
                                // Si aucun ID supprime tous les nodes
                                if (empty($ids)) {
                                    $delete = $this->$nodeAlias->delete();
                                } else {
                                    
                                    // Si au moins un ID passe au travers des nodes
                                    foreach ($this->$nodeAlias as $node) {
                                        
                                        // Vérifie si la relation existe toujours
                                        if (isset($node->$referencedField)) {
                                            if (!in_array($node->$referencedField, $ids, true)) {
    
                                                // La relation n'existe plus, supprimer
                                                $delete = $node->delete();
                                                if (!$delete) {
                                                    break;
                                                }
                                                
                                            // La relation existe déjà
                                            } else if (($key = array_search($node->$referencedField, $ids)) !== false) {
                                                //@TODO faire en sorte que si l'ID existe déjà, de l'updater à la place
//                                                unset($ids[$key]);
                                                $delete = $node->delete();
                                                if (!$delete) {
                                                    break;
                                                }
                                            }
                                        }
                                    }

                                    if ($delete) {
                                        // Ajoute tous les nouvelles relations pour ce type de node
                                        // @TODO faire en sorte que si aucun subData, utiliser la façon implicite de phalcon directement
//                                        $this->$alias = $aliasModel::findInById(is_array($ids) ? $ids : array($ids));
                                        
                                        $nodeAliasArray = array();
                                        foreach ($ids as $id) {
                                            if (!empty($id)) {
                                                if (!isset($subData[$id])) {
                                                    $subData[$id] = array();
                                                }
                                                unset($subData[$id][$relationField]);
                                                $subData[$id][$referencedField] = $id;
                                                $subData[$id][$intermediateField] = $this->$relationField;
                                                $nodeAliasArray[]= new $nodeModel($subData[$id]);
                                            }
                                        }
                                        $this->$nodeAlias = $nodeAliasArray;

//                                        foreach ($this->$alias as $fetchedRelation) {
//                                            $subData = isset($subData[$fetchedRelation->$relationField])? $subData[$fetchedRelation->$relationField] : null;
//                                            if ($subData) {
//                                                // @TODO test both and see if more request or not
//        //                                        $fetchedRelation->save($subData);
//                                                $fetchedRelation->_setDatas($subData);
//                                            }
//                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // if there's an active db transaction on the way
        if (isset($db) && $db) {
            
            // proceed with the normal save if the delete/save of the related entities worked
            $save = ($log && $delete) ? parent::save($data, $whiteList) : false;

            //  commit or rollback if something went wrong
            $db->{$save ? 'commit' : 'rollback'}();
            
            // return the normal parent value
            return $save;
        }

        // Sauvegarde normale sans relation
        return isset($save) ? $save : parent::save($data, $whiteList);
    }
    
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
