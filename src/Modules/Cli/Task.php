<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli;

use Phalcon\Cli\Dispatcher;
use Phalcon\Support\Version;
use Zemit\Utils;

/**
 * Class Task
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Modules\Cli
 */
class Task extends \Phalcon\Cli\Task
{
    /**
     * @var string
     */
    public $consoleDoc = <<<DOC
Usage:
  php zemit cli <task> <action> [<params> ...]

Options:
  task: build,cache,cron,errors,help,scaffold


DOC;
    
    public function helpAction()
    {
        echo $this->consoleDoc;
    }
    
    public function mainAction()
    {
        $this->helpAction();
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
     * @return array
     */
    public function normalizeResponse($response = null, $code = null, $status = null, $jsonOptions = 0, $depth = 512)
    {
        $debug = $this->config->app->debug ?: $this->dispatcher->getParam('debug') ?: false;
        
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
        $identity = $debug ? $this->identity->getIdentity() : null;
        $profiler = $debug && $this->profiler ? $this->profiler->toArray() : null;
        $dispatcher = $debug ? $this->dispatcher->toArray() : null;
        $router = $debug ? $this->router->toArray() : null;
        
        $api = $debug ? [
            'php' => phpversion(),
            'phalcon' => (new Version)->get(),
            'zemit' => $this->config->core->version,
            'core' => $this->config->core->name,
            'app' => $this->config->app->version,
            'name' => $this->config->app->name,
        ] : [];
        $api['version'] = '0.1';
        
        $this->response->setStatusCode($code, $code . ' ' . $status);
        
        return array_merge([
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
            'dispatcher' => $dispatcher,
            'router' => $router,
            'memory' => Utils::getMemoryUsage(),
        ] : []);
    }
    
    /**
     * Handle rest response automagically
     *
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        // Merge response into view variables
        $response = $dispatcher->getReturnedValue();
    
        // Quiet output
        $quiet = $this->dispatcher->getParam('quiet');
        if ($quiet) {
            exit(!$response? 1 : 0);
        }
    
        // Normalize response
        if (is_array($response)) {
            $this->view->setVars($response, true);
        }
        $normalizedResponse = $this->normalizeResponse(is_array($response) ? null : $response);
        $dispatcher->setReturnedValue($normalizedResponse);
    
        // Set response
        $verbose = $this->dispatcher->getParam('verbose');
        $ret = $verbose? $normalizedResponse : $response;
        
        // Format response
        $format = $this->dispatcher->getParam('format');
        $format ??= 'dump';
        
        switch (strtolower($format)) {
            case 'dump':
                dd($ret);
            case 'json':
                echo json_encode($ret);
                break;
            case 'xml':
                $xml = new \SimpleXMLElement('');
                array_walk_recursive($ret, array ($xml,'addChild'));
                echo $xml->asXML();
                break;
            case 'serialize':
                echo serialize($ret);
                break;
            case 'raw':
                if (is_array($ret) || is_object($ret)) {
                    print_r($ret);
                }
                else if (is_bool($ret)) {
                    echo $ret? 'true' : 'false';
                }
                else {
                    echo strval($ret);
                }
                break;
            default:
                throw new \Exception('Unknown output format `'.$format.'` expected one of the string value: `json` `xml` `serialize` `dump` `raw`');
        }
    }
}
