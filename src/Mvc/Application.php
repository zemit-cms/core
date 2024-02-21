<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Phalcon\Di\DiInterface;
use Phalcon\Http\ResponseInterface;
use Zemit\Cli\Dispatcher as CliDispatcher;
use Zemit\Dispatcher\AbstractDispatcher;
use Zemit\Mvc\Dispatcher as MvcDispatcher;

/**
 * Simple HMVC - allow requests with namespaces and modules
 * {@inheritdoc}
 */
class Application extends \Phalcon\Mvc\Application
{
    /**
     * HMVC Application
     * {@inheritdoc}
     */
    public function __construct(DiInterface $di)
    {
        // Registering app itself as a service
        $di->setShared('application', $this);
        parent::__construct($di);
    }

    /**
     * HMVC request
     * You can request call any module/namespace
     */
    public function request(array $location = []): string
    {
        // Get a unique dispatcher
        $dispatcher = clone $this->getDI()->get('dispatcher');
        assert($dispatcher instanceof AbstractDispatcher);
        
        // Route dispatcher
        $dispatcher->setDefaultNamespace($location['namespace'] ?? $dispatcher->getNamespaceName());
        $dispatcher->setNamespaceName($location['namespace'] ?? $dispatcher->getNamespaceName());
        $dispatcher->setModuleName($location['module'] ?? $dispatcher->getModuleName());
        if ($dispatcher instanceof MvcDispatcher) {
            $dispatcher->setControllerName($location['controller'] ?? 'index');
        }
        elseif ($dispatcher instanceof CliDispatcher) {
            $dispatcher->setTaskName($location['task'] ?? 'index');
        }
        $dispatcher->setActionName($location['action'] ?? 'index');
        $dispatcher->setParams($location['params'] ?? []);
        $dispatcher->dispatch();
        
        // Get and return value
        $response = $dispatcher->getReturnedValue();
        if ($response instanceof ResponseInterface) {
            return $response->getContent();
        }
        
        return $response;
    }
}
