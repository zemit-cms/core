<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Dispatcher;

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Cli\Dispatcher as CliDispatcher;

trait DispatcherTrait
{
    abstract public function getNamespaceName(): string;
    
    abstract public function getModuleName(): string;
    
    abstract public function getActionName(): string;
    
    abstract public function getParams(): array;
    
    abstract public function getHandlerClass(): string;
    
    abstract public function getHandlerSuffix(): string;

//    abstract public function getTaskName(): string;

//    abstract public function getControllerName(): string;
    
    abstract public function getActionSuffix(): string;
    
    abstract public function getActiveMethod(): string;
    
    /**
     * {@inheritDoc}
     * The string typed keys are not passed to the action method arguments
     * Only the int keys will be passed
     *
     * @param $handler
     * @return mixed
     */
    public function callActionMethod($handler, string $actionMethod, array $params = [])
    {
        return call_user_func_array(
            [$handler, $actionMethod],
            array_filter($params, 'is_int', ARRAY_FILTER_USE_KEY)
        );
    }
    
    /**
     * Extending forwarding event to prevent cyclic routing when forwarding under dispatcher events
     * {@inheritDoc}
     */
    public function forward(array $forward, bool $preventCycle = false): void
    {
        $forward = $this->unsetForward($forward);
        
        if (!$preventCycle) {
            parent::forward($forward);
        }
        
        elseif ($this->canForward($forward)) {
            parent::forward($forward);
        }
    }
    
    public function canForward(array $forward): bool
    {
        $canForward = true;
        
        if ($this instanceof AbstractDispatcher || $this instanceof MvcDispatcher || $this instanceof CliDispatcher) {
            $canForward = false;
            
            if ((!isset($forward['namespace']) || $this->getNamespaceName() !== $forward['namespace']) &&
                (!isset($forward['module']) || $this->getModuleName() !== $forward['module']) &&
                (!isset($forward['action']) || $this->getActionName() !== $forward['action']) &&
                (!isset($forward['params']) || $this->getParams() !== $forward['params'])
            ) {
                if ($this instanceof MvcDispatcher) {
                    if ((!isset($forward['controller']) || $this->getControllerName() !== $forward['controller'])) {
                        $canForward = true;
                    }
                }
                
                if ($this instanceof CliDispatcher) {
                    if ((!isset($forward['task']) || $this->getTaskName() !== $forward['task'])) {
                        $canForward = true;
                    }
                }
            }
        }
        
        return $canForward;
    }
    
    public function unsetForward(array $forward, ?array $parts = null): array
    {
        $parts ??= [
            'namespace',
            'module',
            'task',
            'controller',
            'action',
            'params',
        ];
        
        foreach ($parts as $part) {
            if (is_null($forward[$part])) {
                unset($forward[$part]);
            }
        }
        
        return $forward;
    }
    
    public function toArray(): array
    {
        $ret = [
            'namespace' => $this->getNamespaceName(),
            'module' => $this->getModuleName(),
            'action' => $this->getActionName(),
            'params' => $this->getParams(),
            'handlerClass' => $this->getHandlerClass(),
            'handlerSuffix' => $this->getHandlerSuffix(),
            'activeMethod' => $this->getActiveMethod(),
            'actionSuffix' => $this->getActionSuffix(),
        ];
        
        if ($this instanceof MvcDispatcher) {
            $ret['controller'] = $this->getControllerName();
            $ret['previousNamespace'] = $this->getPreviousNamespaceName();
            $ret['previousController'] = $this->getPreviousControllerName();
            $ret['previousAction'] = $this->getPreviousActionName();
        }
        
        if ($this instanceof CliDispatcher) {
            $ret['task'] = $this->getTaskName();
            $ret['taskSuffix'] = $this->getTaskSuffix();
        }
        
        return $ret;
    }
}
