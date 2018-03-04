<?php

namespace Zemit\Core\Mvc\Router;

use Phalcon\Mvc\Router\Group as RouterGroup;

class ModuleRoute extends RouterGroup
{
    public $default = false;
    
    public function __construct($paths = null, $default = false)
    {
        $this->default = $default;
        parent::__construct($paths);
    }
    
    public function initialize()
    {
        $path = $this->getPaths();
        $routeKey = '/' . $path['module'];
        $this->setPrefix('/{locale:([a-z]{2,3}([\_\-][[:alnum:]]{1,8})?)}' . ($this->default ? null : $routeKey));
        $this->add( '/:params', array(
            'namespace' => $path['namespace'],
            'module' => $path['module'],
            'controller' => $path['controller'],
            'action' => $path['action'],
            'params' => 3
        ))->setName('LocaleAwareRoute');
        $this->add( '/:controller/:params', array(
            'namespace' => $path['namespace'],
            'module' => $path['module'],
            'controller' => 3,
            'action' => $path['action'],
            'params' => 4
        ))->setName('LocaleAwareRoute');
        $this->add( '/:controller/([a-zA-Z0-9\_\-]+)/:params', array(
            'namespace' => $path['namespace'],
            'module' => $path['module'],
            'controller' => 3,
            'action' => 4,
            'params' => 5
        ))->setName('LocaleAwareRoute');
        $this->add( '/:controller/:int', array(
            'namespace' => $path['namespace'],
            'module' => $path['module'],
            'controller' => 3,
            'id' => 4,
        ))->setName('LocaleAwareRoute');
    }
}
