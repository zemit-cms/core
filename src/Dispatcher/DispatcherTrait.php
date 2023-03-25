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
    /**
     * @param $handler
     * @param string $actionMethod
     * @param array $params
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
        if (!$preventCycle) {
            parent::forward($forward);
        }
        elseif ((!isset($forward['namespace']) || $this->getNamespaceName() !== $forward['namespace']) &&
            (!isset($forward['module']) || $this->getModuleName() !== $forward['module']) &&
            (!isset($forward['task']) || $this->getControllerName() !== $forward['task']) &&
            (!isset($forward['controller']) || $this->getControllerName() !== $forward['controller']) &&
            (!isset($forward['action']) || $this->getActionName() !== $forward['action']) &&
            (!isset($forward['params']) || $this->getParams() !== $forward['params'])
        ) {
            if (!isset($forward['namespace'])) {
                unset($forward['namespace']);
            }
            if (!isset($forward['module'])) {
                unset($forward['module']);
            }
            if (!isset($forward['task'])) {
                unset($forward['task']);
            }
            if (!isset($forward['controller'])) {
                unset($forward['controller']);
            }
            if (!isset($forward['action'])) {
                unset($forward['action']);
            }
            if (!isset($forward['params'])) {
                unset($forward['params']);
            }
            $this->forward($forward);
        }
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
