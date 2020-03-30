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

use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;

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
    protected function restForwarding($id = null)
    {
        $id ??= $this->getParam('id');
        
        if ($this->request->isPost() || $this->request->isPut()) {
            
            $this->dispatcher->forward(['action' => 'save']);
            
        } else if ($this->request->isDelete()) {
            
            $this->dispatcher->forward(['action' => 'delete']);
            
        } else if ($this->request->isGet()) {
            
            if (is_null($id)) {
                $this->dispatcher->forward(['action' => 'getAll']);
            } else {
                $this->dispatcher->forward(['action' => 'get']);
            }
            
        } // @TODO handle this correctly
        else if ($this->request->isOptions()) {
            
            return $this->setRestResponse(['result' => 'OK']);
        }
    }
    
    /**
     * Retrieving a record
     *
     * @param null $id
     *
     * @return bool
     */
    public function getAction($id = null)
    {
        $single = $this->getSingle($id);
        $this->view->single = $single;
        $this->view->model = $single ? get_class($single) : false;
        $this->view->source = $single ? $single->getSource() : false;
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
            return false;
        }
    }
    
    /**
     * Retrieving a record list
     */
    public function getAllAction()
    {
        $model = $this->getModelNameFromController();
        $this->view->list = $model::find();
        $this->view->listCount = count($this->view->list);
    }
    
    /**
     * Saving a record
     * - Create
     * - Update
     *
     * @param null $id
     *
     * @return array
     */
    public function saveAction($id = null)
    {
        return $this->saveModel($id);
    }
    
    /**
     * Deleting a record
     *
     * @param null $id
     *
     * @return bool
     */
    public function deleteAction($id = null)
    {
        $single = $this->getSingle($id);
        
        $this->view->single = $single;
        $this->view->deleted = $single ? $single->delete() : false;
        $this->view->messages = $single ? $this->getRestMessages($single) : false;
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
            return false;
        }
    }
    
    /**
     * Sending an error as an http response
     *
     * @param null $error
     * @param null $response
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function setRestErrorResponse($code = 400, $status = 'Bad Request', $response = null)
    {
        return $this->setRestResponse($response, $code, $status);
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
    public function setRestResponse($response = null, $code = null, $status = null, $jsonOptions = 0, $depth = 512)
    {
        // keep forced status code or set our own
        $responseStatusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();
        $status ??= $reasonPhrase ? : 'OK';
        $code ??= (int)$responseStatusCode ? : 200;
        
        $this->response->setStatusCode($code, $code . ' ' . $status);
        
        return $this->response->setJsonContent([
            'status' => $status,
            'statusCode' => $code . ' ' . $status,
            'code' => $code,
            'response' => $response,
            'view' => $this->view->getParamsToView(),
            'request' => $this->request->toArray(),
            'profiler' => $this->profiler ? $this->profiler->toArray() : false,
        ], $jsonOptions, $depth);
    }
    
    /**
     * Handle rest response automagically
     *
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        $response = $dispatcher->getReturnedValue();
        
        // Avoid breaking default phalcon behaviour
        if ($response instanceof Response) {
            return;
        }
        
        // Merge response into view variables
        if (is_array($response)) {
            $this->view->setVars($response, true);
        }
        
        // Return our Rest normalized response
        $dispatcher->setReturnedValue($this->setRestResponse(is_array($response) ? null : $response));
    }
}
