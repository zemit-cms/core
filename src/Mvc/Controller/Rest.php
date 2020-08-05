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
use Phalcon\Mvc\Model\Resultset;
use League\Csv\Writer;
use Phalcon\Version;
use Zemit\Utils\Slug;

/**
 * Class Rest
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc\Controller
 */
class Rest extends \Zemit\Mvc\Controller
{
    use Model;
    
    /**
     * Rest Bootstrap
     */
    public function indexAction($id = null)
    {
        $this->restForwarding($id);
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
        }
        else if ($this->request->isDelete()) {
            $this->dispatcher->forward(['action' => 'delete']);
        }
        else if ($this->request->isGet()) {
            if (is_null($id)) {
                $this->dispatcher->forward(['action' => 'getAll']);
            }
            else {
                $this->dispatcher->forward(['action' => 'get']);
            }
        }
        else if ($this->request->isOptions()) {
            
            // @TODO handle this correctly
            return $this->setRestResponse(['result' => 'OK']);
        }
    }
    
    /**
     * Retrieving a record
     *
     * @param null $id
     *
     * @return bool|\Phalcon\Http\ResponseInterface
     */
    public function getAction($id = null)
    {
        $modelName = $this->getModelName();
        $single = $this->getSingle($id, $modelName, null);
        
        $this->view->single = $single ? $single->expose($this->getExpose()) : false;
        $this->view->model = $modelName;
        $this->view->source = $single ? $single->getSource() : false;
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
            
            return false;
        }
        
        return $this->setRestResponse();
    }
    
    /**
     * Retrieving a record list
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function getAllAction()
    {
        /** @var \Zemit\Mvc\Model $model */
        $model = $this->getModelNameFromController();
        
        /** @var Resultset $with */
        $find = $this->getFind();
//        dd($find);
        $with = $model::with($this->getWith() ? : [], $find ? : []);
//        $list = $model::find($find ? : []);
        
        /**
         * @var int $key
         * @var \Zemit\Mvc\Model $item
         */
        $list = [];
        foreach ($with as $key => $item) {
            $list[$key] = $item->expose($this->getExpose());
        }
        
        $list = is_array($list) ? array_values(array_filter($list)) : $list;
        $this->view->list = $list;
        $this->view->listCount = count($list);
        $this->view->totalCount = $model::find($this->getFindCount($find));
        $this->view->totalCount = is_int($this->view->totalCount)? $this->view->totalCount : count($this->view->totalCount); // @todo fix count to work with rollup when joins
        $this->view->limit = $find['limit'] ?? false;
        $this->view->offset = $find['offset'] ?? false;
        $this->view->find = ($this->config->app->debug || $this->config->debug->enable) ? $find : false;
        
        return $this->setRestResponse();
    }
    
    /**
     * Exporting a record list into a CSV stream
     *
     * @return \Phalcon\Http\ResponseInterface
     * @throws \League\Csv\CannotInsertRecord
     * @throws \Zemit\Exception
     */
    public function exportAction()
    {
        $response = $this->getAllAction();
        $params = $this->view->getParamsToView();
        $list = $params['list'] ?? null;
        if (isset($list[0])) {
            $csv = Writer::createFromFileObject(new \SplTempFileObject());
            $csv->setOutputBOM(Writer::BOM_UTF8);
            $csv->insertOne(array_keys($list[0]));
            $this->flatternArrayForCsv($list);
            $csv->insertAll($list);
            $csv->output(ucfirst(Slug::generate(basename(str_replace('\\', '/', $this->getModelName())))) . ' List (' . date('Y-m-d') . ').csv');
            die;
        }
        
        return $response;
    }
    
    /**
     * @param array|null $array
     *
     * @return array|null
     */
    public function flatternArrayForCsv(?array &$list = null) {
        
        foreach ($list as $listKey => $listValue) {
            foreach ($listValue as $column => $value) {
                if (is_array($value) || is_object($value)) {
                    $list[$listKey][$column] = json_encode($value);
                }
            }
        }
        
        return $list;
    }
    
    /**
     * Count a record list
     * @TODO add total count / deleted count / active count
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function countAction()
    {
        /** @var \Zemit\Mvc\Model $model */
        $model = $this->getModelNameFromController();
        $instance = new $model();
        $this->view->totalCount = $model::count($this->getFindCount($this->getFind()));
        $this->view->totalCount = is_int($this->view->totalCount)? $this->view->totalCount : count($this->view->totalCount);
        $this->view->model = get_class($instance);
        $this->view->source = $instance->getSource();
        
        return $this->setRestResponse();
    }
    
    /**
     * Prepare a new model for the frontend
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function newAction()
    {
        /** @var \Zemit\Mvc\Model $model */
        $model = $this->getModelNameFromController();
        
        $entity = new $model();
        $entity->assign($this->getParams(), $this->getWhitelist(), $this->getColumnMap());
        
        $this->view->model = get_class($entity);
        $this->view->source = $entity->getSource();
        $this->view->single = $entity->expose($this->getExpose());
        
        return $this->setRestResponse();
    }
    
    /**
     * Prepare a new model for the frontend
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function validateAction($id = null)
    {
        /** @var \Zemit\Mvc\Model $model */
        $model = $this->getModelNameFromController();
        
        /** @var \Zemit\Mvc\Model $instance */
        $entity = $this->getSingle($id);
        $new = !$entity;
        
        if ($new) {
            $entity = new $model();
        }
        
        $entity->assign($this->getParams(), $this->getWhitelist(), $this->getColumnMap());
        
        /**
         * Event to run
         * @see https://docs.phalcon.io/4.0/en/db-models-events
         */
        $events = [
            'beforeCreate' => null,
            'beforeUpdate' => null,
            'beforeSave' => null,
            'beforeValidationOnCreate' => null,
            'beforeValidationOnUpdate' => null,
            'beforeValidation' => null,
            'prepareSave' => null,
            'validation' => null,
            'afterValidationOnCreate' => null,
            'afterValidationOnUpdate' => null,
            'afterValidation' => null,
        ];
        
        // run events, as it would normally
        foreach ($events as $event => $state) {
            $this->skipped = false;
            
            // skip depending wether it's a create or update
            if (str_contains($event, $new ? 'Update' : 'Create')) {
                continue;
            }
            
            // fire the event, allowing to fail or skip
            $events[$event] = $entity->fireEventCancel($event);
            if ($events[$event] === false) {
                // event failed
                break;
            }
            
            // event was skipped, just for consistencies purpose
            if ($this->skipped) {
                continue;
            }
        }
        
        $this->view->model = get_class($entity);
        $this->view->source = $entity->getSource();
        $this->view->single = $entity->expose($this->getExpose());
        $this->view->messages = $entity->getMessages();
        $this->view->events = $events;
        $this->view->validated = empty($this->view->messages);
        
        return $this->setRestResponse($this->view->validated);
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
        $this->view->setVars($this->save($id));
        
        return $this->setRestResponse($this->view->saved);
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
        
        $this->view->deleted = $single ? $single->delete() : false;
        $this->view->single = $single ? $single->expose($this->getExpose()) : false;
        $this->view->messages = $single ? $single->getMessages() : false;
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
            
            return false;
        }
        
        return $this->setRestResponse($this->view->deleted);
    }
    
    /**
     * Restoring record
     *
     * @param null $id
     *
     * @return bool
     */
    public function restoreAction($id = null)
    {
        $single = $this->getSingle($id);
        
        $this->view->restored = $single ? $single->restore() : false;
        $this->view->single = $single ? $single->expose($this->getExpose()) : false;
        $this->view->messages = $single ? $single->getMessages() : false;
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
            
            return false;
        }
        
        return $this->setRestResponse($this->view->restored);
    }
    
    /**
     * Re-ordering a position
     *
     * @param null $id
     * @param null $position
     *
     * @return bool|\Phalcon\Http\ResponseInterface
     */
    public function reorderAction($id = null)
    {
        $single = $this->getSingle($id);
        
        $position = $this->getParam('position', 'int');
        
        $this->view->reordered = $single ? $single->reorder($position) : false;
        $this->view->single = $single ? $single->expose($this->getExpose()) : false;
        $this->view->messages = $single ? $single->getMessages() : false;
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
            
            return false;
        }
        
        return $this->setRestResponse($this->view->reordered);
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
        $debug = $this->config->app->debug ?? false;
        
        // keep forced status code or set our own
        $responseStatusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();
        $status ??= $reasonPhrase ? : 'OK';
        $code ??= (int)$responseStatusCode ? : 200;
        $view = $this->view->getParamsToView();
        $hash = hash('sha512', json_encode($view));
        
        /**
         * Debug section
         * - Versions
         * - Request
         * - Identity
         * - Profiler
         * - Dispatcher
         * - Router
         */
        $request = $debug ? $this->request->toArray() : null;
        $identity = $debug ? $this->identity->getIdentity() : null;
        $profiler = $debug && $this->profiler ? $this->profiler->toArray() : null;
        $dispatcher = $debug ? $this->dispatcher->toArray() : null;
        $router = $debug ? $this->router->toArray() : null;
        
        $api = $debug ? [
            'php' => phpversion(),
            'phalcon' => Version::get(),
            'zemit' => $this->config->core->version,
            'core' => $this->config->core->name,
            'app' => $this->config->app->version,
            'name' => $this->config->app->name,
        ] : [];
        $api['version'] = '0.1';
        
        $this->response->setStatusCode($code, $code . ' ' . $status);
        
        return $this->response->setJsonContent(array_merge([
            'api' => $api,
            'timestamp' => date('c'),
            'hash' => $hash,
            'status' => $status,
            'code' => $code,
            'response' => $response,
            'view' => $view,
        ], $debug ? [
            'identity' => $identity,
            'profiler' => $profiler,
            'request' => $request,
            'dispatcher' => $dispatcher,
            'router' => $router,
        ] : []), $jsonOptions, $depth);
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
