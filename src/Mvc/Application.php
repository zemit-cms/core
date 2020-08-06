<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc;

use Phalcon\Di\DiInterface;
use Phalcon\Http\ResponseInterface;

/**
 * Class Application
 * Switches default Phalcon MVC into a simple HMVC to allow requests
 * between different namespaces and modules
 * {@inheritdoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Mvc
 */
class Application extends \Phalcon\Mvc\Application
{
    /**
     * HMVC Application
     * {@inheritdoc}
     * @param \Phalcon\Di\DiInterface
     */
    public function __construct(DiInterface $di)
    {
        // Registering app itself as a service
        $di->setShared('application', $this);
        parent::__construct($di);
    }
    
    /**
     * HMVC request
     * You can request call any module/namespace
     *
     * @param array $location
     *
     * @return string
     */
    public function request(array $location = [])
    {
        // Get a unique dispatcher
        $dispatcher = clone $this->getDI()->get('dispatcher');
        
        // Route dispatcher
        $dispatcher->setNamespaceName($location['namespace'] ?? $dispatcher->getNamespaceName());
        $dispatcher->setModuleName($location['module'] ?? $dispatcher->getModuleName());
        $dispatcher->setControllerName($location['controller'] ?? 'index');
        $dispatcher->setActionName($location['action'] ?? 'index');
        $dispatcher->setParams($location['params'] ?? []);
        $dispatcher->dispatch();
        
        // Get and return value
        $response = $dispatcher->getReturnedValue();
        if ($response instanceof ResponseInterface) {
            return $response->getContent();
        }
        return $response;
    }
}
