<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Oauth2Google;

use League\OAuth2\Client\Provider\Google;
use Phalcon\Di\DiInterface;
use Zemit\Bootstrap\Config;
use Zemit\Provider\AbstractServiceProvider;

/**
 * @link https://github.com/tegaphilip/padlock
 * @link https://oauth2.thephpleague.com/framework-integrations/
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'oauth2Google';
    
    #[\Override]
    public function register(DiInterface $di): void
    {
        $di->setShared($this->getName(), function () use ($di) {
    
            $config = $di->get('config');
            assert($config instanceof Config);

            $oauthConfig = $config->pathToArray('oauth2') ?? [];
            $oauthGoogleConfig = $oauthConfig['google'];
            
            return new Google($oauthGoogleConfig);
        });
    }
}
