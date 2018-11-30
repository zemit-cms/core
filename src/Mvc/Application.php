<?php

namespace Zemit\Core\Mvc;

use Phalcon\DiInterface;
use Phalcon\Http\ResponseInterface;

use Phalcon\Mvc\Application as MvcApplication;

/**
 * Class Application
 * Switches default Phalcon MVC into a simple HMVC to allow requests
 * between different namespaces and modules
 *
 * @TODO Console / Cli / Task ?
 * @TODO setup with real default values from configs
 * @package Zemit\Core\Mvc
 */
class Application extends MvcApplication
{
    /**
     * HMVC Application
     *
     * @param \Phalcon\DiInterface
     */
    public function __construct(DiInterface $di)
    {
        // Registering app itself as a service
        $di->set('application', $this, true);
        parent::setDI($di);
    }
    
    /**
     * Does a HMVC request in the application
     *
     * @param array $location
     *
     * @return mixed
     */
    public function request($location)
    {
        // Actually clone the dispatcher
        $dispatcher = clone $this->getDI()->get('dispatcher');
        
        // Manually forward the dispatcher
        $dispatcher->setNamespaceName($location['namespace'] ?? $dispatcher->getNamespaceName());
        $dispatcher->setModuleName($location['module'] ?? $dispatcher->getModuleName());
        $dispatcher->setControllerName($location['controller'] ?? 'index');
        $dispatcher->setActionName($location['action'] ?? 'index');
        $dispatcher->setParams($location['params'] ?? []);
        $dispatcher->dispatch();
        
        // Get the returned value or response
        $response = $dispatcher->getReturnedValue();
        if ($response instanceof ResponseInterface) {
            return $response->getContent();
        }
        return $response;
    }
    
}
