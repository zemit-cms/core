<?php
declare(strict_types=1);

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Identity\Traits;

use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Filter\Filter;
use Zemit\Di\AbstractInjectable;

trait Jwt
{
    use AbstractInjectable;
    
    public array $claim = [];
    
    /**
     * Create or refresh a session
     * @throws ValidatorException|\Phalcon\Encryption\Security\Exception
     */
    public function getJwt(bool $refresh = false): array
    {
        $claim = $this->getClaim($refresh, $refresh);
        
        // this enables or disable the session fallback (not recommended to enable)
        $sessionFallback = $this->config->path('identity.sessionFallback', false);
        
        // undefined key, create a new one using uuid
        if (empty($claim['key'])) {
            $this->setClaim(['key' => $this->security->getRandom()->uuid()]);
            
            // save new key into session when using session fallback
            if ($sessionFallback) {
                $this->session->set($this->getSessionKey(), $claim);
            }
        }
        
        else if ($refresh) {
            // get session identity before
            $sessionIdentity = $this->getSessionIdentity();
            $this->removeSessionIdentity();
            
            // change the store key for a new one
            // this will invalidate the previous jwt tokens
            $this->setClaim(['key' => $this->security->getRandom()->uuid()]);
            
            // save the current session identity to the new key
            if (!empty($sessionIdentity)) {
                $this->setSessionIdentity($sessionIdentity);
            }
            
            // save new key into session when using session fallback
            if ($sessionFallback) {
                $this->session->set($this->getSessionKey(), $claim);
            }
        }
        
        // generate a new jwt using the store and jwt token options
        $tokenOptions = $this->config->pathToArray('identity.token') ?? [];
        $token = $this->getJwtToken($this->getSessionKey(), $this->claim, $tokenOptions);
        
        // generate a new refresh token using the store and refresh token options
        $refreshTokenOptions = $this->config->pathToArray('identity.refreshToken') ?? [];
        $refreshToken = $this->getJwtToken($this->getSessionKey(true), $this->claim, $refreshTokenOptions);
        
        return [
            'jwt' => $token,
            'refreshToken' => $refreshToken,
            'refreshed' => $refresh,
        ];
    }
    
    /**
     * Retrieve the store information based on various authentication methods:
     * - Cached store
     * - Refresh token
     * - JWT
     * - Authorization header
     * - Session fallback
     *
     * @param bool $force If true, forces fetching the store regardless of cache.
     * @return array The store information based on the available authentication method or an empty array if unsupported.
     */
    public function getClaim(bool $refresh = false, bool $force = false): array
    {
        // Using cached store
        if (!$force && !empty($this->claim)) {
            return $this->claim;
        }
        
        $json = $this->getJsonRawBody();
        
        if ($refresh) {
            $refreshToken = $this->request->get('refreshToken', [Filter::FILTER_STRING], $json->refreshToken ?? null);
            if (!empty($refreshToken)) {
                $this->setClaim($this->getClaimFromToken($refreshToken, $this->getSessionKey(true)));
                return $this->claim;
            }
        }
        
        // Using JWT
        $jwt = $this->request->get('jwt', [Filter::FILTER_STRING], $json->jwt ?? null);
        if (!empty($jwt)) {
            $this->setClaim($this->getClaimFromToken($jwt, $this->getSessionKey()));
            return $this->claim;
        }
        
        // Using X-Authorization Header (recommended)
        $authorizationHeaderKey = $this->config->path('identity.authorizationHeader', 'X-Authorization');
        $authorization = array_filter(explode(' ', $this->request->getHeader($authorizationHeaderKey)));
        if (!empty($authorization)) {
            $this->setClaim($this->getClaimFromAuthorization($authorization));
            return $this->claim;
        }
        
        // Using Session Fallback (less secure)
        if ($this->config->path('identity.sessionFallback', false) && $this->session->has($this->getSessionKey())) {
            $this->setClaim($this->session->get($this->getSessionKey()));
            return $this->claim;
        }
        
        // Unsupported authorization method
        return [];
    }
    
    /**
     * Set the store data.
     *
     * @param array $claim The data to be stored.
     * @return void
     */
    public function setClaim(array $claim): void
    {
        $this->claim = $claim;
    }
    
    /**
     * Generate a new JWT Token (string)
     * @throws ValidatorException
     */
    public function getJwtToken(string $id, array $data = [], array $options = []): string
    {
        $uri = $this->request->getScheme() . '://' . $this->request->getHttpHost();
        
        $options['issuer'] ??= $uri;
        $options['audience'] ??= $uri;
        $options['id'] ??= $id;
        $options['subject'] ??= json_encode($data);
        
        $builder = $this->jwt->builder($options);
        return $builder->getToken()->getToken();
    }
    
    /**
     * @param string $token
     * @param string|null $claim
     * @return array
     * @throws ValidatorException
     */
    public function getClaimFromToken(string $token, string $claim = null): array
    {
        $uri = $this->request->getScheme() . '://' . $this->request->getHttpHost();
        
        $token = $this->jwt->parseToken($token);
        
        $this->jwt->validateToken($token, 0, [
            'issuer' => $uri,
            'audience' => $uri,
            'id' => $claim,
        ]);
        $claims = $token->getClaims();
        
        $ret = $claims->has('sub') ? json_decode($claims->get('sub'), true) : [];
        return is_array($ret) ? $ret : [];
    }
    
    /**
     * Get key and token from authorization
     * @param array $authorization The authorization array, where the first element is the authorization type and the second element is the authorization token
     * @return array The key and token extracted from the authorization session claim. If the key or token is not found, null will be returned for that value.
     * @throws ValidatorException
     */
    public function getClaimFromAuthorization(array $authorization): array
    {
        $authorizationType = $authorization[0] ?? null;
        $authorizationToken = $authorization[1] ?? null;
        
        if ($authorizationType && $authorizationToken && strtolower($authorizationType) === 'bearer') {
            return $this->getClaimFromToken($authorizationToken, $this->getSessionKey());
        }
        
        return [];
    }
    
    private function getJsonRawBody()
    {
        try {
            return $this->request->getJsonRawBody();
        }
        catch (\InvalidArgumentException $e) {
            return new \stdClass();
        }
    }
}
