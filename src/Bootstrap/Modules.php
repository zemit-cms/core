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

use Phalcon\Application\AbstractApplication;

/**
 * Class Modules
 * Registering a list of module
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Bootstrap
 */
class Modules
{
    public $modulesDir;
    
    public function __construct(AbstractApplication $application = null)
    {
        /**
         * Register application modules
         */
        $config = $application->getDI()->get('config');
        $application->registerModules($config->modules->toArray());
        $application->setDefaultModule($config->router->defaults->module);
    }
}
