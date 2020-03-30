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

use Phalcon\Mvc\Model\Resultset;
use Phalcon\Text;
use Zemit\Http\Request;

trait Model
{
    protected $_model = [];
    
    public function getModelName()
    {
        return $this->getModelNameFromController();
    }
    
    protected function getWhitelist()
    {
        return null;
    }
    
    protected function getColumnMap()
    {
        return null;
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
    protected function getParams()
    {
        /** @var Request $request */
        $request = $this->request;
        $params = empty($request->getRawBody())? [] : $request->getJsonRawBody(true);
        $params = array_merge_recursive(
            $request->get(),
            $request->getPut(),
            $request->getPost(),
            $params,
        );
        return $params;
    }
    
    /**
     * Get Single from ID and Model Name
     *
     * @param null $id
     * @param null $modelName
     *
     * @return bool|Resultset
     */
    public function getSingle($id = null, $modelName = null)
    {
        $id ??= $this->getParam('id', 'int');
        $modelName ??= $this->getModelName();
        return $id? $modelName::findFirstById((int)$id) : false;
    }
    
    /**
     * Saving model automagically
     *
     * @param null $id
     * @param null $entity
     * @param null $post
     * @param null $model
     * @param null $whitelist
     * @param null $columnMap
     *
     * @return array
     */
    protected function saveModel($id = null, $entity = null, $post = null, $model = null, $whitelist = null, $columnMap = null)
    {
        $single = false;
        $ret = [];
        
        // Get the model name to play with
        $model ??= $this->getModelName();
        $post ??= $this->getParams();
        $whitelist ??= $this->getWhitelist();
        $columnMap ??= $this->getColumnMap();
        
        // Check if multi-d post
        if (!empty($id) || !isset($post[0]) || !is_array($post[0])) {
            $single = true;
            $post = [$post];
        }
        
        // Save each posts
        foreach ($post as $key => $singlePost) {
            
            $singlePostId = (!$single || empty($id)) ? $this->getParam('id', 'int', null, $singlePost) : $id;
            $singlePostEntity = (!$single || !isset($entity)) ? $this->getSingle($singlePostId, $model) : $entity;
            
            // Create entity if not exists
            if (!$singlePostEntity) {
                $singlePostEntity = new $model();
            }
            
            $singlePostEntity->assign($singlePost, $whitelist, $columnMap);
            $ret['saved'][$key] = $singlePostEntity->save();
            $ret['messages'][$key] = $this->getRestMessages($singlePostEntity);
            $ret['model'][$key] = get_class($singlePostEntity);
            $ret['source'][$key] = $singlePostEntity->getSource();
            $ret[$single ? 'single' : 'list'][$key] = $singlePostEntity;
            
            if ($single) {
                foreach ($ret as &$retCat) {
                    $retCat = array_pop($retCat);
                }
            }
        }
        
        return $ret;
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
    public function getModelNameFromController(string $controllerName = null, array $namespaces = null, string $needle = 'Models') : ?string
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
        
        return class_exists($model)? $model : null;
    }
    
    /**
     * Get message from list of entities
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
            $validations = $single->getMessages();
            if ($validations && is_array($validations)) {
                foreach ($validations as $validation) {
                    $validationFields = $validation->getField();
                    if (!is_array($validationFields)) {
                        $validationFields = [$validationFields];
                    }
                    foreach ($validationFields as $validationField) {
                        if (empty($ret[$validationField])) {
                            $ret[$validationField] = [];
                        }
                        $ret[$validationField][] = [
                            'type' => $validation->getType(),
                            'message' => $validation->getMessage(),
                        ];
                    }
                }
            }
        }
        
        return $ret ?: false;
    }
    
}
