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
use League\OAuth2\Client\Provider\Client;

/**
 * Class ClientController
 *
 * @property Client $oauth2Client
 * @package Zemit\Modules\Oauth2\Controllers
 */
class ClientController extends AbstractController
{
    const DEFAULT_SCOPE = null;
    
    public string $sessionKey = 'oauth2-client-state';
    
    /**
     * Redirect to Authorization Url
     *
     * @param null $scope
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function authorizationUrlAction($scope = null)
    {
        $redirectUrl = $this->oauth2Client->getAuthorizationUrl([
            'scope' => explode(',', $scope ?: $this->request->get('scope', 'string', self::DEFAULT_SCOPE))
        ]);
        $this->session->set($this->sessionKey, $this->oauth2Client->getState());
        return $this->response->redirect($redirectUrl);
    }
    
    /**
     * Validate State
     *
     * @param null $state
     *
     * @return bool
     */
    public function validateState($state = null)
    {
        $state ??= $this->request->get('state', 'string');
        
        if (empty($state) || !$this->session->has($this->sessionKey)) {
            return false;
        }
        
        return $state === $this->session->get($this->sessionKey);
    }
    
    /**
     * Get Access Token
     *
     * @param null $code
     *
     * @return mixed
     */
    public function getAccessToken($code = null)
    {
        $code ??= $this->request->get('code', 'string');
        return $this->oauth2Client->getAccessToken('authorization_code', ['code' => $code]);
    }
    
    /**
     * Refresh Token
     *
     * @param null $code
     *
     * @return mixed
     */
    public function refreshToken($refreshToken = null)
    {
        $refreshToken ??= $this->request->get('refreshToken', 'string');
        return $this->oauth2Client->getAccessToken(new RefreshToken(), ['code' => $refreshToken]);
    }
    
    /**
     * Use this to interact with an API on the users behalf
     *
     * @param $token
     *
     * @return mixed
     */
    public function getToken($token)
    {
        return $token->getToken();
    }
    
    /**
     * Use this to get a new access token if the old one expires
     *
     * @param $token
     *
     * @return mixed
     */
    public function getRefreshToken($token)
    {
        return $token->getRefreshToken();
    }
    
    /**
     * Unix timestamp at which the access token expires
     *
     * @param $token
     *
     * @return mixed
     */
    public function getExpires($token)
    {
        return $token->getExpires();
    }
    
    /**
     * @param null $token
     *
     * @return mixed
     */
    public function getResourceOwner($token = null)
    {
        $token ??= $this->getAccessToken();
        return $this->oauth2Client->getResourceOwner($token);
    }
}
