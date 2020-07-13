<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\View;

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Simple;
use InvalidArgumentException;
use Phalcon\Mvc\View\Engine\Php;
use Zemit\Listener\ViewListener;
use Zemit\Mvc\View\Error as ViewError;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\View\ServiceProvider
 *
 * @package Zemit\Provider\View
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
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
            $config = $di->get('config');
            $eventsManager = $di->get('eventsManager');
            
            $error = new ViewError();
            $error->setDI($di);
            $eventsManager->attach('view', $error);
            
            $view = new \Zemit\Mvc\View();
            $view->setMinify($config->app->minify);
            $view->registerEngines([
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
                '.volt' => 'Phalcon\Mvc\View\Engine\Volt',
//                '.mhtml' => 'Phalcon\Mvc\View\Engine\Mustache',
//                '.twig' => 'Phalcon\Mvc\View\Engine\Twig', // @TODO fix for non-existing viewdir
//                '.tpl' => 'Phalcon\Mvc\View\Engine\Smarty'
            ]);
            
            $view->setEventsManager($eventsManager);
            $view->setDI($di);
            
            return $view;
        });
    }
}
