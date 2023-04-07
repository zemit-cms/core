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

use League\Csv\CharsetConverter;
use League\Csv\Writer;
use Phalcon\Events\Manager;
use Phalcon\Exception;
use Phalcon\Http\Response;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Version;
use Zemit\Di\Injectable;
use Zemit\Http\StatusCode;
use Zemit\Utils;
use Zemit\Utils\Slug;

class Rest extends \Zemit\Mvc\Controller
{
    use Model;
    
    /**
     * @throws Exception
     */
    public function indexAction(?int $id = null)
    {
        $this->restForwarding($id);
    }
    
    /**
     * Rest bootstrap forwarding
     * @throws Exception
     */
    protected function restForwarding(?int $id = null): void
    {
        $id ??= $this->getParam('id');
        if ($this->request->isPost() || $this->request->isPut() || $this->request->isPatch()) {
            $this->dispatcher->forward(['action' => 'save']);
        }
        elseif ($this->request->isDelete()) {
            $this->dispatcher->forward(['action' => 'delete']);
        }
        elseif ($this->request->isGet()) {
            if (is_null($id)) {
                $this->dispatcher->forward(['action' => 'getList']);
            }
            else {
                $this->dispatcher->forward(['action' => 'get']);
            }
        }
    }
    
    /**
     * Retrieving a single record
     * Alias of method getAction()
     *
     * @param null $id
     * @return bool|ResponseInterface
     * @deprecated Should use getAction() method instead
     */
    public function getSingleAction($id = null)
    {
        return $this->getAction($id);
    }
    
    /**
     * Retrieving a single record
     *
     * @param null $id
     *
     * @return bool|ResponseInterface
     */
    public function getAction($id = null)
    {
        $modelName = $this->getModelClassName();
        $single = $this->getSingle($id, $modelName, null);
        
        $ret = [];
        $ret['single'] = $single ? $this->expose($single) : false;
        $ret['model'] = $modelName;
        $ret['source'] = $single ? $single->getSource() : false;
        $this->view->setVars($ret);
        
        if (!$single) {
            $this->response->setStatusCode(404, 'Not Found');
            return false;
        }
        
        return $this->setRestResponse((bool)$single);
    }
    
    /**
     * Retrieving a record list
     * Alias of method getListAction()
     *
     * @return ResponseInterface
     * @throws \Exception
     * @deprecated Should use getListAction() method instead
     */
    public function getAllAction()
    {
        return $this->getListAction();
    }
    
    /**
     * Retrieving a record list
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function getListAction()
    {
        $model = $this->getModelClassName();
        
        $find = $this->getFind() ?: [];
        $with = $this->getListWith() ?: [];
        
        $resultset = $model::findWith($with, $find);
        $list = $this->listExpose($resultset);
        
        $ret = [];
        $ret['list'] = $list;
        $ret['listCount'] = count($list);
        $ret['totalCount'] = $model::find($this->getFindCount($find)); // @todo fix count to work with rollup when joins
        $ret['totalCount'] = is_int($ret['totalCount']) ? $ret['totalCount'] : count($ret['totalCount']);
        $ret['limit'] = $find['limit'] ?? null;
        $ret['offset'] = $find['offset'] ?? null;
        
        if ($this->isDebugEnabled()) {
            $ret['find'] = $find;
            $ret['with'] = $with;
        }
        
        $this->view->setVars($ret);
        
        return $this->setRestResponse((bool)$resultset);
    }
    
    /**
     * Exporting a record list into a CSV stream
     *
     * @return ResponseInterface|null
     * @throws \Exception
     */
    public function exportAction()
    {
        $model = $this->getModelClassName();
        $find = $this->getFind();
        $with = $model::with($this->getExportWith() ?: [], $find ?: []);
        $list = $this->exportExpose($with);
        $this->flatternArrayForCsv($list);
        $this->formatColumnText($list);
        return $this->download($list);
    }
    
    /**
     * Download a JSON / CSV / XLSX
     * @param $list
     * @param $fileName
     * @param $contentType
     * @param $params
     * @return ResponseInterface|void
     * @throws \League\Csv\CannotInsertRecord
     * @throws \League\Csv\InvalidArgument
     * @throws \Zemit\Exception
     */
    public function download($list = [], $fileName = null, $contentType = null, $params = null)
    {
        $params ??= $this->getParams();
        $contentType ??= $this->getContentType();
        $fileName ??= ucfirst(Slug::generate(basename(str_replace('\\', '/', $this->getModelClassName())))) . ' List (' . date('Y-m-d') . ')';
        
        if ($contentType === 'json') {
//            $this->response->setJsonContent($list);
            $this->response->setContent(json_encode($list, JSON_PRETTY_PRINT, 2048));
            $this->response->setContentType('application/json');
            $this->response->setHeader('Content-disposition', 'attachment; filename="' . addslashes($fileName) . '.json"');
            return $this->response->send();
        }
        
        // CSV
        if ($contentType === 'csv') {
        
            // Get CSV custom request parameters
            $mode = $params['mode'] ?? null;
            $delimiter = $params['delimiter'] ?? null;
            $newline = $params['newline'] ?? null;
            $escape = $params['escape'] ?? null;
            $outputBOM = $params['outputBOM'] ?? null;
            $skipIncludeBOM = $params['skipIncludeBOM'] ?? null;

//            $csv = Writer::createFromFileObject(new \SplTempFileObject());
            $csv = Writer::createFromStream(fopen('php://memory', 'r+'));
        
            // CSV - MS Excel on MacOS
            if ($mode === 'mac') {
                $csv->setOutputBOM(Writer::BOM_UTF16_LE); // utf-16
                $csv->setDelimiter("\t"); // tabs separated
                $csv->setNewline("\r\n"); // new lines
                CharsetConverter::addTo($csv, 'UTF-8', 'UTF-16');
            }
            
            // CSV - MS Excel on Windows
            else {
                $csv->setOutputBOM(Writer::BOM_UTF8); // utf-8
                $csv->setDelimiter(','); // comma separated
                $csv->setNewline("\n"); // new line windows
                CharsetConverter::addTo($csv, 'UTF-8', 'UTF-8');
            }
            
            // Apply forced params from request
            if (isset($outputBOM)) {
                $csv->setOutputBOM($outputBOM);
            }
            if (isset($delimiter)) {
                $csv->setDelimiter($delimiter);
            }
            if (isset($newline)) {
                $csv->setNewline($newline);
            }
            if (isset($escape)) {
                $csv->setEscape($escape);
            }
            if ($skipIncludeBOM) {
                $csv->skipInputBOM();
            }
            else {
                $csv->includeInputBOM();
            }
            
            // CSV
            if (isset($list[0])) {
                $csv->insertOne(array_keys($list[0]));
                $csv->insertAll($list);
            }
            $csv->output($fileName . '.csv');
            die;
        }
        
        // XLSX
        if ($contentType === 'xlsx') {
            $xlsxArray = [];
            if (isset($list[0])) {
                $xlsxArray [] = array_keys($list[0]);
            }
            foreach ($list as $array) {
                $xlsxArray [] = array_values($array);
            }
            $xlsx = \SimpleXLSXGen::fromArray($xlsxArray);
            $xlsx->downloadAs($fileName . '.xlsx');
            die;
        }
        
        // Something went wrong
        throw new \Exception('Failed to export `' . $this->getModelClassName() . '` using content-type `' . $contentType . '`', 400);
    }
    
    /**
     * Expose a single model
     */
    public function expose(ModelInterface $item, ?array $expose = null): array
    {
        $expose ??= $this->getExpose();
        return $item->expose($expose);
    }
    
    /**
     * Expose a list of model
     */
    public function listExpose(iterable $items, ?array $listExpose = null): array
    {
        $listExpose ??= $this->getListExpose();
        $ret = [];
        
        foreach ($items as $item) {
            $ret [] = $this->expose($item, $listExpose);
        }
        
        return $ret;
    }
    
    /**
     * Expose a list of model
     */
    public function exportExpose(iterable $items, $exportExpose = null): array
    {
        $exportExpose ??= $this->getExportExpose();
        return $this->listExpose($items, $exportExpose);
    }
    
    /**
     * @param array|null $array
     *
     * @return array|null
     */
    public function flatternArrayForCsv(?array &$list = null)
    {
        
        foreach ($list as $listKey => $listValue) {
            foreach ($listValue as $column => $value) {
                if (is_array($value) || is_object($value)) {
                    $value = $this->concatListFieldElementForCsv($value, ' ');
                    $list[$listKey][$column] = $this->arrayFlatten($value, $column);
                    if (is_array($list[$listKey][$column])) {
                        foreach ($list[$listKey][$column] as $childKey => $childValue) {
                            $list[$listKey][$childKey] = $childValue;
                            unset($list[$listKey][$column]);
                        }
                    }
                }
            }
        }
    }
    
    public function concatListFieldElementForCsv(array $list = [], ?string $seperator = ' '): array
    {
        foreach ($list as $valueKey => $element) {
            if (is_array($element) || is_object($element)) {
                $lastKey = array_key_last($list);
                if ($valueKey === $lastKey) {
                    continue;
                }
                foreach ($element as $elKey => $elValue) {
                    $list[$lastKey][$elKey] .= $seperator . $elValue;
                    if ($lastKey != $valueKey) {
                        unset($list[$valueKey]);
                    }
                }
            }
        }
        
        return $list;
    }
    
    public function arrayFlatten(?array $array, ?string $alias = null): array
    {
        $ret = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $ret = array_merge($ret, $this->arrayFlatten($value, $alias));
            }
            else {
                $ret[$alias . '.' . $key] = $value;
            }
        }
        return $ret;
    }
    
    /**
     * @param array|null $listValue
     *
     * @return array|null
     */
    public function mergeColumns(?array $listValue)
    {
        $columnToMergeList = $this->getExportMergeColum();
        if (!$columnToMergeList || empty($columnToMergeList)) {
            return $listValue;
        }
        
        $columnList = [];
        foreach ($columnToMergeList as $columnToMerge) {
            foreach ($columnToMerge['columns'] as $column) {
                if (isset($listValue[$column])) {
                    $columnList[$columnToMerge['name']][] = $listValue[$column];
                    unset($listValue[$column]);
                }
            }
            $listValue[$columnToMerge['name']] = implode(' ', $columnList[$columnToMerge['name']] ?? []);
        }
        
        return $listValue;
    }
    
    /**
     * @param array|null $list
     *
     * @return array|null
     */
    public function formatColumnText(?array &$list)
    {
        foreach ($list as $listKey => $listValue) {
            
            $mergeColumArray = $this->mergeColumns($listValue);
            if (!empty($mergeColumArray)) {
                $list[$listKey] = $mergeColumArray;
            }
            
            $formatArray = $this->getExportFormatFieldText($listValue);
            if ($formatArray) {
                $columNameList = array_keys($formatArray);
                foreach ($formatArray as $formatKey => $formatValue) {
                    if (isset($formatValue['text'])) {
                        $list[$listKey][$formatKey] = $formatValue['text'];
                    }
                    
                    if (isset($formatValue['rename'])) {
                        
                        $list[$listKey][$formatValue['rename']] = $formatValue['text'] ?? ($list[$listKey][$formatKey] ?? null);
                        if ($formatValue['rename'] !== $formatKey) {
                            foreach ($columNameList as $columnKey => $columnValue) {
                                
                                if ($formatKey === $columnValue) {
                                    $columNameList[$columnKey] = $formatValue['rename'];
                                }
                            }
                            
                            unset($list[$listKey][$formatKey]);
                        }
                    }
                }
                
                if (isset($formatArray['reorderColumns']) && $formatArray['reorderColumns']) {
                    $list[$listKey] = $this->arrayCustomOrder($list[$listKey], $columNameList);
                }
            }
        }
        
        return $list;
    }
    
    public function arrayCustomOrder(array $arrayToOrder, array $orderList): array
    {
        $ordered = [];
        foreach ($orderList as $key) {
            if (array_key_exists($key, $arrayToOrder)) {
                $ordered[$key] = $arrayToOrder[$key];
            }
        }
        return $ordered;
    }
    
    /**
     * Count a record list
     * @TODO add total count / deleted count / active count
     *
     * @return ResponseInterface
     */
    public function countAction()
    {
        $model = $this->getModelClassName();
        
        /** @var \Zemit\Mvc\Model $entity */
        $entity = new $model();
        
        $ret = [];
        $ret['totalCount'] = $model::count($this->getFindCount($this->getFind()));
        $ret['totalCount'] = is_int($ret['totalCount']) ? $ret['totalCount'] : count($ret['totalCount']);
        $ret['model'] = get_class($entity);
        $ret['source'] = $entity->getSource();
        $this->view->setVars($ret);
        
        return $this->setRestResponse();
    }
    
    /**
     * Prepare a new model for the frontend
     *
     * @return ResponseInterface
     */
    public function newAction()
    {
        $model = $this->getModelClassName();
        
        /** @var \Zemit\Mvc\Model $entity */
        $entity = new $model();
        $entity->assign($this->getParams(), $this->getWhiteList(), $this->getColumnMap());
        
        $this->view->model = get_class($entity);
        $this->view->source = $entity->getSource();
        $this->view->single = $this->expose($entity);
        
        return $this->setRestResponse();
    }
    
    /**
     * Prepare a new model for the frontend
     *
     * @return ResponseInterface
     */
    public function validateAction($id = null)
    {
        $model = $this->getModelClassName();
        
        /** @var \Zemit\Mvc\Model $entity */
        $entity = $this->getSingle($id);
        $new = !$entity;
        
        if ($new) {
            $entity = new $model();
        }
        
        $entity->assign($this->getParams(), $this->getWhiteList(), $this->getColumnMap());
        
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
            if (strpos($event, $new ? 'Update' : 'Create') !== false) {
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
    
        $ret = [];
        $ret['model'] = get_class($entity);
        $ret['source'] = $entity->getSource();
        $ret['single'] = $this->expose($entity);
        $ret['messages'] = $entity->getMessages();
        $ret['events'] = $events;
        $ret['validated'] = empty($this->view->messages);
        $this->view->setVars($ret);
        
        return $this->setRestResponse($ret['validated']);
    }
    
    /**
     * Saving a record (create & update)
     *
     * @param null|int $id
     *
     * @return ResponseInterface
     */
    public function saveAction($id = null)
    {
        $ret = $this->save($id);
        $this->view->setVars($ret);
        
        return $this->setRestResponse(true); // @todo set value based on save single or list
    }
    
    /**
     * Deleting a record
     *
     * @param null|int $id
     *
     * @return bool|ResponseInterface
     */
    public function deleteAction($id = null)
    {
        $entity = $this->getSingle($id);
        
        $ret = [];
        $ret['deleted'] = $entity && $entity->delete();
        $ret['single'] = $entity ? $this->expose($entity) : false;
        $ret['messages'] = $entity ? $entity->getMessages() : false;
        $this->view->setVars($ret);
        
        if (!$entity) {
            $this->response->setStatusCode(404, 'Not Found');
            return false;
        }
        
        return $this->setRestResponse($ret['deleted']);
    }
    
    /**
     * Restoring record
     *
     * @param null $id
     *
     * @return bool|ResponseInterface
     */
    public function restoreAction($id = null)
    {
        $entity = $this->getSingle($id);
        
        $ret = [];
        $ret['restored'] = $entity && $entity->restore();
        $ret['single'] = $entity ? $this->expose($entity) : false;
        $ret['messages'] = $entity ? $entity->getMessages() : false;
        $this->view->setVars($ret);
        
        if (!$entity) {
            $this->response->setStatusCode(404, 'Not Found');
            return false;
        }
        
        return $this->setRestResponse($ret['restored']);
    }
    
    /**
     * Re-ordering a position
     *
     * @param null $id
     * @param null $position
     *
     * @return bool|ResponseInterface
     */
    public function reorderAction($id = null, $position = null)
    {
        $entity = $this->getSingle($id);
        $position = $this->getParam('position', 'int', $position);
        
        $ret = [];
        $ret['reordered'] = $entity ? $entity->reorder($position) : false;
        $ret['single'] = $entity ? $this->expose($entity) : false;
        $ret['messages'] = $entity ? $entity->getMessages() : false;
        $this->view->setVars($ret);
        
        if (!$entity) {
            $this->response->setStatusCode(404, 'Not Found');
            return false;
        }
        
        return $this->setRestResponse($ret['reordered']);
    }
    
    /**
     * Sending an error as an http response
     *
     * @param null $error
     * @param null $response
     *
     * @return ResponseInterface
     */
    public function setRestErrorResponse($code = 400, $status = 'Bad Request', $response = null)
    {
        return $this->setRestResponse($response, $code, $status);
    }
    
    /**
     * Sending rest response as an http response
     *
     * @param mixed $response
     * @param ?int $code
     * @param ?string $status
     * @param int $jsonOptions
     * @param int $depth
     *
     * @return ResponseInterface
     */
    public function setRestResponse($response = null, int $code = null, string $status = null, int $jsonOptions = 0, int $depth = 512): ResponseInterface
    {
        $debug = $this->isDebugEnabled();
        
        // keep forced status code or set our own
        $statusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();
        $code ??= (int)$statusCode ?: 200;
        $status ??= $reasonPhrase ?: StatusCode::getMessage($code);
        
        $view = $this->view->getParamsToView();
        $hash = hash('sha512', json_encode($view));
    
        // set response status code
        $this->response->setStatusCode($code, $code . ' ' . $status);
        
        // @todo handle this correctly
        // @todo private vs public cache type
        $cache = $this->getCache();
        if (!empty($cache['lifetime'])) {
            if ($this->response->getStatusCode() === 200) {
                $this->response->setCache($cache['lifetime']);
                $this->response->setEtag($hash);
            }
        }
        else {
            $this->response->setCache(0);
            $this->response->setHeader('Cache-Control', 'no-cache, max-age=0');
        }
        
        $ret = [];
        $ret['api'] = [];
        $ret['api']['version'] = ['0.1']; // @todo
        $ret['timestamp'] = date('c');
        $ret['hash'] = $hash;
        $ret['status'] = $status;
        $ret['code'] = $code;
        $ret['response'] = $response;
        $ret['view'] = $view;
        
        if ($debug) {
            $ret['api']['php'] = phpversion();
            $ret['api']['phalcon'] = Version::get();
            $ret['api']['zemit'] = $this->config->path('core.version');
            $ret['api']['core'] = $this->config->path('core.name');
            $ret['api']['app'] = $this->config->path('app.version');
            $ret['api']['name'] = $this->config->path('app.name');
    
            $ret['identity'] = $this->identity ? $this->identity->getIdentity() : null;
            $ret['profiler'] = $this->profiler ? $this->profiler->toArray() : null;
            $ret['request'] = $this->request ? $this->request->toArray() : null;
            $ret['dispatcher'] = $this->dispatcher ? $this->dispatcher->toArray() : null;
            $ret['router'] = $this->router ? $this->router->toArray() : null;
            $ret['memory'] = Utils::getMemoryUsage();
        }
        
        return $this->response->setJsonContent($ret, $jsonOptions, $depth);
    }
    
    public function beforeExecuteRoute(Dispatcher $dispatcher): void
    {
        // @todo use eventsManager from service provider instead
        $this->eventsManager->enablePriorities(true);
        
        // @todo see if we can implement receiving an array of responses globally: V2
        // $this->eventsManager->collectResponses(true);
        
        // retrieve events based on the config roles and features
        $permissions = $this->config->get('permissions')->toArray() ?? [];
        $featureList = $permissions['features'] ?? [];
        $roleList = $permissions['roles'] ?? [];
        
        foreach ($roleList as $role => $rolePermission) {
            
            if (isset($rolePermission['features'])) {
                foreach ($rolePermission['features'] as $feature) {
                    $rolePermission = array_merge_recursive($rolePermission, $featureList[$feature] ?? []);
                    // @todo remove duplicates
                }
            }
            
            $behaviorsContext = $rolePermission['behaviors'] ?? [];
            foreach ($behaviorsContext as $className => $behaviors) {
                if (is_int($className) || get_class($this) === $className) {
                    $this->attachBehaviors($behaviors, 'rest');
                }
                if ($this->getModelClassName() === $className) {
                    $this->attachBehaviors($behaviors, 'model');
                }
            }
        }
    }
    
    /**
     * Attach a new behavior
     * @todo review behavior type
     */
    public function attachBehavior(string $behavior, string $eventType = 'rest'): void
    {
        $event = new $behavior();
        
        // inject DI
        if ($event instanceof Injectable || method_exists($event, 'setDI')) {
            $event->setDI($this->getDI());
        }
        
        // attach behavior
        $this->eventsManager->attach($event->eventType ?? $eventType, $event, $event->priority ?? Manager::DEFAULT_PRIORITY);
    }
    
    /**
     * Attach new behaviors
     */
    public function attachBehaviors(array $behaviors = [], string $eventType = 'rest'): void
    {
        foreach ($behaviors as $behavior) {
            $this->attachBehavior($behavior, $eventType);
        }
    }
    
    /**
     * Handle rest response automagically
     */
    public function afterExecuteRoute(Dispatcher $dispatcher): void
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
    
    public function isDebugEnabled(): bool
    {
        return $this->config->path('app.debug') ?? false;
    }
}
