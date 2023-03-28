<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Oauth2\Controllers;

use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Phalcon\Http\ResponseInterface;
use Zemit\Modules\Oauth2\Controller;

/**
 * @property GenericProvider $oauth2Provider
 */
abstract class AbstractController extends Controller
{
    public const PROVIDER_CLIENT = 'client';
    public const PROVIDER_FACEBOOK = 'facebook';
    public const PROVIDER_GITHUB = 'github';
    public const PROVIDER_GOOGLE = 'google';
    public const PROVIDER_INSTAGRAM = 'instagram';
    public const PROVIDER_LINKEDIN = 'linkedin';
    
    public string $defaultScope = 'email';
    
    public string $providerName = self::PROVIDER_CLIENT;
    
    public string $sessionKey = 'oauth2-generic-state';
    
    /**
     * Redirect to Authorization Url
     */
    public function authorizationUrlAction(?string $scope = null): ResponseInterface
    {
        $redirectUrl = $this->oauth2Provider->getAuthorizationUrl([
            'scope' => explode(',', $scope ?: $this->request->get('scope', 'string', $this->defaultScope)),
        ]);
        $this->session->set($this->sessionKey, $this->oauth2Provider->getState());
        return $this->response->redirect($redirectUrl);
    }
    
    /**
     * Validate State
     */
    public function validateState(?string $state = null): bool
    {
        $state ??= $this->request->get('state', 'string');
        if (empty($state) || !$this->session->has($this->sessionKey)) {
            return false;
        }
        
        return $state === $this->session->get($this->sessionKey);
    }
    
    /**
     * Get Access Token
     * @throws IdentityProviderException
     */
    public function getAccessToken(?string $code = null): AccessTokenInterface
    {
        $code ??= $this->request->get('code', 'string');
        return $this->oauth2Provider->getAccessToken('authorization_code', ['code' => $code]);
    }
    
    /**
     * Refresh Token
     * @throws IdentityProviderException
     */
    public function refreshToken(?string $refreshToken = null): AccessTokenInterface
    {
        $refreshToken ??= $this->request->get('refreshToken', 'string');
        return $this->oauth2Provider->getAccessToken(new RefreshToken(), ['code' => $refreshToken]);
    }
    
    /**
     * Use this to interact with an API on the users behalf
     */
    public function getToken(AccessTokenInterface $token): string
    {
        return $token->getToken();
    }
    
    /**
     * Use this to get a new access token if the old one expires
     */
    public function getRefreshToken(AccessTokenInterface $token): ?string
    {
        return $token->getRefreshToken();
    }
    
    /**
     * Unix timestamp at which the access token expires
     */
    public function getExpires(AccessTokenInterface $token): ?int
    {
        return $token->getExpires();
    }
    
    /**
     * Requests and returns the resource owner of given access token.
     */
    public function getResourceOwner(AccessToken $token): ResourceOwnerInterface
    {
        return $this->oauth2Provider->getResourceOwner($token);
    }
}
