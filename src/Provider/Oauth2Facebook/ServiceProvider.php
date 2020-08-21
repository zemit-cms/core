<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Oauth2Facebook;

use League\OAuth2\Client\Provider\Facebook;
use Phalcon\Di\DiInterface;

use Phalcon\Session\Manager;
use Phalcon\Config;
use Zemit\Http\Request;
use Zemit\Provider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @link https://github.com/tegaphilip/padlock
 * @link https://oauth2.thephpleague.com/framework-integrations/
 *
 * @author Julien Turbide <jturbide@nuagerie.com>
 * @copyright Zemit Team <contact@zemit.com>
 *
 * @since 1.0
 * @version 1.0
 *
 * @package Zemit\Provider\Oauth2Facebook
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'oauth2Facebook';
    
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $config */
        $config = $di->get('config');
        
        /** @var Manager $session */
        $session = $di->get('session');
        
        /** @var Request $request */
        $request = $di->get('request');
        
        $di->setShared($this->getName(), function() use ($config, $request) {
            $settings = $config->path('oauth2.facebook', []);
            $settings = $settings instanceof Config? $settings->toArray() : $settings;
    
            // Set the full url
            $secure = $request->isSecure();
            $scheme = $request->getScheme() . '://';
            $host = $request->getHttpHost();
            $port = $request->getPort();
            $port = !in_array($port, [$secure? '443' : '80'])? ':' . $port : null;
            $settings['redirectUri'] = $scheme . $host . $port . '/' . ($settings['redirectUri'] ?: '');
            
            $facebook = new Facebook($settings);
            return $facebook;
        });
    }
}
