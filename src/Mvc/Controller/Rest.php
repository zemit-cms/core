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
 * Class Rest
 * @package Zemit\Mvc\Controller
 */
class Rest extends \Phalcon\Mvc\Controller
{
    use Model;
    
    /**
     * Rest Bootstrap
     */
    public function indexAction()
    {
        $this->restForwarding();
    }
    
    /**
     * Rest bootstrap forwarding
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    protected function restForwarding()
    {
        $id = $this->getModelIdFromPostOrParam();
        
        // Ajoute ou met à jour une entité
        if ($this->request->isPost() || $this->request->isPut()) {
            
            $this->dispatcher->forward([
                'action' => 'save',
            ]);
        }
        
        // Supprime une entité
        else if ($this->request->isDelete()) {
            
            $this->dispatcher->forward([
                'action' => 'delete',
            ]);
        }
        
        // Récupère une ou toute les entités
        else if ($this->request->isGet()) {
            
            if (is_null($id)) {
                
                $this->dispatcher->forward([
                    'action' => 'getAll',
                ]);
            } else {
                
                $this->dispatcher->forward([
                    'action' => 'get',
                ]);
            }
        }
        
        // @TODO voir quoi faire avec les request options
        else if ($this->request->isOptions()) {
            return $this->sendRest(['result' => 'OK']);
        }
    }
    
    /**
     * Retrieving a record
     *
     * @param null $id
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function getAction($id = null)
    {
        $single = $this->getEntity($id);
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
        }
        
        return $this->sendRest(['single' => $single]);
    }
    
    /**
     * Retrieving a record list
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function getAllAction()
    {
        $model = $this->getModelNameFromController();
        $records = $model::find();
        
        if (empty($records)) {
            $this->response->setStatusCode(404, 'Not Found');
        }
        
        return $this->sendRest(['list' => $records]);
    }
    
    /**
     * Saving a record
     * - Create
     * - Update
     *
     * @param null $id
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function saveAction($id = null)
    {
        return $this->sendRest($this->saveModel($id));
    }
    
    /**
     * Deleting a record
     *
     * @param null $id
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function deleteAction($id = null)
    {
        $entity = $this->getEntity($id);
        if (!$entity) {
            $this->response->setStatusCode(404, 'Not Found');
        }
        
        return $this->sendRest([
            'deleted' => $entity->delete(),
            'record' => $entity,
            'error' => $this->getMessagesFromEntity($entity),
        ]);
    }
    
    /**
     * Sending an error as an http response
     *
     * @param null $error
     * @param null $response
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function sendError($code = null, $status = null, $response = null)
    {
        // keep forced status code or set our own
        $responseStatusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();
        $status ??= $reasonPhrase ?: 'Bad Request';
        $code ??= (int)$responseStatusCode ?: 400;
        
        return $this->sendRest($response, $code, $status);
    }
    
    /**
     * Sending rest response as an http response
     *
     * @param array|null $response
     * @param null $status
     * @param null $code
     * @param int $jsonOptions
     * @param int $depth
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function sendRest(array $response = null, $code = null, $status = null, $jsonOptions = 0, $depth = 512)
    {
        // keep forced status code or set our own
        $responseStatusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();
        $status ??= $reasonPhrase ?: 'OK';
        $code ??= (int)$responseStatusCode ?: 200;
        
        // default response object
        $response['deleted'] ??= false;
        $response['saved'] ??= false;
        $response['single'] ??= false;
        $response['list'] ??= false;
        $response['relations'] ??= false;
        $response['errors'] ??= false;
        $response['offset'] ??= 0;
        $response['limit'] ??= 0;
        
        $this->response->setStatusCode($code, $code . ' ' . $status);
        return $this->response->setJsonContent([
            'status' => $status,
            'statusCode' => $code . ' ' . $status,
            'code' => $code,
            'response' => $response,
            'request' => $this->request->toArray(),
            'profiler' => $this->profiler ? $this->profiler->toArray() : false,
        ], $jsonOptions, $depth);
    }
}
