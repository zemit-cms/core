<?php

/*
 +------------------------------------------------------------------------+
 | Phosphorum                                                             |
 +------------------------------------------------------------------------+
 | Copyright (c) 2013-2016 Phalcon Team and contributors                  |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file LICENSE.txt.                             |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to license@phalconphp.com so we can send you a copy immediately.       |
 +------------------------------------------------------------------------+
*/

namespace Zemit\Core\Backend\Provider\View;

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Simple;
use InvalidArgumentException;
use Phalcon\Mvc\View\Engine\Php;
use Phosphorum\Listener\ViewListener;
use Phosphorum\Provider\AbstractServiceProvider;

/**
 * Phosphorum\Provider\View\ServiceProvider
 *
 * @package Zemit\Core\Backend\Provider\View
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'view';
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $di = $this->di;
        $this->di->setShared($this->serviceName, function() use ($di) {
            $view = new View();
            $view->setViewsDir(array(
                __DIR__ . '/../../Views/',
            ));
            return $view;
        });
    }
}
