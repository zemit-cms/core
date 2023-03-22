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
        
        $this->add('/:controller/:action/:params', [
            'controller' => 1,
            'action' => 2,
            'params' => 3,
        ])->setName('default-controller-action');
        
        $localeConfig = $this->config->locale->toArray();
        if (!empty($localeConfig['allowed'])) {
            $localeRegex = '{locale:(' . implode('|', $localeConfig['allowed']) . ')}';
            
            $this->add('/' . $localeRegex, [
                'locale' => 1,
            ])->setName('locale');
    
            $this->add('/' . $localeRegex . '/:controller', [
                'locale' => 1,
                'controller' => 2,
            ])->setName('locale-controller');
    
            $this->add('/' . $localeRegex . '/:controller/:action/:params', [
                'locale' => 1,
                'controller' => 2,
                'action' => 3,
                'params' => 4,
            ])->setName('locale-controller-action');
        }
        
        foreach ($localeConfig['allowed'] as $locale) {
            $localeRegex = $locale;
            
            $this->add('/' . $localeRegex, [
                'locale' => $locale,
            ])->setName($locale);
            
            $this->add('/' . $localeRegex . '/:controller', [
                'locale' => $locale,
                'controller' => 1,
            ])->setName($locale . '-controller');
            
            $this->add('/' . $localeRegex . '/:controller/:action/:params', [
                'locale' => $locale,
                'controller' => 1,
                'action' => 2,
                'params' => 3,
            ])->setName($locale . '-controller-action');
        }
    
        if (isset($application)) {
            $this->hostnamesRoutes();
            $this->modulesRoutes($application);
        }
    }
}
