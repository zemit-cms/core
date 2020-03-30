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

/**
 * @author Julien Turbide <Zemit@nuagerie.com>
 * @version 1.0.0
 */
class Rest extends \Phalcon\Mvc\Controller {
    
    protected $_response;
    
    use Model;
    
    public function indexAction() {
        $this->_prepareRest();
    }
    
    protected function _prepareRest() {
    
        $id = $this->_getModelIdFromPostOrParam();

        // Ajoute ou met à jour une entité
        if ($this->request->isPost() || $this->request->isPut()) {

            $this->dispatcher->forward(array(
                'action' => 'save'
            ));
        }

        // Supprime une entité
        else if ($this->request->isDelete()) {
            
            $this->dispatcher->forward(array(
                'action' => 'delete'
            ));
        }

        // Récupère une ou toute les entités
        else if ($this->request->isGet()) {

            if (is_null($id)) {
                
                $this->dispatcher->forward(array(
                    'action' => 'getAll'
                ));
            }
            else {
                
                $this->dispatcher->forward(array(
                    'action' => 'get'
                ));
            }
            
        }
        
        // @TODO voir quoi faire avec les request options
        else if ($this->request->isOptions()) {
            return $this->sendRest(array('result' => 'OK'));
        }
    }
    
    public function getAction($id = null) {
        return $this->sendRest($this->_getEntity($id));
    }
    
    public function getAllAction() {
        $model = $this->_getModelNameFromController();
        return $this->sendRest($model::find());
    }
    
    public function saveAction($id = null) {
        return $this->sendRest($this->_modelSave($id));
    }
    
    public function deleteAction($id = null) {
        $response = array();
        $entity = $this->_getEntity($id);
        $response['model'] = $entity;
        if ($entity) {
            $response['delete'] = $entity->delete();
            $response['error'] = $this->_getMessagesFromEntity($entity);
            $response['source'] = $entity->getSource();
        }
        return $this->sendRest($response);
    }
    
    protected function getParams()
    {
        // Get assoc array from json raw body
        if (!empty($this->request->getRawBody())) {
            $post = $this->request->getJsonRawBody(true);
        }
        
        // Get array from $_POST
        if (empty($post)) {
            $post = $this->request->getPost();
        }
        
        // Get array from $_REQUEST
        if (empty($post)) {
            $post = $this->request->get();
        }
        
        return $post;
    }
    
    /**
     * Set json content to response
     *
     * @param $content
     * @param array $relations
     * @param null $errors
     * @param int $offset
     * @param int $limit
     * @param string $status
     * @param int $code
     * @param int $jsonOptions
     * @param int $depth
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function sendRest($content, $relations = [], $errors = null, $offset = 0, $limit = 0, $status = 'OK', $code = 200, int $jsonOptions = 0, int $depth = 1024) {
        if (!empty($errors) && $status === 'OK' && $code === 200) {
            $status = 'Bad Request';
            $code = 400;
        }
        $response = [
            'single' => !is_countable($content) || count($content) === 1? $content : false,
            'list' => is_countable($content) && count($content) > 1? $content : false,
            'relations' => count($relations)? $relations : false,
            'errors' => $errors? $errors : false,
            'count' => is_countable($content)? count($content) : 0,
            'offset' => (int)$offset,
            'limit' => (int)$limit,
        ];
        return $this->response->setJsonContent([
            'status' => $status,
            'statusCode' => $code . ' ' . $status,
            'code' => $code,
            'params' => $this->request->get(),
            'response' => $response,
            'profiler' => $this->profiler? $this->profiler->toArray() : false,
        ], $jsonOptions, $depth);
    }
}
