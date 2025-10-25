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
use Zemit\Config\ConfigInterface;
use Zemit\Http\Request;
use Zemit\Provider\AbstractServiceProvider;

/**
 * @link https://github.com/tegaphilip/padlock
 * @link https://oauth2.thephpleague.com/framework-integrations/
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'oauth2Facebook';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
    
            $config = $di->get('config');
            assert($config instanceof ConfigInterface);
    
            $session = $di->get('session');
            assert($session instanceof Manager);
    
            $request = $di->get('request');
            assert($request instanceof Request);
            
            $oauthConfig = $config->pathToArray('oauth2') ?? [];
            $oauthFacebookConfig = $oauthConfig['facebook'] ?? [];
            
            // Set the full url
            $secure = $request->isSecure();
            $scheme = $request->getScheme() . '://';
            $host = $request->getHttpHost();
            $port = $request->getPort();
            $defaultPort = $secure ? 443 : 80;
            $port = $port !== $defaultPort? ':' . $port : null;
            $oauthFacebookConfig['redirectUri'] = $scheme . $host . $port . ($oauthFacebookConfig['redirectUri'] ?: '');
            
            return new Facebook($oauthFacebookConfig);
        });
    }
}
