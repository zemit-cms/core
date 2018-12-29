<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Bootstrap;

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
    
    public function __construct(Application $application = null)
    {
        /**
         * Register application modules
         */
        $config = $application->getDI()->get('config');
        $application->registerModules($config->modules->toArray());
        $application->setDefaultModule($config->router->defaults->module);
    }
    
}