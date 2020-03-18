<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Url;

use Phalcon\Di\DiInterface;
use Zemit\Url;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Zemit\Provider\UrlResolver\ServiceProvider
 *
 * @package Zemit\Provider\UrlResolver
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'url';
    
    /**
     * {@inheritdoc}
     * The URL component is used to generate all kind of urls in the application.
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function() use ($di) {
            $config = $di->get('config')->app;
            $router = $di->get('router');
            
            $url = new Url($router);
            $url->setStaticBaseUri($config->staticUri ?? '/');
            $url->setBaseUri($config->uri ?? '/');
            
            return $url;
        });
        
        $di->setShared('slug', ['className' => Slug::class]);
    }
}
