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

use Zemit\Modules\Frontend\Controller;
use Zemit\Mvc\Application;
use Zemit\Mvc\Router\ModuleRoute;

/**
 * Class Router
 * @package Zemit\Bootstrap
 */
class Router extends \Phalcon\Mvc\Router
{
    public $defaults = [
        'namespace' => Controller::class,
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index'
    ];
    
    public $notFound = [
        'controller' => 'error',
        'action' => 'notFound'
    ];
    
    public $config;
    
    public $test = [
        // ----------------------------------------------------
        // default routing
        '/' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index',
            'params' => []
        ],
        // /:controller
        '/controller' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => []
        ],
        // /:controller/:action
        '/controller/action' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => []
        ],
        // /:controller/:action/:slug
        '/controller/action/slug' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug']
        ],
        // /:controller/:action/:int
        '/controller/action/1' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['int' => '1']
        ],
        // /:module
        '/backend' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index',
            'params' => []
        ],
        // /:module/:controller
        '/backend/controller' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => []
        ],
        // /:module/:controller/:action
        '/backend/controller/action' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => []
        ],
        // /:module/:controller/:action/:slug
        '/backend/controller/action/slug' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug']
        ],
        // /:module/:controller/:action/:int
        '/backend/controller/action/1' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['int' => '1']
        ],
        // ----------------------------------------------------
        // /:locale
        '/fr' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:controller
        '/fr/controller' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:controller/:action
        '/fr/controller/action' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:controller/:action/:slug
        '/fr/controller/action/slug' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug', 'locale' => 'fr']
        ],
        // /:locale/:controller/:action/:int
        '/fr/controller/action/1' => [
            'namespace' => 'Zemit\\Modules\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['locale' => 'fr', 'int' => '1']
        ],
        // /:locale/:module
        '/fr/backend' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:module/:controller
        '/fr/backend/controller' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:module/:controller/:action
        '/fr/backend/controller/action' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:module/:controller/:action/:slug
        '/fr/backend/controller/action/slug' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug', 'locale' => 'fr']
        ],
        // /:locale/:module/:controller/:action/:int
        '/fr/backend/controller/action/1' => [
            'namespace' => 'Zemit\\Modules\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['int' => '1', 'locale' => 'fr']
        ],
        // out of range routes (for now)
//        '/frontroller/action/slug/params' => false,
//        '/frontroller/action/1/params' => false,
//        '/controller/action/slug/params' => false,
//        '/controller/action/1/params' => false,
//        '/frfrontend/controller/action/1' => false,
//        '/enbackend/controller/action/1' => false,
//        '/en/backend/controller/action/1/not-found' => false,
//        '/backend/controller/action/1/not-found' => false,
    ];
    
    /**
     * Router constructor.
     */
    public function __construct($defaultRoutes = true, Application $application = null)
    {
        parent::__construct(false);
        if (isset($application)) {
            $this->config = $application->getDI()->get('config');
        }
        $this->defaultRoutes();
    
        $this->add('/', [
        ])->setName('default');
        
        $this->add('/:controller', [
            'controller' => 1
        ])->setName('default-controller');
        
        $this->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2,
        ])->setName('default-controller-action');
    
        $this->add('/:controller/:action/:slug', [
            'controller' => 1,
            'action' => 2,
            'slug' => 3,
        ])->setName('default-controller-action-slug');
        
        $this->add('/:controller/:action/:int', [
            'controller' => 1,
            'action' => 2,
            'int' => 3,
        ])->setName('default-controller-action-int');
        
        foreach ($this->config->locale->allowed as $locale) {
            $this->add('/' . $locale, [
                'locale' => $locale
            ])->setName($locale);
            
            $this->add('/' . $locale . '/:controller', [
                'locale' => $locale,
                'controller' => 1
            ])->setName($locale);
            
            $this->add('/' . $locale . '/:controller/:action', [
                'locale' => $locale,
                'controller' => 1,
                'action' => 2
            ])->setName($locale);
    
            $this->add('/' . $locale . '/:controller/:action/:slug', [
                'locale' => $locale,
                'controller' => 1,
                'action' => 2,
                'slug' => 3
            ])->setName($locale);
    
            $this->add('/' . $locale . '/:controller/:action/:int', [
                'locale' => $locale,
                'controller' => 1,
                'action' => 2,
                'int' => 3
            ])->setName($locale);
        }
    
        if (isset($application)) {
            $this->modulesRoutes($application);
        }
        
//        $this->testRoutes($this->test);
    }
    
    public function testRoutes($routes = []) {
        foreach ($routes as $test => $result) {
            foreach (['', '/'] as $end) {
                $this->handle($test . $end);
                if ($this->wasMatched()) {
                    $matchedResult = [
                        'namespace' => $this->getNamespaceName(),
                        'module' => $this->getModuleName(),
                        'controller' => $this->getControllerName(),
                        'action' => $this->getActionName(),
                        'params' => $this->getParams(),
                    ];
                    if (json_encode($matchedResult) !== json_encode($result)) {
                        print_r([
                            'route' => 'WRONG MATCH - ' . $test . $end,
                            'matchedRouteName' => $this->getMatchedRoute()->getName(),
                            'matched' => $matchedResult,
                            'expected' => $result
                        ]);
                    }
                    else {
//                    print_r([
//                        'route' => 'OK - ' . $test . $end,
////                        'matched' => $matchedResult,
////                        'expected' => $result
//                    ]);
                    }
                }
                else {
                    if ($result) {
                        print_r([
                            'route' => (!$result? 'OK' : 'NOT') . ' - ' . $test . $end,
                        ]);
                    }
                }
            }
        }
    }
    
    /**
     * Default routes
     * - Default namespace
     * - Default controller
     * - Default action
     * - Default notFound
     * - No module (not yet well supported)
     */
    public function defaultRoutes()
    {
        $this->removeExtraSlashes(true);
        $this->setDefaults($this->config->router->defaults->toArray()?: $this->defaults);
        $this->notFound($this->config->router->notFound->toArray()?: $this->notFound);
        $this->mount(new ModuleRoute($this->getDefaults(), true));
        $this->mount(new ModuleRoute($this->getDefaults(), true, true));
    }
    
    /**
     * Defines our frontend routes
     * /controller/action/params
     */
    public function modulesRoutes(Application $application)
    {
        $defaults = $this->getDefaults();
        foreach ($application->getModules() as $key => $module) {
            if (!isset($module['className'])) {
                throw new \InvalidArgumentException('Module parameter "className" must be a string under "' . $key . '"');
            }
            $namespace = rtrim($module['className'], 'Module') . 'Controllers';
            $this->mount(new ModuleRoute(array_merge($defaults, ['namespace' => $namespace, 'module' => $key])));
            $this->mount(new ModuleRoute(array_merge($defaults, ['namespace' => $namespace, 'module' => $key]), false, true));
        }
    }
}
