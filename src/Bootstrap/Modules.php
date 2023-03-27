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
use Phalcon\Config\ConfigInterface;

/**
 * Register modules from the config
 */
class Modules
{
    public function __construct(AbstractApplication $application, ?array $modules, ?string $defaultModule)
    {
        $config = $application->getDI()->get('config');
        assert($config instanceof ConfigInterface);
        
        $modules ??= $config->get('modules')->toArray();
        $application->registerModules($modules);
        
        $defaultModule ??= $config->path('router.defaults.module');
        $application->setDefaultModule($defaultModule);
    }
}
