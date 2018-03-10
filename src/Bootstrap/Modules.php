<?php

namespace Zemit\Core\Bootstrap;

use Phalcon\Application;

/**
 * Require a config from the DI
 * Config : [modules => ['api', 'backend', 'frontend']]
 *
 * Class Modules
 * @package Zemit\Bootstrap
 */
class Modules {
    
    public $modulesDir;
    
    public function __construct(Application $application)
    {
        /**
         * Register application modules
         */
        $config = $application->getDI()->get('config');
        $application->registerModules($config->modules->toArray());
    }
    
}