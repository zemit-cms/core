<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Flash;

use Phalcon\Flash\Direct;
use Phalcon\Flash\Session;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\Flash\ServiceProvider
 *
 * @package Zemit\Provider\Flash
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'flash';
    
    protected $cssStyle = [
        'error' => 'alert alert-danger fade in',
        'success' => 'alert alert-success fade in',
        'notice' => 'alert alert-info fade in',
        'warning' => 'alert alert-warning fade in',
    ];
    
    /**
     * {@inheritdoc}
     *
     * Register the Flash Service with the Twitter Bootstrap classes.
     *
     * @return void
     */
    public function register(\Phalcon\Di\DiInterface $di): void
    {
        $cssStyle = $this->cssStyle;
        
        $di->setShared($this->getName(), function () use ($di, $cssStyle) {
            $flash = new Direct();
    
            $flash->setAutoescape(true);
            $flash->setDI($di);
            $flash->setCssClasses($cssStyle);
            
            return $flash;
        });
        
        // @todo flash session in its own service provider
//        $di->setShared($this->getName() . 'Session', function () use ($di, $cssStyle) {
//            $flash = new Session();
//
//            $flash->setAutoescape(true);
//            $flash->setDI($di);
//            $flash->setCssClasses($cssStyle);
//
//            return $flash;
//        });
    }
}
