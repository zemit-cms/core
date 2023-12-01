<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Provider\Oauth2Server;

use Phalcon\Di\DiInterface;
use Zemit\Provider\AbstractServiceProvider;
use Zemit\Utils\Env;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ImplicitGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;

/**
 * @todo
 * @link https://github.com/tegaphilip/padlock
 * @link https://oauth2.thephpleague.com/framework-integrations/
 */
class ServiceProvider extends AbstractServiceProvider
{
    protected string $serviceName = 'oauth2Server';
    
    public function register(DiInterface $di): void
    {
        $config = $di->get('config');
        $di->setShared($this->getName(), function () use ($config) {
            
            $clientRepository = new ClientRepository();
            $scopeRepository = new ScopeRepository();
            $accessTokenRepository = new AccessTokenRepository();
            $userRepository = new UserRepository();
            $refreshTokenRepository = new RefreshTokenRepository();
            $authCodeRepository = new AuthCodeRepository();
            
            // Setup the authorization server
            $server = new AuthorizationServer($clientRepository, $accessTokenRepository, $scopeRepository, new CryptKey(Env::get('PRIVATE_KEY_PATH'), Env::get('PRIVATE_KEY_PASSPHRASE'), Env::get('PRIVATE_KEY_PERMISSION_CHECK', false)), Env::get('ENCRYPTION_KEY'));
            $passwordGrant = new PasswordGrant($userRepository, $refreshTokenRepository);
            $passwordGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);
            $authCodeGrant = new AuthCodeGrant($authCodeRepository, $refreshTokenRepository, $config->oauth->auth_code_lifespan);
            $refreshTokenGrant = new RefreshTokenGrant($refreshTokenRepository);
            $refreshTokenGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);
            
            // Enable the refresh token grant on the server
            $server->enableGrantType($refreshTokenGrant, $config->oauth->access_token_lifespan);
            $authCodeGrant->setRefreshTokenTTL($config->oauth->refresh_token_lifespan);
            
            // Enable the authentication code grant on the server
            $server->enableGrantType($authCodeGrant, $config->oauth->access_token_lifespan);
            
            // Enable the password grant on the server
            $server->enableGrantType($passwordGrant, $config->oauth->access_token_lifespan);
            
            // Enable the client credentials grant on the server
            $server->enableGrantType(new ClientCredentialsGrant(), $config->oauth->access_token_lifespan);
            
            // Enable the implicit grant on the server
            $server->enableGrantType(new ImplicitGrant($config->oauth->access_token_lifespan), $config->oauth->access_token_lifespan);
            
            return $server;
        });
    }
}
