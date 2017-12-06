<?php

namespace Zemit\Core\Backend;

use Phalcon\Loader as PhalconLoader;

/**
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @version 1.0.0
 */
class Loader extends PhalconLoader
{
    
    public function __construct()
    {
        $this->registerNamespaces([
            'Zemit\\Backend\\Controllers' => $this->config->application->modulesDir . 'backend/controllers/',
        ], true);
    }
    
}
