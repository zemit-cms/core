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
     * Get the Whitelist parameters for crud
     *
     * @return null|array
     */
    protected function getWhitelist()
    {
        return null;
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
     * Get the order definition
     *
     * @return null|array
     */
    protected function getOrder()
    {
        $filter = $this->filter;
        return array_map(function ($e) use ($filter) {
            return trim($filter->sanitize($e, 'string'));
        }, explode(',', $this->getParam('order', 'string', 'id')));
    }
    
    /**
     * Get the current limit value
     *
     * @return null|int Default: 1000
     */
    protected function getLimit() : int
    {
        return (int)$this->getParam('limit', 'int', 1000);
    }
    
    /**
     * Get the current offset value
     *
     * @return null|int Default: 0
     */
    protected function getOffset() : int
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
        return 'deleted = 0';
    }
    
    /**
     * Set the variables to bind
     *
     * @param array $bind Variable bind to merge or replace
     * @param bool $replace Pass true to replace the entire bind set
     */
    public function setBind(array $bind = [], bool $replace = false)
    {
        $this->_bind = $replace? $bind : array_merge($this->getBind(), $bind);
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
        $this->_bindTypes = $replace? $bindTypes : array_merge($this->getBindTypes(), $bindTypes);
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
     * @return null
     *
     * @param string $identityColumn
     * @param Identity|null $identity
     *
     * @return string|null
     */
    protected function getIdentityCondition($identityColumn = 'createdBy', Identity $identity = null)
    {
//        $identity ??= $this->identity ?? false;
//        if ($identity) {
//            $this->setBind([
//                'identityColumn' => $identityColumn,
//                'identityId' => [$identity->getUserId()],
//            ]);
//
//            return ':identityColumn: in ({identityIds:array})';
//        }
        
        return null;
    }
    
    /**
     * Get Filter Condition
     * @todo ask phalcon people what is the proper way to escape fields
     * @todo support betweens and order PHQL stuff
     * @todo whitelist fields to allow
     *
     * @param array|null $filters
     * @param bool $or
     *
     * @return string Return the generated query
     * @throws \Exception Throw an exception if the field property is not valid
     */
    protected function getFilterCondition(array $filters = null, $or = false)
    {
        $filters ??= $this->getParam('filters');
        
        // No filter, no query
        if (empty($filters)) {
            return null;
        }
    
        $query = [];
        foreach ($filters as $filter) {
            $field = $this->filter->sanitize($filter['field'] ?? null, ['string', 'alnum', 'trim']);
            if (!empty($field)) {
                $uniqid = substr(md5(json_encode($filter)), 0, 6);
//                $queryField = '_' . uniqid($uniqid . '_field_') . '_';
                $queryValue = '_' . uniqid($uniqid . '_value_') . '_';
                $queryOperator = strtolower($filter['operator']);
                switch ($queryOperator) {
                    case '=':
                    case '!=':
                    case '<>':
                    case '>':
                    case '<':
                    case '>=':
                    case '<=':
                    case 'in':
                    case 'between':
                    case 'not in':
                    case 'is null':
                    case 'is not null':
                    case 'is false':
                    case 'is not false':
                    case 'is true':
                    case 'is not true':
                        break;
                    default:
                        $queryOperator = '=';
                        break;
                }
                $bind = [];
                $bindType = [];
                
//                $bind[$queryField] = $filter['field'];
//                $bindType[$queryField] = Column::BIND_PARAM_STR;
//                $queryFieldBinder = ':' . $queryField . ':';
//                $queryFieldBinder = '{' . $queryField . '}';
                $queryFieldBinder = '[' . $field . ']';
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
                        $queryValueBinder = '({'.$queryValue.':array})';
                        $bindType[$queryValue] = Column::BIND_PARAM_STR;
                    }
                    else {
                        $bindType[$queryValue] = Column::BIND_PARAM_NULL;
                    }
                    $query []= "$queryFieldBinder $queryOperator $queryValueBinder";
                }
                else {
                    $query []= "$queryFieldBinder $queryOperator";
                }
    
                $this->setBind($bind);
                $this->setBindTypes($bindType);
            } else {
                if (is_array($filter) || $filter instanceof \Traversable) {
                    $query []= $this->getFilterCondition($filter, !$or);
                } else {
                    throw new \Exception('A valid field property is required.', 400);
                }
            }
        }

        return empty($query)? null : '(' . implode($or? ' or ' : ' and ' , $query) . ')';
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
     * @return string|null
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
    public function getSingle($id = null, $modelName = null, $with = [], $find = null)
    {
        $id ??= (int)$this->getParam('id', 'int');
        $modelName ??= $this->getModelName();
        $with ??= $this->getWith();
        $find ??= $this->getFind();
//        $find['conditions'] .= (empty($find['conditions'])? null : ' and ') . 'id = ' . (int)$id;
        $find['conditions'] = 'id = ' . (int)$id; // @TODO see if we should support conditions appending here or not
        
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
            
            /** @var \Zemit\Mvc\Model $singlePostEntity */
            $singlePostEntity = (!$single || !isset($entity)) ? $this->getSingle($singlePostId, $modelName) : $entity;
            
            // Create entity if not exists
            if (!$singlePostEntity) {
                $singlePostEntity = new $modelName();
            }
            
            $singlePostEntity->assign($singlePost, $whitelist, $columnMap);
            $ret['saved'] = $singlePostEntity->save();
            $ret['messages'] = $this->getRestMessages($singlePostEntity);
            $ret['model'] = get_class($singlePostEntity);
            $ret['source'] = $singlePostEntity->getSource();
            $ret[$single ? 'single' : 'list'] = $this->getSingle($singlePostEntity->getId(), $modelName, $with);
            
            $retList []= $ret;
        }
        
        return $single? $retList[0] : $retList;
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
     * @deprecated
     *
     * @param $list Resultset|\Phalcon\Mvc\Model
     *
     * @return array|bool
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
                $messages = $single instanceof Message? $list : $single->getMessages();
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
