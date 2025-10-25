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

use Phalcon\Di\DiInterface;
use Phalcon\Events\Manager;
use Zemit\Mvc\View;
use Zemit\Mvc\View\Error;
use Zemit\Config\ConfigInterface;
use Zemit\Provider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'view';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function (?array $options = null) use ($di) {
    
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
            
            $eventsManager = $di->get('eventsManager');
            assert($eventsManager instanceof Manager);
            
            $options ??= $config->pathToArray('view', []);
            
            $error = new Error();
            $error->setDI($di);
            
            $eventsManager->attach('view', $error);
            
            $view = new View();
            $view->setMinify($options['minify'] ?? false);
            
            $view->registerEngines($options['engines'] ?? [
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
                '.volt' => 'Phalcon\Mvc\View\Engine\Volt',
            ]);
            
            $view->setEventsManager($eventsManager);
            $view->setDI($di);
            
            return $view;
        });
    }
}
