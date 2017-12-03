<?php
namespace Zemit\Core\Hmvc;

use Phalcon\DiInterface;
use Phalcon\Http\ResponseInterface;

use Phalcon\Mvc\Application as MvcApplication;

class Application extends MvcApplication {

    /**
     * HMVCApplication Constructor
     *
     * @param Phalcon\DiInterface
     */
    public function __construct(DiInterface $di) {
        
        //Register the app itself as a service
        $di['app'] = $this;
        
        //Sets the parent Id
        parent::setDI($di);
    }

    /**
     * Does a HMVC request in the application
     *
     * @param array $location
     * @param array $data
     * @return mixed
     */
    public function request($location) {
        $dispatcher = clone $this->getDI()->get('dispatcher');
        
        if (isset($location['namespace'])) {
            $dispatcher->setNamespaceName($location['namespace']);
        }
        else {
            $dispatcher->setNamespaceName($dispatcher->getNamespaceName());
        }
        if (isset($location['controller'])) {
            $dispatcher->setControllerName($location['controller']);
        }
        else {
            $dispatcher->setControllerName('index');
        }
        if (isset($location['action'])) {
            $dispatcher->setActionName($location['action']);
        }
        else {
            $dispatcher->setActionName('index');
        }
        if (isset($location['params'])) {
            if (is_array($location['params'])) {
                $dispatcher->setParams($location['params']);
            }
            else {
                $dispatcher->setParams((array) $location['params']);
            }
        }
        else {
            $dispatcher->setParams(array());
        }
        $dispatcher->dispatch();
        $response = $dispatcher->getReturnedValue();
        if ($response instanceof ResponseInterface) {
            return $response->getContent();
        }
        return $response;
    }

}
