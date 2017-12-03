<?php

namespace Zemit\Core\Bootstrap;

use Phalcon\Application;

/**
 * Require a config from the DI
 * Config : [modules => ['api', 'backend', 'frontend']]
 *
 * Class Modules
 * @package Zemit\Core\Bootstrap
 */
class Modules {
    
    public function __construct(Application $application)
    {
        /**
         * Register application modules
         */
        $config = $application->getDI()->get('config');
        if (!empty($config)) {
            $registerModules = array();
            foreach ($config->modules as $module) {
                $registerModules[$module] = array(
                    'className' => 'Zemit\Core\\' . ucfirst($module) . '\\Module',
                    'path' => __DIR__ . '/../modules/' . $module . '/Module.php'
                );
            }
            if (!empty($registerModules)) {
                $application->registerModules($registerModules);
            }
            else {
                // @TODO maybe throw an error
            }
        }
        else {
            // @TODO maybe throw an error
        }
        
    }
    
}