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
    
    protected $bannerStyle = [
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
        $bannerStyle = $this->bannerStyle;
        
        $di->setShared($this->getName(), function () use ($bannerStyle, $di) {
            $flash = new Direct($bannerStyle);
            
            $flash->setAutoescape(true);
            $flash->setDI($di);
            $flash->setCssClasses($bannerStyle);
            
            return $flash;
        });
        
        $di->setShared('flashSession', function () use ($bannerStyle, $di) {
            $flash = new Session($bannerStyle);
            
            $flash->setAutoescape(true);
            $flash->setDI($di);
            $flash->setCssClasses($bannerStyle);
            
            return $flash;
        });
    }
}
