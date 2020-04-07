<?php

namespace Zemit\Modules\Oauth2\Controllers;

use League\OAuth2\Client\Grant\RefreshToken;

class GoogleController extends AbstractController
{
    const DEFAULT_SCOPE = null;
    
    public $sessionKey = 'oauth2-google-state';
    
    /**
     * Redirect to Authorization Url
     *
     * @param null $scope
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function authorizationUrlAction($scope = null) {
        $redirectUrl = $this->oauth2Google->getAuthorizationUrl([
            'scope' => explode(',', $scope ?: $this->request->get('scope', 'string', self::DEFAULT_SCOPE))
        ]);
        $this->session->set($this->sessionKey, $this->oauth2Google->getState());
        return $this->response->redirect($redirectUrl);
    }
    
    /**
     * Validate State
     *
     * @param null $state
     *
     * @return bool
     */
    public function validateState($state = null) {
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
    public function getAccessToken($code = null) {
        $code ??= $this->request->get('code', 'string');
        return $this->oauth2Google->getAccessToken('authorization_code', ['code' => $code]);
    }
    
    /**
     * Refresh Token
     *
     * @param null $code
     *
     * @return mixed
     */
    public function refreshToken($refreshToken = null) {
        $refreshToken ??= $this->request->get('refreshToken', 'string');
        return $this->oauth2Facebook->getAccessToken(new RefreshToken(), ['code' => $refreshToken]);
    }
    
    /**
     * Use this to interact with an API on the users behalf
     *
     * @param $token
     *
     * @return mixed
     */
    public function getToken($token) {
        return $token->getToken();
    }
    
    /**
     * Use this to get a new access token if the old one expires
     *
     * @param $token
     *
     * @return mixed
     */
    public function getRefreshToken($token) {
        return $token->getRefreshToken();
    }
    
    /**
     * Unix timestamp at which the access token expires
     *
     * @param $token
     *
     * @return mixed
     */
    public function getExpires($token) {
        return $token->getExpires();
    }
    
    /**
     * @param null $token
     *
     * @return mixed
     */
    public function getResourceOwner($token = null) {
        $token ??= $this->getAccessToken();
        return $this->oauth2Google->getResourceOwner($token);
    }
}
