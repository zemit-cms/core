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

use Zemit\Mvc\Application;

/**
 * Class Router
 * Default Bootstrap Phalcon Zemit Router Implementation
 * {@inheritDoc}
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Bootstrap
 */
class Router extends \Zemit\Mvc\Router
{
    public $defaults = [
        'namespace' => \Zemit\Modules\Frontend\Controller::class,
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index',
    ];
    
    public $notFound = [
        'controller' => 'error',
        'action' => 'notFound',
    ];
    
    /**
     * Router constructor.
     */
    public function __construct($defaultRoutes = true, $application = null)
    {
        parent::__construct($defaultRoutes, $application);
        
        $this->add('/', [
        ])->setName('default');
        
        $this->add('/:controller', [
            'controller' => 1,
        ])->setName('default-controller');
        
        $this->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2,
        ])->setName('default-controller-action');
        
//        $this->add('/:controller/:action/:slug', [
//            'controller' => 1,
//            'action' => 2,
//            'slug' => 3,
//        ])->setName('default-controller-action-slug');
//
//        $this->add('/:controller/:action/:int', [
//            'controller' => 1,
//            'action' => 2,
//            'int' => 3,
//        ])->setName('default-controller-action-int');
        
        foreach ($this->config->locale->allowed as $locale) {
            $this->add('/' . $locale, [
                'locale' => $locale,
            ])->setName($locale);
            
            $this->add('/' . $locale . '/:controller', [
                'locale' => $locale,
                'controller' => 1,
            ])->setName($locale);
            
            $this->add('/' . $locale . '/:controller/:action', [
                'locale' => $locale,
                'controller' => 1,
                'action' => 2,
            ])->setName($locale);
            
//            $this->add('/' . $locale . '/:controller/:action/:slug', [
//                'locale' => $locale,
//                'controller' => 1,
//                'action' => 2,
//                'slug' => 3,
//            ])->setName($locale);
//
//            $this->add('/' . $locale . '/:controller/:action/:int', [
//                'locale' => $locale,
//                'controller' => 1,
//                'action' => 2,
//                'int' => 3,
//            ])->setName($locale);
        }
        
        if (isset($application)) {
            $this->hostnamesRoutes();
            $this->modulesRoutes($application);
        }
    }
}
