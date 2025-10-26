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
use Zemit\Support\Helper;
use Zemit\Support\Utils;

class Task extends \Zemit\Cli\Task
{
    public string $cliDoc = <<<DOC
Usage:
  zemit cli <task> <action> [<params> ...]

Options:
  task: build,cache,cron,errors,help,scaffold


DOC;
    
    public function beforeExecuteRoute(): void
    {
        $argv = array_slice($_SERVER['argv'] ?? [], 1);
        $payload = (new \Docopt())->handle($this->cliDoc, ['argv' => $argv, 'optionsFirst' => false]);
        foreach ($payload as $key => $value) {
            if (!is_null($value) && preg_match('/(<(.*?)>|\-\-(.*))/', $key, $matches)) {
                $match = array_pop($matches);
                if (!empty($match)) {
                    $key = lcfirst(Helper::camelize(Helper::uncamelize($match)));
                    $this->dispatcher->setParam($key, $value);
                }
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
    
    /**
     * Handle rest response automagically
     * @param Dispatcher $dispatcher
     * @return void
     * @throws CliException
     */
    public function afterExecuteRoute(Dispatcher $dispatcher): void
    {
        // Merge response into view variables
        $payload = $dispatcher->getReturnedValue();
        
        // Quiet output
        $quiet = $this->dispatcher->getParam('quiet');
        if ($quiet) {
            exit(!$payload ? 1 : 0);
        }
        
        // Format response
        $format = $this->dispatcher->getParam('format');
        $format ??= 'json';
        switch (strtolower($format)) {
            case 'dump':
                dump($payload);
                break;
            
            case 'var_export':
                var_export($payload);
                break;
            
            case 'print_r':
                print_r($payload);
                break;
            
            case 'serialize':
                echo serialize($payload);
                break;
            
            case 'json':
                echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                echo PHP_EOL;
                break;
            
            case 'string':
                if (is_string($payload)) {
                    echo $payload;
                }
                else if (is_bool($payload)) {
                    echo $payload ? 'true' : 'false';
                }
                else if (is_null($payload)) {
                    echo 'null';
                }
                else if (is_numeric($payload)) {
                    echo $payload;
                }
                else {
                    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    echo PHP_EOL;
                }
                break;
            
            case 'raw':
                if (is_string($payload) || is_bool($payload) || is_null($payload) || is_numeric($payload)) {
                    echo $payload;
                }
                else {
                    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    echo PHP_EOL;
                }
                break;
            
            default:
                throw new CliException('Unknown output format `' . $format . '` expected one of the string value: `json` `serialize` `dump` `raw`');
        }
    }
}
