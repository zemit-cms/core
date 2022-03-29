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
use Phalcon\Mvc\ModelInterface;
use Phalcon\Text;
use Zemit\Http\Request;
use Zemit\Identity;
use Zemit\Mvc\Model\Expose\Expose;
use Zemit\Utils\Slug;

/**
 * Trait Model
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Controller
 */
trait Model
{
    protected $_bind = [];
    protected $_bindTypes = [];
    
    /**
     * Get the current Model Name
     * @return string|null
     * @todo remove for v1
     *
     * @deprecated change to getModelClassName() instead
     */
    public function getModelName()
    {
        return $this->getModelClassName();
    }
    
    /**
     * Get the current Model Class Name
     *
     * @return string|null
     */
    public function getModelClassName()
    {
        return $this->getModelNameFromController();
    }
    
    /**
     * Get the WhiteList parameters for saving
     * @return null|array
     * @todo add a whitelist object that would be able to support one configuration for the search, assign, filter
     *
     */
    protected function getWhiteList()
    {
        return null;
    }
    
    /**
     * Get the Flattened WhiteList
     *
     * @param array|null $whiteList
     *
     * @return array|null
     */
    public function getFlatWhiteList(?array $whiteList = null)
    {
        $whiteList ??= $this->getWhiteList();
        
        return array_keys(Expose::_parseColumnsRecursive($whiteList));
    }
    
    /**
     * Get the WhiteList parameters for filtering
     *
     * @return null|array
     */
    protected function getFilterWhiteList()
    {
        return $this->getWhiteList();
    }
    
    /**
     * Get the WhiteList parameters for filtering
     *
     * @return null|array
     */
    protected function getSearchWhiteList()
    {
        return $this->getFilterWhiteList();
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
     * Get relationship eager loading definition for a listing
     *
     * @return null|array
     */
    protected function getListWith()
    {
        return $this->getWith();
    }
    
    /**
     * Get expose definition for a single entity
     *
     * @return null|array
     */
    protected function getExpose()
    {
        return null;
    }
    
    /**
     * Get expose definition for listing many entities
     *
     * @return null|array
     */
    protected function getListExpose()
    {
        return $this->getExpose();
    }
    
    /**
     * Get expose definition for export
     *
     * @return null|array
     */
    protected function getExportExpose()
    {
        return $this->getExpose();
    }

    /**
     * Get columns merge definition for export
     *
     * @return null|array
     */
    public function getExportMergeColum ()
    {
        return null;
    }

    /**
     * Get columns format field text definition for export
     *
     * @param array|null $params
     *
     * @return null|array
     */
    public function getExportFormatFieldText (?array $params = null) {
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
        return $this->getParamExplodeArrayMapFilter('order');
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
     * - Automatically group by ID by default if nothing else is provided
     * - This will fix multiple single records being returned for the same model with joins
     *
     * @return array[string]|string|null
     */
    protected function getGroup()
    {
        $group = $this->getParamExplodeArrayMapFilter('group');
        
        // Fix for joins, automatically append grouping if none provided
        $join = $this->getJoins();
        if (empty($group) && !empty($join)) {
            $group = $this->appendModelName('id');
        }
        
        return $group;
    }
    
    /**
     * Get distinct
     * @TODO see how to implement this, maybe an action itself
     *
     * @return array[string]|string|null
     */
    protected function getDistinct()
    {
        return $this->getParamExplodeArrayMapFilter('distinct');
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
     * Return the whitelisted role list for the current model
     *
     * @return string[] By default will return dev and admin role
     */
    protected function getRoleList() {
        return ['dev', 'admin'];
    }
    
    /**
     * Get Search condition
     *
     * @return string Default: deleted = 0
     */
    protected function getSearchCondition()
    {
        $conditions = [];
        
        $searchList = array_values(array_filter(array_unique(explode(' ', $this->getParam('search', 'string')))));
        
        foreach ($searchList as $searchTerm) {
            $orConditions = [];
            $searchWhiteList = $this->getSearchWhiteList();
            if ($searchWhiteList) {
                foreach ($searchWhiteList as $whiteList) {
                    
                    // Multidimensional arrays not supported yet
                    // @todo support this properly
                    if (is_array($whiteList)) {
                        continue;
                    }
                    
                    $searchTermBinding = '_' . uniqid() . '_';
                    $orConditions [] = $this->appendModelName($whiteList) . " like :$searchTermBinding:";
                    $this->setBind([$searchTermBinding => '%' . $searchTerm . '%']);
                    $this->setBindTypes([$searchTermBinding => Column::BIND_PARAM_STR]);
                }
            }
            
            if (!empty($orConditions)) {
                $conditions [] = '(' . implode(' or ', $orConditions) . ')';
            }
        }
        
        return empty($conditions) ? null : '(' . implode(' and ', $conditions) . ')';
    }
    
    /**
     * Get Soft delete condition
     *
     * @return string Default: deleted = 0
     */
    protected function getSoftDeleteCondition(): ?string
    {
        return '[' . $this->getModelClassName() . '].[deleted] = 0';
    }
    
    /**
     * @param $field
     * @param string $sanitizer
     * @param string $glue
     *
     * @return array|string[]
     */
    public function getParamExplodeArrayMapFilter($field, $sanitizer = 'string', $glue = ',')
    {
        $filter = $this->filter;
        $ret = array_filter(array_map(function($e) use ($filter, $sanitizer) {
            return $this->appendModelName(trim($filter->sanitize($e, $sanitizer)));
        }, explode($glue, $this->getParam($field, $sanitizer))));
        
        return empty($ret) ? null : $ret;
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
     * @param string[] $columns
     * @param Identity|null $identity
     * @param string[]|null $roleList
     *
     * @return null
     *
     * @return string|null
     */
    protected function getIdentityCondition(array $columns = null, Identity $identity = null, $roleList = null)
    {
        // @todo
        if ($this->request->isOptions()){
            return null;
        }
        
        $identity ??= $this->identity ?? false;
        $roleList ??= $this->getRoleList();
        $modelName = $this->getModelClassName();
        
        if ($modelName && $identity && !$identity->hasRole($roleList)) {
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
                
                $field = strpos($column, '.') !== false ? $column : $modelName . '.' . $column;
                $field = '[' . str_replace('.', '].[', $field) . ']';
                
                $this->setBind([$column => (int)$identity->getUserId()]);
                $this->setBindTypes([$column => Column::BIND_PARAM_INT]);
                $ret [] = $field . ' = :' . $column . ':';
            }
            
            return implode(' or ', $ret);
        }
        
        return null;
    }
    
    function arrayMapRecursive($callback, $array)
    {
        $func = function($item) use (&$func, &$callback) {
            return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
        };
        
        return array_map($func, $array);
    }
    
    /**
     * Get Filter Condition
     *
     * @param array|null $filters
     * @param array|null $whiteList
     * @param bool $or
     *
     * @return string|null Return the generated query
     * @throws \Exception Throw an exception if the field property is not valid
     * @todo escape fields properly
     *
     */
    protected function getFilterCondition(array $filters = null, array $whiteList = null, $or = false)
    {
        $filters ??= $this->getParam('filters');
        $whiteList ??= $this->getFilterWhiteList();
        $whiteList = $this->getFlatWhiteList($whiteList);
        $lowercaseWhiteList = !is_null($whiteList) ? $this->arrayMapRecursive('mb_strtolower', $whiteList) : $whiteList;
        
        // No filter, no query
        if (empty($filters)) {
            return null;
        }
        
        $query = [];
        foreach ($filters as $filter) {
            $field = $this->filter->sanitize($filter['field'] ?? null, ['string', 'trim']);
            
            if (!empty($field)) {
                $lowercaseField = mb_strtolower($field);
                
                // whiteList on filter condition
                if (is_null($whiteList) || !in_array($lowercaseField, $lowercaseWhiteList, true)) {
                    // @todo if config is set to throw exception on usage of not allowed filters otherwise continue looping through
                    throw new \Exception('Not allowed to filter using the following field: `' . $field . '`', 403);
                    continue;
                }
                
                $uniqid = substr(md5(json_encode($filter)), 0, 10);
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
                        throw new \Exception('Not allowed to filter using the following operator: `' . $queryOperator . '`', 403);
                        break;
                }
                
                $bind = [];
                $bindType = [];

//                $bind[$queryField] = $filter['field'];
//                $bindType[$queryField] = Column::BIND_PARAM_STR;
//                $queryFieldBinder = ':' . $queryField . ':';
//                $queryFieldBinder = '{' . $queryField . '}';
                
                // Add the current model name by default
                $field = $this->appendModelName($field);
                
                $queryFieldBinder = $field;
                $queryValueBinder = ':' . $queryValue . ':';
                if (isset($filter['value'])) {
                    // special for between and not between
                    if (in_array($queryOperator, ['between', 'not between'])) {
                        $queryValue0 = '_' . uniqid($uniqid . '_value_') . '_';
                        $queryValue1 = '_' . uniqid($uniqid . '_value_') . '_';
                        $bind[$queryValue0] = $filter['value'][0];
                        $bind[$queryValue1] = $filter['value'][1];
                        $bindType[$queryValue0] = Column::BIND_PARAM_STR;
                        $bindType[$queryValue1] = Column::BIND_PARAM_STR;
                        $query [] = (($queryOperator === 'not between')? 'not ' : null) . "$queryFieldBinder between :$queryValue0: and :$queryValue1:";
                    }
                    else {
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
                }
                else {
                    $query [] = "$queryFieldBinder $queryOperator";
                }
                
                $this->setBind($bind);
                $this->setBindTypes($bindType);
            }
            else {
                if (is_array($filter) || $filter instanceof \Traversable) {
                    $query [] = $this->getFilterCondition($filter, $whiteList, !$or);
                }
                else {
                    throw new \Exception('A valid field property is required.', 400);
                }
            }
        }
        
        return empty($query) ? null : '(' . implode($or ? ' or ' : ' and ', $query) . ')';
    }
    
    /**
     * Append the current model name alias to the field
     * So: field -> [Alias].[field]
     *
     * @param string|array $field
     * @param null $modelName
     *
     * @return array|string
     */
    public function appendModelName($field, $modelName = null)
    {
        $modelName ??= $this->getModelClassName();
        
        if (empty($field)) {
            return $field;
        }
        
        if (is_string($field)) {
            // Add the current model name by default
            $explode = explode(' ', $field);
            if (!strpos($field, '.') !== false) {
                $field = trim('[' . $modelName . '].[' . array_shift($explode) . '] ' . implode(' ', $explode));
            }
            else if (strpos($field, ']') === false && strpos($field, '[') === false) {
                $field = trim('[' . implode('].[', explode('.', array_shift($explode))) . ']' . implode(' ', $explode));
            }
        }
        else if (is_array($field)) {
            foreach ($field as $fieldKey => $fieldValue) {
                $field[$fieldKey] = $this->appendModelName($fieldValue, $modelName);
            }
        }
        
        return $field;
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
    
    protected function fireGet($method) {
        $ret = $this->{$method}();
        $eventRet = $this->eventsManager->fire('rest:' . $method, $this, $ret);
        return $eventRet === false? null : $eventRet ?? $ret;
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
            $this->fireGet('getSoftDeleteCondition'),
            $this->fireGet('getIdentityCondition'),
            $this->fireGet('getFilterCondition'),
            $this->fireGet('getSearchCondition'),
            $this->fireGet('getPermissionCondition'),
        ])));
        
        if (empty($conditions)) {
            $conditions []= 1;
        }
        
        return '(' . implode(') and (', $conditions) . ')';
    }
    
    /**
     * Get having conditions
     */
    public function getHaving()
    {
        return null;
    }
    
    /**
     * Get a cache key from params
     *
     * @param array|null $params
     *
     * @return string|null
     */
    public function getCacheKey(?array $params = null): ?string
    {
        $params ??= $this->getParams();
        
        return Slug::generate(json_encode($params, JSON_UNESCAPED_SLASHES));
    }
    
    /**
     * Get cache setting
     *
     * @param array|null $params
     *
     * @return array|null
     */
    public function getCache(?array $params = null)
    {
        $params ??= $this->getParams();
        
        if (!empty($params['cache'])) {
            return [
                'lifetime' => (int)$params['cache'],
                'key' => $this->getCacheKey($params),
            ];
        }
        
        return null;
    }
    
    
    /**
     * Get requested content type
     * - Default will return csv
     *
     * @param array|null $params
     *
     * @return string
     * @throws \Exception
     */
    public function getContentType(?array $params = null)
    {
        $params ??= $this->getParams();
        
        $contentType = strtolower($params['contentType'] ?? $params['content-type'] ?? 'json');
        
        switch($contentType) {
            case 'html':
            case 'text/html':
            case 'application/html':
                // html not supported yet
                break;
            case 'xml':
            case 'text/xml':
            case 'application/xml':
                // xml not supported yet
                break;
            case 'text':
            case 'text/plain':
                // plain text not supported yet
                break;
            case 'json':
            case 'text/json':
            case 'application/json':
                return 'json';
            case 'csv':
            case 'text/csv':
                return 'csv';
            case 'xlsx':
            case 'application/xlsx':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return 'xlsx';
            case 'xls':
            case 'application/vnd.ms-excel':
                // old xls not supported yet
                break;
        }
        
        throw new \Exception('`' . $contentType . '` is not supported.', 400);
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
        $find['conditions'] = $this->fireGet('getConditions');
        $find['bind'] = $this->fireGet('getBind');
        $find['bindTypes'] = $this->fireGet('getBindTypes');
        $find['limit'] = $this->fireGet('getLimit');
        $find['offset'] = $this->fireGet('getOffset');
        $find['order'] = $this->fireGet('getOrder');
        $find['columns'] = $this->fireGet('getColumns');
        $find['distinct'] = $this->fireGet('getDistinct');
        $find['joins'] = $this->fireGet('getJoins');
        $find['group'] = $this->fireGet('getGroup');
        $find['having'] = $this->fireGet('getHaving');
        $find['cache'] = $this->fireGet('getCache');
        
        // fix for grouping by multiple fields, phalcon only allow string here
        foreach (['distinct', 'group'] as $findKey) {
            if (isset($find[$findKey]) && is_array($find[$findKey])) {
                $find[$findKey] = implode(', ', $find[$findKey]);
            }
        }
        
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
//        if (isset($find['group'])) {
//            unset($find['group']);
//        }
        
        return array_filter($find);
    }
    
    /**
     * @param string $key
     * @param string[]|string|null $filters
     * @param string|null $default
     * @param array|null $params
     *
     * @return string[]|string|null
     */
    public function getParam(string $key, $filters = null, string $default = null, array $params = null)
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
        $modelName ??= $this->getModelClassName();
        $with ??= $this->getWith();
        $find ??= $this->getFind();
        $condition = '[' . $modelName . '].[id] = ' . (int)$id;
        if ($appendCondition) {
            $find['conditions'] .= (empty($find['conditions']) ? null : ' and ') . $condition;
        }
        else {
            $find['bind'] = [];
            $find['bindTypes'] = [];
            $find['conditions'] = $condition;
        }
        
        return $id ? $modelName::findFirstWith($with ?? [], $find ?? []) : false;
    }
    
    /**
     * Saving model automagically
     *
     * Note:
     * If a newly created entity can't be retrieved using the ->getSingle
     * method after it's creation, the entity will be returned directly
     *
     * @TODO Support Composite Primary Key
     *
     * @param null|int|string $id
     * @param null|\Zemit\Mvc\Model $entity
     * @param null|mixed $post
     * @param null|string $modelName
     * @param null|array $whiteList
     * @param null|array $columnMap
     * @param null|array $with
     *
     * @return array
     */
    protected function save($id = null, $entity = null, $post = null, $modelName = null, $whiteList = null, $columnMap = null, $with = null)
    {
        $single = false;
        $retList = [];
        
        // Get the model name to play with
        $modelName ??= $this->getModelClassName();
        $post ??= $this->getParams();
        $whiteList ??= $this->getWhiteList();
        $columnMap ??= $this->getColumnMap();
        $with ??= $this->getWith();
        $id = (int)$id;
        
        // Check if multi-d post
        if (!empty($id) || !isset($post[0]) || !is_array($post[0])) {
            $single = true;
            $post = [$post];
        }
        
        // Save each posts
        foreach ($post as $key => $singlePost) {
            $ret = [];
            
            // @todo see if we should remove this earlier
            if (isset($singlePost['_url'])) {
                unset($singlePost['_url']);
            }
            
            $singlePostId = (!$single || empty($id)) ? $this->getParam('id', 'int', $this->getParam('int', 'int', null)) : $id;
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
                    'messages' => [new Message('Entity id `' . $singlePostId . '` not found.', $modelName, 'NotFound', 404)],
                    'model' => $modelName,
                    'source' => (new $modelName)->getSource(),
                ];
            }
            else {
                // assign & save
                $singlePostEntity->assign($singlePost, $whiteList, $columnMap);
                $ret = $this->saveEntity($singlePostEntity);
                
                // refetch & expose
                $fetch = $this->getSingle($singlePostEntity->getId(), $modelName, $with);
                $ret[$single ? 'single' : 'list'] = $fetch ? $fetch->expose($this->getExpose()) : false;
            }
            
            $retList [] = $ret;
        }
        
        return $single ? $retList[0] : $retList;
    }
    
    /**
     * @param $single
     *
     * @return void
     */
    protected function saveEntity($entity) : array
    {
        $ret = [];
        $ret['saved'] = $entity->save();
        $ret['messages'] = $entity->getMessages();
        $ret['model'] = get_class($entity);
        $ret['source'] = $entity->getSource();
        $ret['entity'] = $entity->expose($this->getExpose());
        return $ret;
    }
    
    /**
     * Try to find the appropriate model from the current controller name
     *
     * @param ?string $controllerName
     * @param ?array $namespaces
     * @param string $needle
     *
     * @return string|null
     */
    public function getModelNameFromController(string $controllerName = null, array $namespaces = null, string $needle = 'Models'): ?string
    {
        $controllerName ??= $this->dispatcher->getControllerName() ?? '';
        $namespaces ??= $this->loader->getNamespaces() ?? [];
        
        $model = ucfirst(Text::camelize(Text::uncamelize($controllerName)));
        if (!class_exists($model)) {
            foreach ($namespaces as $namespace => $path) {
                $possibleModel = $namespace . '\\' . $model;
                if (strpos($namespace, $needle) !== false && class_exists($possibleModel)) {
                    $model = $possibleModel;
                }
            }
        }
        
        return class_exists($model) && new $model() instanceof ModelInterface ? $model : null;
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
