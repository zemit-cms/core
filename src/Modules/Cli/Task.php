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
use Zemit\Exception\CliException;
use Zemit\Http\StatusCode;
use Zemit\Support\Helper;
use Zemit\Support\Utils;

class Task extends \Zemit\Cli\Task
{
    
    public string $cliDoc = <<<DOC
Usage:
  php zemit cli <task> <action> [<params> ...]

Options:
  task: build,cache,cron,errors,help,scaffold


DOC;
    
    public function beforeExecuteRoute(): void
    {
        $argv = array_slice($_SERVER['argv'] ?? [], 1);
        $response = (new \Docopt())->handle($this->cliDoc, ['argv' => $argv, 'optionsFirst' => false]);
        foreach ($response as $key => $value) {
            if (!is_null($value) && preg_match('/(<(.*?)>|\-\-(.*))/', $key, $match)) {
                $key = lcfirst(Helper::camelize(Helper::uncamelize(array_pop($match))));
                $args[$key] = $value;
                $this->dispatcher->setParam($key, $value);
            }
        }
    }
    
    public function helpAction(): void
    {
        echo $this->cliDoc;
    }
    
    public function mainAction(): ?array
    {
        $this->helpAction();
        
        return null;
    }
    
    public function normalizeResponse(bool $response = true, ?int $code = null, ?string $status = null): array
    {
        $debug = $this->config->path('app.debug') ?? false;
        
        // keep forced status code or set our own
        $statusCode = $this->response->getStatusCode();
        $reasonPhrase = $this->response->getReasonPhrase();
        $code ??= (int)$statusCode ?: 200;
        $status ??= $reasonPhrase ?: StatusCode::getMessage($code);
        
        $view = $this->view->getParamsToView();
        $hash = hash('sha512', json_encode($view));
        
        // set response status code
        $this->response->setStatusCode($code, $status);
        
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
            $ret['dispatcher'] = $this->dispatcher ? $this->dispatcher->toArray() : null;
            $ret['router'] = $this->router ? $this->router->toArray() : null;
            $ret['memory'] = Utils::getMemoryUsage();
        }
        
        return $ret;
    }
    
    /**
     * Handle rest response automagically
     * @param Dispatcher $dispatcher
     * @return void
     * @throws CliException
     */
    public function afterExecuteRoute(Dispatcher $dispatcher): void
    {
        // Merge response into view variables
        $response = $dispatcher->getReturnedValue();
        
        // Quiet output
        $quiet = $this->dispatcher->getParam('quiet');
        if ($quiet) {
            exit(!$response ? 1 : 0);
        }
        
        // Normalize response
        $this->view->setVars((array)$response);
        $normalizedResponse = $this->normalizeResponse((bool)$response);
        $dispatcher->setReturnedValue($normalizedResponse);
        
        // Set response
        $verbose = $this->dispatcher->getParam('verbose');
        $ret = $verbose ? $normalizedResponse : $response;
        
        // Format response
        $format = $this->dispatcher->getParam('format');
        $format ??= 'json';
        switch (strtolower($format)) {
            case 'dump':
                dump($ret);
                break;
                
            case 'var_export':
                var_export($ret);
                break;
                
            case 'print_r':
                print_r($ret);
                break;
    
            case 'serialize':
                echo serialize($ret);
                break;
            
            case 'json':
                echo json_encode($ret, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
                break;
            
            case 'string':
                if (is_string($ret)) {
                    echo $ret;
                }
                elseif (is_bool($ret)) {
                    echo $ret? 'true' : 'false';
                }
                elseif (is_null($ret)) {
                    echo 'null';
                }
                elseif (is_numeric($ret)) {
                    echo $ret;
                }
                else {
                    echo json_encode($ret, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
                }
                break;
                
            case 'raw':
                if (is_string($ret) || is_bool($ret) || is_null($ret) || is_numeric($ret)) {
                    echo $ret;
                }
                else {
                    echo json_encode($ret, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
                }
                break;
            
            default:
                throw new CliException('Unknown output format `' . $format . '` expected one of the string value: `json` `serialize` `dump` `raw`');
        }
    }
}
