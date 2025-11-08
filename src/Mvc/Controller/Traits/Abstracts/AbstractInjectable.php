<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Controller\Traits\Abstracts;

use Phalcon\Autoload\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Http\Response;
use PhalconKit\Acl\Acl;
use PhalconKit\Filter\Filter;
use PhalconKit\Http\Request;
use PhalconKit\Identity\Manager as Identity;
use PhalconKit\Mvc\Dispatcher;
use PhalconKit\Mvc\Model\Manager as ModelsManager;
use PhalconKit\Mvc\Router;
use PhalconKit\Mvc\View;
use PhalconKit\Support\HelperFactory;

/**
 * Trait AbstractInjectable
 *
 * This trait provides a common interface for classes that are injectable
 * and depend on a dependency injection container.
 *
 * @property Loader $loader
 * @property View $view
 * @property Router $router
 * @property Response $response
 * @property Request $request
 * @property Filter $filter
 * @property Dispatcher $dispatcher
 * @property ModelsManager $modelsManager
 * @property EventsManager $eventsManager
 * @property Identity $identity
 * @property HelperFactory $helper
 * @property Acl $acl
 */
trait AbstractInjectable
{
    abstract public function setDI(DiInterface $di): void;
    
    abstract public function getDI(): DiInterface;
}
