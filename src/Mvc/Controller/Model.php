<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Phalcon\Db\Column;
use Phalcon\Messages\Message;
use Phalcon\Messages\Messages;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Text;
use Zemit\Http\Request;
use Zemit\Identity;

trait Model
{
    protected $_model = [];
    protected $_bind = [];
    protected $_bindTypes = [];
    
    /**
     * Get the current Model Name
     *
     * @return string|null
     */
    public function getModelName()
    {
        return $this->getModelNameFromController();
    }
    
    /**
     * Get the Whitelist parameters for saving
     *
     * @return null|array
     */
    protected function getWhitelist()
    {
        return null;
    }
    
    /**
     * Get the Whitelist parameters for filtering
     *
     * @return null|array
     */
    protected function getFilterWhitelist()
    {
        return $this->getWhitelist();
    }
    
    /**
     * Get the column mapping for crud
     *
     * @return null|array
     */
    protected function getColumnMap()
    {
        return null;
    }
    
    /**
     * Get relationship eager loading definition
     *
     * @return null|array
     */
    protected function getWith()
    {
        return null;
    }
    
    /**
     * Get expose definition
     *
     * @return null|array
     */
    protected function getExpose()
    {
        return null;
    }
    
    /**
     * Get join definition
     *
     * @return null|array
     */
    protected function getJoins()
    {
        return null;
    }
    
    /**
     * Get the order definition
     *
     * @return null|array
     */
    protected function getOrder()
    {
        $filter = $this->filter;
        
        return array_map(function($e) use ($filter) {
            return trim($filter->sanitize($e, 'string'));
        }, explode(',', $this->getParam('order', 'string', '[' . $this->getModelName() . '].[id]')));
    }
    
    /**
     * Get the current limit value
     *
     * @return null|int Default: 1000
     */
    protected function getLimit(): int
    {
        return (int)$this->getParam('limit', 'int', 1000);
    }
    
    /**
     * Get the current offset value
     *
     * @return null|int Default: 0
     */
    protected function getOffset(): int
    {
        return (int)$this->getParam('offset', 'int', 0);
    }
    
    /**
     * Get group
     *
     * @return array[string]|string|null
     */
    protected function getGroup()
    {
        return $this->getParam('group', 'string');
    }
    
    /**
     * Get distinct
     * @TODO see how to implement this, maybe an action itself
     *
     * @return array[string]|string|null
     */
    protected function getDistinct()
    {
        return $this->getParam('distinct', 'string');
    }
    
    /**
     * Get columns
     * @TODO see how to implement this
     *
     * @return array[string]|string|null
     */
    protected function getColumns()
    {
        return $this->getParam('columns', 'string');
    }
    
    /**
     * Get Soft delete condition
     *
     * @return string Default: deleted = 0
     */
    protected function getSoftDeleteCondition()
    {
        return '[' . $this->getModelName() . '].[deleted] = 0';
    }
    
    /**
     * Set the variables to bind
     *
     * @param array $bind Variable bind to merge or replace
     * @param bool $replace Pass true to replace the entire bind set
     */
    public function setBind(array $bind = [], bool $replace = false)
    {
        $this->_bind = $replace ? $bind : array_merge($this->getBind(), $bind);
    }
    
    /**
     * Get the current bind
     * key => value
     *
     * @return array|null
     */
    public function getBind()
    {
        return $this->_bind ?? null;
    }
    
    /**
     * Set the variables types to bind
     *
     * @param array $bindTypes Variable bind types to merge or replace
     * @param bool $replace Pass true to replace the entire bind type set
     */
    public function setBindTypes(array $bindTypes = [], bool $replace = false)
    {
        $this->_bindTypes = $replace ? $bindTypes : array_merge($this->getBindTypes(), $bindTypes);
    }
    
    /**
     * Get the current bind types
     *
     * @return array|null
     */
    public function getBindTypes()
    {
        return $this->_bindTypes ?? null;
    }
    
    /**
     * Get Created By Condition
     *
     * @param string $identityColumn
     * @param Identity|null $identity
     * @param string[]|null $roleList
     *
     * @return null
     *
     * @return string|null
     */
    protected function getIdentityCondition(array $columns = null, Identity $identity = null, $roleList = null)
    {
        $identity ??= $this->identity ?? false;
        $roleList ??= ['dev', 'admin'];
        $modelName = $this->getModelName();
        
        if ($identity && !$identity->hasRole($roleList)) {
            $ret = [];
            
            $columns ??= [
                'createdBy',
                'ownedBy',
                'userId',
            ];
            
            foreach ($columns as $column) {
                if (!property_exists($modelName, $column)) {
                    continue;
                }
                
                $field = str_contains($column, '.')? $column : $modelName . '.' . $column;
                $field = '[' . str_replace('.', '].[', $field) . ']';
    
                $this->setBind([$column => (int)$identity->getUserId()]);
                $this->setBindTypes([$column => Column::BIND_PARAM_INT]);
                $ret []= $field . ' = :'.$column.':';
            }
            
            return implode(' or ', $ret);
        }
        
        return null;
    }
    
    /**
     * Get Filter Condition
     * @todo escape fields properly
     *
     * @param array|null $filters
     * @param array|null $whitelist
     * @param bool $or
     *
     * @return string|null Return the generated query
     * @throws \Exception Throw an exception if the field property is not valid
     */
    protected function getFilterCondition(array $filters = null, array $whitelist = null, $or = false)
    {
        $filters ??= $this->getParam('filters');
        $whitelist ??= $this->getFilterWhitelist();
        
        // No filter, no query
        if (empty($filters)) {
            return null;
        }
        
        $query = [];
        foreach ($filters as $filter) {
            $field = $this->filter->sanitize($filter['field'] ?? null, ['string', 'trim']);
            
            // whitelist on filter condition
            if (is_null($whitelist) || !in_array($field, $whitelist, true)) {
                throw new \Exception('Not allowed to filter using the following field: `'.$field.'`', 403);
                continue;
            }
            
            if (!empty($field)) {
                $uniqid = substr(md5(json_encode($filter)), 0, 6);
//                $queryField = '_' . uniqid($uniqid . '_field_') . '_';
                $queryValue = '_' . uniqid($uniqid . '_value_') . '_';
                $queryOperator = strtolower($filter['operator']);
                switch($queryOperator) {
                    case '=': // Equal operator
                    case '!=': // Not equal operator
                    case '<>': // Not equal operator
                    case '>': // Greater than operator
                    case '>=': // Greater than or equal operator
                    case '<': // Less than or equal operator
                    case '<=': // Less than or equal operator
                    case '<=>': // NULL-safe equal to operator
                    case 'in': // Whether a value is within a set of values
                    case 'not in': // Whether a value is not within a set of values
                    case 'like': // Simple pattern matching
                    case 'not like': // Negation of simple pattern matching
                    case 'between': // Whether a value is within a range of values
                    case 'not between': // Whether a value is not within a range of values
                    case 'is': // Test a value against a boolean
                    case 'is not': // Test a value against a boolean
                    case 'is null': // NULL value test
                    case 'is not null': // NOT NULL value test
                    case 'is false': // Test a value against a boolean
                    case 'is not false': // // Test a value against a boolean
                    case 'is true': // // Test a value against a boolean
                    case 'is not true': // // Test a value against a boolean
                        break;
                    default:
                        throw new \Exception('Not allowed to filter using the following operator: `'.$queryOperator.'`', 403);
                        break;
                }
                $bind = [];
                $bindType = [];

//                $bind[$queryField] = $filter['field'];
//                $bindType[$queryField] = Column::BIND_PARAM_STR;
//                $queryFieldBinder = ':' . $queryField . ':';
//                $queryFieldBinder = '{' . $queryField . '}';
                
                // Add the current model name by default
                if (!str_contains($field, '.')) {
                    $field = $this->getModelName() . '.' . $field;
                }
                
                $queryFieldBinder = '[' . str_replace('.', '].[', $field) . ']';
                $queryValueBinder = ':' . $queryValue . ':';
                if (isset($filter['value'])) {
                    $bind[$queryValue] = $filter['value'];
                    if (is_string($filter['value'])) {
                        $bindType[$queryValue] = Column::BIND_PARAM_STR;
                    }
                    else if (is_int($filter['value'])) {
                        $bindType[$queryValue] = Column::BIND_PARAM_INT;
                    }
                    else if (is_bool($filter['value'])) {
                        $bindType[$queryValue] = Column::BIND_PARAM_BOOL;
                    }
                    else if (is_float($filter['value'])) {
                        $bindType[$queryValue] = Column::BIND_PARAM_DECIMAL;
                    }
                    else if (is_double($filter['value'])) {
                        $bindType[$queryValue] = Column::BIND_PARAM_DECIMAL;
                    }
                    else if (is_array($filter['value'])) {
                        $queryValueBinder = '({' . $queryValue . ':array})';
                        $bindType[$queryValue] = Column::BIND_PARAM_STR;
                    }
                    else {
                        $bindType[$queryValue] = Column::BIND_PARAM_NULL;
                    }
                    $query [] = "$queryFieldBinder $queryOperator $queryValueBinder";
                }
                else {
                    $query [] = "$queryFieldBinder $queryOperator";
                }
                
                $this->setBind($bind);
                $this->setBindTypes($bindType);
            }
            else {
                if (is_array($filter) || $filter instanceof \Traversable) {
                    $query [] = $this->getFilterCondition($filter, $whitelist, !$or);
                }
                else {
                    throw new \Exception('A valid field property is required.', 400);
                }
            }
        }
        
        return empty($query) ? null : '(' . implode($or ? ' or ' : ' and ', $query) . ')';
    }
    
    /**
     * Get Permission Condition
     *
     * @return null
     */
    protected function getPermissionCondition($type = null, $identity = null)
    {
        return null;
    }
    
    /**
     * Get all conditions
     *
     * @return string
     * @throws \Exception
     */
    protected function getConditions()
    {
        $conditions = array_values(array_unique(array_filter([
            $this->getSoftDeleteCondition(),
            $this->getIdentityCondition(),
            $this->getFilterCondition(),
            $this->getPermissionCondition(),
        ])));
        
        return '(' . implode(') and (', $conditions) . ')';
    }
    
    /**
     * Get find definition
     *
     * @return array
     * @throws \Exception
     */
    protected function getFind()
    {
        $find = [];
        $find['conditions'] = $this->getConditions();
        $find['bind'] = $this->getBind();
        $find['bindTypes'] = $this->getBindTypes();
        $find['limit'] = $this->getLimit();
        $find['offset'] = $this->getOffset();
        $find['order'] = $this->getOrder();
        $find['columns'] = $this->getColumns();
        $find['distinct'] = $this->getDistinct();
        $find['group'] = $this->getGroup();
        $find['joins'] = $this->getJoins();
        
        return array_filter($find);
    }
    
    /**
     * Return find lazy loading config for count
     * @return array|string
     */
    protected function getFindCount($find = null)
    {
        $find ??= $this->getFind();
        if (isset($find['limit'])) {
            unset($find['limit']);
        }
        if (isset($find['offset'])) {
            unset($find['offset']);
        }
        
        return array_filter($find);
    }
    
    /**
     * @param string $key
     * @param string|null $default
     * @param array|null $params
     *
     * @return string[]|string|null
     */
    public function getParam(string $key, string $filters = null, string $default = null, array $params = null)
    {
        $params ??= $this->getParams();
        
        return $this->filter->sanitize($params[$key] ?? $this->dispatcher->getParam($key, $filters, $default), $filters);
    }
    
    /**
     * Get parameters from
     * - JsonRawBody, post, put or get
     * @return mixed
     */
    protected function getParams(array $filters = null)
    {
        /** @var Request $request */
        $request = $this->request;
        
        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $request->setParameterFilters($filter['name'], $filter['filters'], $filter['scope']);
            }
        }

//        $params = empty($request->getRawBody()) ? [] : $request->getJsonRawBody(true); // @TODO handle this differently
        return array_merge_recursive(
            $request->getFilteredQuery(), // $_GET
            $request->getFilteredPut(), // $_PUT
            $request->getFilteredPost(), // $_POST
        );
    }
    
    /**
     * Get Single from ID and Model Name
     *
     * @param string|int|null $id
     * @param string|null $modelName
     * @param string|array|null $with
     *
     * @return bool|Resultset
     */
    public function getSingle($id = null, $modelName = null, $with = [], $find = null, $appendCondition = true)
    {
        $id ??= (int)$this->getParam('id', 'int');
        $modelName ??= $this->getModelName();
        $with ??= $this->getWith();
        $find ??= $this->getFind();
        $condition = '[' . $modelName . '].[id] = ' . (int)$id;
        if ($appendCondition) {
            $find['conditions'] .= (empty($find['conditions'])? null : ' and ') . $condition;
        } else {
            $find['bind'] = [];
            $find['bindTypes'] = [];
            $find['conditions'] = $condition;
        }
        
        
        return $id ? $modelName::findFirstWith($with ?? [], $find ?? []) : false;
    }
    
    /**
     * Saving model automagically
     * @TODO Support Composite Primary Key
     *
     * @param null|int|string $id
     * @param null|\Zemit\Mvc\Model $entity
     * @param null|mixed $post
     * @param null|string $modelName
     * @param null|array $whitelist
     * @param null|array $columnMap
     * @param null|array $with
     *
     * @return array
     */
    protected function save($id = null, $entity = null, $post = null, $modelName = null, $whitelist = null, $columnMap = null, $with = null)
    {
        $single = false;
        $retList = [];
        
        // Get the model name to play with
        $modelName ??= $this->getModelName();
        $post ??= $this->getParams();
        $whitelist ??= $this->getWhitelist();
        $columnMap ??= $this->getColumnMap();
        $with ??= $this->getWith();
        
        // Check if multi-d post
        if (!empty($id) || !isset($post[0]) || !is_array($post[0])) {
            $single = true;
            $post = [$post];
        }
        
        // Save each posts
        foreach ($post as $key => $singlePost) {
            $ret = [];
            
            $singlePostId = (!$single || empty($id)) ? $this->getParam('id', 'int', null, $singlePost) : $id;
            unset($singlePost['id']);
            
            /** @var \Zemit\Mvc\Model $singlePostEntity */
            $singlePostEntity = (!$single || !isset($entity)) ? $this->getSingle($singlePostId, $modelName) : $entity;
            
            // Create entity if not exists
            if (!$singlePostEntity && empty($singlePostId)) {
                $singlePostEntity = new $modelName();
            }
            
            if (!$singlePostEntity) {
                $ret = [
                    'saved' => false,
                    'messages' => [new Message('Entity id `'.$singlePostId.'` not found.', $modelName, 'NotFound', 404)],
                    'model' => $modelName,
                    'source' => (new $modelName)->getSource(),
                ];
            }
            else {
                $singlePostEntity->assign($singlePost, $whitelist, $columnMap);
                $ret['saved'] = $singlePostEntity->save();
                $ret['messages'] = $singlePostEntity->getMessages();
                $ret['model'] = get_class($singlePostEntity);
                $ret['source'] = $singlePostEntity->getSource();
                $fetch = $this->getSingle($singlePostEntity->getId(), $modelName, $with);
                $ret[$single ? 'single' : 'list'] = $fetch? $fetch->expose($this->getExpose()) : false;
            }
            
            $retList [] = $ret;
        }
        
        return $single ? $retList[0] : $retList;
    }
    
    /**
     * Try to find the appropriate model from the current controller name
     *
     * @param string $controllerName
     * @param array $namespaces
     * @param string $needle
     *
     * @return string|null
     */
    public function getModelNameFromController(string $controllerName = null, array $namespaces = null, string $needle = 'Models'): ?string
    {
        $controllerName ??= $this->dispatcher->getControllerName();
        $namespaces ??= $this->loader->getNamespaces();
        
        $model = ucfirst(Text::camelize(Text::uncamelize($controllerName)));
        if (!class_exists($model)) {
            foreach ($namespaces as $namespace => $path) {
                $possibleModel = $namespace . '\\' . $model;
                if (strpos($namespace, $needle) !== false && class_exists($possibleModel)) {
                    $model = $possibleModel;
                }
            }
        }
        
        return class_exists($model) ? $model : null;
    }
    
    /**
     * Get message from list of entities
     *
     * @param $list Resultset|\Phalcon\Mvc\Model
     *
     * @return array|bool
     * @deprecated
     *
     */
    public function getRestMessages($list = null)
    {
        if (!is_array($list)) {
            $list = [$list];
        }
        
        $ret = [];
        
        foreach ($list as $single) {
            if ($single) {
                /** @var Messages $validations */
                $messages = $single instanceof Message ? $list : $single->getMessages();
                if ($messages && (is_array($messages) || $messages instanceof \Traversable)) {
                    foreach ($messages as $message) {
                        $validationFields = $message->getField();
                        if (!is_array($validationFields)) {
                            $validationFields = [$validationFields];
                        }
                        foreach ($validationFields as $validationField) {
                            if (empty($ret[$validationField])) {
                                $ret[$validationField] = [];
                            }
                            $ret[$validationField][] = [
                                'field' => $message->getField(),
                                'code' => $message->getCode(),
                                'type' => $message->getType(),
                                'message' => $message->getMessage(),
                                'metaData' => $message->getMetaData(),
                            ];
                        }
                    }
                }
            }
        }
        
        return $ret ? : false;
    }
}
