<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Router;

use Phalcon\Mvc\Router\Group as RouterGroup;
use Zemit\Utils\Slug;

class ModuleRoute extends RouterGroup
{
    public array $locale;
    
    public function __construct($paths = null, array $locale = [], ?string $hostname = null)
    {
        $this->locale = $locale;
        if (isset($hostname)) {
            $this->setHostname($hostname);
        }
        parent::__construct($paths);
    }
    
    public function initialize(): void
    {
        $hostname = $this->getHostname();
        $path = $this->getPaths();
        $module = $path['module'];
        $routePrefix = $hostname ? '' : '/' . $module;
        $namePrefix = $hostname ? Slug::generate($hostname) : $module;
        
        $this->add($routePrefix ?: '/', [
        ])->setName($namePrefix);
        
        $this->add($routePrefix . '/:controller', [
            'controller' => 1,
        ])->setName($namePrefix . '-controller');
        
        $this->add($routePrefix . '/:controller/:action/:params', [
            'controller' => 1,
            'action' => 2,
            'params' => 3,
        ])->setName($namePrefix . '-controller-action');
        
        if (!empty($this->locale)) {
            $localeRegex = '{locale:(' . implode('|', $this->locale) . ')}';
            
            $routePrefix = '/' . $localeRegex . '/' . $module;
            $namePrefix = 'locale-' . $module;
            
            $this->add($routePrefix, [
                'locale' => 1,
            ])->setName($namePrefix);
            
            $this->add($routePrefix . '/:controller', [
                'locale' => 1,
                'controller' => 2,
            ])->setName($namePrefix . '-controller');
            
            $this->add($routePrefix . '/:controller/:action/:params', [
                'locale' => 1,
                'controller' => 2,
                'action' => 3,
                'params' => 4,
            ])->setName($namePrefix . '-controller-action');
            
            foreach ($this->locale as $locale) {
                $localeRegex = $locale;
                
                $routePrefix = '/' . $localeRegex . '/' . $module;
                $namePrefix = $locale . '-' . $module;
                
                $this->add($routePrefix, [
                    'locale' => $locale,
                ])->setName($namePrefix);
                
                $this->add($routePrefix . '/:controller', [
                    'locale' => $locale,
                    'controller' => 1,
                ])->setName($namePrefix . '-controller');
                
                $this->add($routePrefix . '/:controller/:action/:params', [
                    'locale' => $locale,
                    'controller' => 1,
                    'action' => 2,
                    'params' => 3,
                ])->setName($namePrefix . '-controller-action');
            }
        }
    }
}
