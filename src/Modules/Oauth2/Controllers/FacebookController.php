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
use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Phalcon\Db\Column;

/**
 * Class FacebookController
 *
 * @property Facebook $oauth2Facebook
 * @package Zemit\Modules\Oauth2\Controllers
 */
class FacebookController extends AbstractController
{
    const DEFAULT_SCOPE = 'email';
    
    public string $providerName = 'facebook';
    public string $sessionKey = 'oauth2-facebook-state';
    
    /**
     * Redirect to Authorization Url
     *
     * @param null $scope
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function authorizationUrlAction($scope = null)
    {
        $redirectUrl = $this->oauth2Facebook->getAuthorizationUrl([
            'scope' => explode(',', $scope ?: $this->request->get('scope', 'string', self::DEFAULT_SCOPE))
        ]);
        $this->session->set($this->sessionKey, $this->oauth2Facebook->getState());
        return $this->response->redirect($redirectUrl);
    }
    
    /**
     *
     */
    public function callbackAction() {
        // @todo
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
        return $this->oauth2Facebook->getAccessToken('authorization_code', ['code' => $code]);
    }
    
    /**
     * @param null $shortLivedAccessToken
     *
     * @return mixed
     */
    public function getLongLivedAccessToken($shortLivedAccessToken = null)
    {
        return $this->oauth2Facebook->getLongLivedAccessToken($shortLivedAccessToken);
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
        return $this->oauth2Facebook->getAccessToken(new RefreshToken(), ['code' => $refreshToken]);
    }
    
    /**
     * @param null $token
     *
     * @return ResourceOwnerInterface
     */
    public function getResourceOwner($token = null)
    {
        $token ??= $this->getAccessToken();
        return $this->oauth2Facebook->getResourceOwner($token);
    }
}
