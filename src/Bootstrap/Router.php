<?php

namespace Zemit\Core\Bootstrap;

use Phalcon\Mvc\Router as PhalconRouter;
use Phalcon\Application;
use Phalcon\Text;
use Zemit\Core\Mvc\Router\ModuleRoute;
use Zemit\Core\Zemit;

class Router extends PhalconRouter
{
    public $defaults = [
        'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index'
    ];
    
    public $notFound = [
        'controller' => 'errors',
        'action' => 'notFound'
    ];
    
    public $config;
    
    public $test = [
        // ----------------------------------------------------
        // default routing
        '/' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index',
            'params' => []
        ],
        // /:controller
        '/controller' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => []
        ],
        // /:controller/:action
        '/controller/action' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => []
        ],
        // /:controller/:action/:slug
        '/controller/action/slug' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug', 'locale' => '']
        ],
        // /:controller/:action/:int
        '/controller/action/1' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['int' => '1']
        ],
        // /:module
        '/backend' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index',
            'params' => []
        ],
        // /:module/:controller
        '/backend/controller' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => ['locale' => '']
        ],
        // /:module/:controller/:action
        '/backend/controller/action' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['locale' => '']
        ],
        // /:module/:controller/:action/:slug
        '/backend/controller/action/slug' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug', 'locale' => '']
        ],
        // /:module/:controller/:action/:int
        '/backend/controller/action/1' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['int' => '1', 'locale' => '']
        ],
        // ----------------------------------------------------
        // /:locale
        '/fr' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'index',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:controller
        '/fr/controller' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:controller/:action
        '/fr/controller/action' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:controller/:action/:slug
        '/fr/controller/action/slug' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug', 'locale' => 'fr']
        ],
        // /:locale/:controller/:action/:int
        '/fr/controller/action/1' => [
            'namespace' => 'Zemit\\Core\\Frontend\\Controllers',
            'module' => 'frontend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['locale' => 'fr', 'int' => '1']
        ],
        // /:locale/:module
        '/fr/backend' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:module/:controller
        '/fr/backend/controller' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'index',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:module/:controller/:action
        '/fr/backend/controller/action' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['locale' => 'fr']
        ],
        // /:locale/:module/:controller/:action/:slug
        '/fr/backend/controller/action/slug' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['slug' => 'slug', 'locale' => 'fr']
        ],
        // /:locale/:module/:controller/:action/:int
        '/fr/backend/controller/action/1' => [
            'namespace' => 'Zemit\\Core\\Backend\\Controllers',
            'module' => 'backend',
            'controller' => 'controller',
            'action' => 'action',
            'params' => ['int' => '1', 'locale' => 'fr']
        ],
        // out of range routes (for now)
        '/frontrller/action/slug/params' => false,
        '/frontrller/action/1/params' => false,
        '/controller/action/slug/params' => false,
        '/controller/action/1/params' => false,
        '/frfrontend/controller/action/1' => false,
        '/enbackend/controller/action/1' => false,
        '/en/backend/controller/action/1/not-found' => false,
        '/backend/controller/action/1/not-found' => false,
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
    
        $this->add('/:controller', [
            'controller' => 1
        ])->setName('default');
        
        $this->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2,
        ])->setName('default');
    
        $this->add('/:controller/:action/:slug', [
            'controller' => 1,
            'action' => 2,
            'slug' => 3,
        ])->setName('default');
        
        $this->add('/:controller/:action/:int', [
            'controller' => 1,
            'action' => 2,
            'int' => 3,
        ])->setName('default');
        
        foreach ($this->config->locale->allowed as $locale) {
            $this->add('/' . $locale . '[/]{0,1}', [
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
        die();
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
            $namespace = str_replace('Module', 'Controllers', $module['className']);
            $this->mount(new ModuleRoute(array_merge($defaults, ['namespace' => $namespace, 'module' => $key])));
        }
    }
    
    public function camelize($string)
    {
        return lcfirst(Text::camelize(Text::uncamelize($string)));
    }
}
