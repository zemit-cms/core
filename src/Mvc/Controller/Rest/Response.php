<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Rest;

use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Dispatcher;
use Zemit\Mvc\Controller\AbstractTrait\AbstractInjectable;
use Zemit\Http\StatusCode;
use Zemit\Support\Utils;

trait Response {
    
    use AbstractInjectable;
    
    /**
     * Set the REST response error
     *
     * @param int $code The HTTP status code (default: 400)
     * @param string $status The status message (default: 'Bad Request')
     * @param mixed $response The response body (default: null)
     * @return ResponseInterface The REST response object
     */
    public function setRestErrorResponse(int $code = 400, string $status = 'Bad Request', mixed $response = null): ResponseInterface
    {
        return $this->setRestResponse($response, $code, $status);
    }
    
    /**
     * Sending rest response as a http response
     *
     * @param mixed $response
     * @param ?int $code
     * @param ?string $status
     * @param int $jsonOptions
     * @param int $depth
     *
     * @return ResponseInterface
     */
    public function setRestResponse(mixed $response = null, int $code = null, string $status = null, int $jsonOptions = 0, int $depth = 512): ResponseInterface
    {
        $debug = $this->isDebugEnabled();
        
        // keep forced status code or set our own
        $statusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();
        $code ??= (int)$statusCode ?: 200;
        $status ??= $reasonPhrase ?: StatusCode::getMessage($code);
        
        $view = $this->view->getParamsToView();
        $hash = hash('sha512', json_encode($view)); // @todo store hash in cache layer with response content
        
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
            $ret['api']['phalcon'] = $this->config->path('phalcon.version');
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
    
    /**
     * Update the Dispatcher after executing the route.
     *
     * @param Dispatcher $dispatcher The Dispatcher instance.
     *
     * @return void
     */
    public function afterExecuteRoute(Dispatcher $dispatcher): void
    {
        $response = $dispatcher->getReturnedValue();
        
        // Avoid breaking default phalcon behaviour
        if ($response instanceof \Phalcon\Http\Response) {
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
