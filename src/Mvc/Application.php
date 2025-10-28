<?php

declare(strict_types=1);

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
use Phalcon\Dispatcher\AbstractDispatcher;
use Zemit\Cli\Dispatcher as CliDispatcher;
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
     * Requests a location using the specified dispatcher.
     *
     * @param array $location An array containing location information, including namespace, module, controller,
     *                        action, and params. Default is an empty array.
     * @return string The response content of the requested location.
     * @throws \Exception
     */
    public function request(array $location = []): string
    {
        // Get a unique dispatcher
        $dispatcher = $this->getDI()->get('dispatcher');
        assert($dispatcher instanceof AbstractDispatcher);
        $dispatcher = clone $dispatcher;
        
        // Route dispatcher
        $dispatcher->setDefaultNamespace($location['namespace'] ?? $dispatcher->getNamespaceName());
        $dispatcher->setNamespaceName($location['namespace'] ?? $dispatcher->getNamespaceName());
        $dispatcher->setModuleName($location['module'] ?? $dispatcher->getModuleName());
        if ($dispatcher instanceof MvcDispatcher) {
            $dispatcher->setControllerName($location['controller'] ?? 'index');
        }
        elseif ($dispatcher instanceof CliDispatcher) {
            $dispatcher->setTaskName($location['task'] ?? 'main');
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
