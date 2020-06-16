<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Ecdsa\Sha512;
use Phalcon\Acl\Role;
use Phalcon\Di\Injectable;
use Phalcon\Messages\Message;
use Phalcon\Validation\Validator\PresenceOf;
use Zemit\Models\User;

class Identity extends Injectable
{
    /**
     * Without encryption
     */
    const MODE_DEFAULT = self::MODE_JWT;
    
    /**
     * Without encryption (raw string into the session)
     */
    const MODE_STRING = 'string';
    
    /**
     * Store using JWT (jwt encrypted into the session)
     */
    const MODE_JWT = 'jwt';
    
    /**
     * Locale mode for the prepare fonction
     * @var string
     */
    public string $mode = self::MODE_DEFAULT;
    
    /**
     * @var mixed|string|null
     */
    public $sessionKey = 'zemit-identity';
    
    /**
     * @var array
     */
    public $options = [];
    
    /**
     * @var string|int|bool|null
     */
    public $identity;
    
    public function __construct($options = [])
    {
        $this->setOptions($options);
        $this->sessionKey = $this->getOption('sessionKey', $this->sessionKey);
        $this->setMode($this->getOption('mode', $this->mode));
//        $this->set($this->getFromSession());
    }
    
    /**
     * Set default options
     *
     * @param array $options
     */
    public function setOptions($options = [])
    {
        $this->options = $options;
    }
    
    /**
     * Getting an option value from the key, allowing to specify a default value
     *
     * @param $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function getOption($key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }
    
    /**
     * @return string
     */
    public function getSessionClass()
    {
        return $this->getOption('sessionClass') ?? \Zemit\Models\Session::class;
    }
    
    /**
     * @return string
     */
    public function getUserClass()
    {
        return $this->getOption('userClass') ?? \Zemit\Models\User::class;
    }
    
    /**
     * @return string
     */
    public function getGroupClass()
    {
        return $this->getOption('groupClass') ?? \Zemit\Models\Group::class;
    }
    
    /**
     * @return string
     */
    public function getRoleClass()
    {
        return $this->getOption('roleClass') ?? \Zemit\Models\Role::class;
    }
    
    /**
     * @return string
     */
    public function getTypeClass()
    {
        return $this->getOption('roleClass') ?? \Zemit\Models\Type::class;
    }
    
    /**
     * Get the current mode
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
    
    /**
     * Set the mode
     *
     * @param string $mode
     *
     * @throws \Exception Throw an exception if the mode is not supported
     */
    public function setMode($mode)
    {
        switch($mode) {
            case self::MODE_STRING:
            case self::MODE_JWT:
                $this->mode = $mode;
                break;
            default:
                throw new \Exception('Identity mode `' . $mode . '` is not supported.');
                break;
        }
    }
    
    /**
     * @return bool|mixed
     */
    public function getFromSession()
    {
        $ret = $this->session->has($this->sessionKey) ? $ret = $this->session->get($this->sessionKey) : null;
        
        if ($ret) {
            switch($this->mode) {
                case self::MODE_DEFAULT:
                    break;
                case self::MODE_JWT:
                    $ret = $this->jwt->parseToken($ret)->getClaim('identity');
                    break;
            }
        }
        
        return json_decode($ret);
    }
    
    /**
     * Save an identity into the session
     *
     * @param int|string|null $identity
     */
    public function setIntoSession($identity)
    {
        
        $identity = json_encode($identity);
        
        $token = null;
        switch($this->mode) {
            case self::MODE_JWT:
                $token = $this->jwt->getToken(['identity' => $identity]);
                break;
        }
        
        $this->session->set($this->sessionKey, $token ? : $identity);
    }
    
    /**
     * Set an identity
     *
     * @param int|string|null $identity
     */
    public function set($identity)
    {
        $this->setIntoSession($identity);
        $this->identity = $identity;
    }
    
    /**
     * Get the current identity
     * @return int|string|null
     */
    public function get()
    {
        $this->identity ??= $this->getFromSession();
        
        return $this->identity;
    }
    
    /**
     * @param null $roles
     *
     * @return bool
     */
    public function hasRole($roles = null, $or = false)
    {
        return $this->has($roles, $this->getUser()->getSlugs(), $or);
    }
    
    /**
     * Return the current user ID
     *
     * @return string|int|bool
     */
    public function getUserId()
    {
        return false;
    }
    
    /**
     * Check if the needles meet the haystack using nested arrays
     * Reversing ANDs and ORs within each nested subarray
     *
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), true); // 'dev' OR 'admin'
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), false); // 'dev' ADN 'admin'
     *
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles()); // 'dev' AND 'admin'
     * $this->has([['dev', 'admin']], $this->getUser()->getRoles()); // 'dev' OR 'admin'
     * $this->has([[['dev', 'admin']]], $this->getUser()->getRoles()); // 'dev' AND 'admin'
     *
     * @param array|string|null $needles Needles to match and meet the rules
     * @param array $haystack Haystack array to search into
     * @param bool $or True to force with "OR" , false to force "AND" condition
     *
     * @return bool Return true or false if the needles rules are being met
     */
    public function has($needles = null, array $haystack = [], $or = false)
    {
        $result = [];
        foreach ([...$needles] as $needle) {
            if (is_array($needle)) {
                $result [] = $this->has($needle, $haystack, !$or);
            }
            else {
                $result [] = in_array($needle, $haystack, true);
            }
        }
        
        return $or ?
            !in_array(false, $result, true) :
            in_array(true, $result, true);
    }
    
    /**
     * Create a refresh a session
     *
     * @param bool $refresh
     *
     * @throws \Phalcon\Security\Exception
     */
    public function getJwt($refresh = false)
    {
        [$key, $token] = $this->getKeyToken();
        
        $key ??= $this->security->getRandom()->uuid();
        $token ??= $this->security->getRandom()->hex(512);
        
        $sessionClass = $this->getSessionClass();
        $session = $this->getSession($key, $token) ? : new $sessionClass();
        
        if ($session && $refresh) {
            $token = $this->security->getRandom()->hex(512);
        }
        
        $session->setKey($key);
        $session->setToken($session->hash($key . $token));
        $session->setDate(date('Y-m-d H:i:s'));
        $store = ['key' => $session->getKey(), 'token' => $token];
        
        ($save = $session->save()) ?
            $this->session->set($this->sessionKey, $store) :
            $this->session->remove($this->sessionKey);
        
        return [
            'saved' => $save,
            'stored' => $this->session->has($this->sessionKey),
            'refreshed' => $save && $refresh,
            'validated' => $session->checkHash($session->getToken(), $session->getKey() . $token),
            'messages' => $session ? $session->getMessages() : [],
            'jwt' => $this->getJwtToken($this->sessionKey, $store),
        ];
    }
    
    /**
     * Return true if the user is currently logged in
     * @return bool
     */
    public function isLoggedIn()
    {
        return !!$this->getUser();
    }
    
    /**
     * Get the User related to the current session
     *
     * @return User|bool
     */
    public function getUser()
    {
        $session = $this->getSession(...$this->getKeyToken());
        $user = $session ? $session->getRelated('User') : false;
        
        return $user ?? false;
    }
    
    /**
     * Get the Roles related to the current session
     * @return array
     */
    public function getRoles()
    {
        $user = $this->getUser();
        $userClass = $this->getUserClass();
        
        $user = $userClass::findFirstWithById([
            'RoleList',
            'GroupList.RoleList',
            'TypeList.GroupList.RoleList',
        ], $user->getId());
        
        $roles = [];
        if ($user) {
            foreach ($user->rolelist as $role) {
                $roles [$role->getIndex()] = $role;
            }
            
            foreach ($user->groupList as $group) {
                foreach ($group->roleList as $role) {
                    $roles [$role->getIndex()] = $role;
                }
            }
            
            foreach ($user->typeList as $type) {
                foreach ($type->groupList as $group) {
                    foreach ($group->roleList as $role) {
                        $roles [$role->getIndex()] = $role;
                    }
                }
            }
        }
        
        return $roles;
    }
    
    /**
     * @param array|null $roles
     *
     * @return array
     */
    public function getAclRoles(array $roles = null) {
        $roles ??= $this->getRoles();
    
        $aclRoles = [];
        $aclRoles['everyone'] = new Role('everyone');
        foreach ($roles as $role) {
            $aclRoles[$role->getIndex()] ??= new Role($role->getIndex());
        }
        
        return array_values($aclRoles);
    }
    
    /**
     * Login Action
     * - Require an active session to bind the logged in userId
     *
     * @return bool|mixed|null
     */
    public function login(array $params = null)
    {
        $loggedInUser = false;
        $saved = false;
        $session = $this->getSession(...$this->getKeyToken());
        
        $validation = new Validation();
        $validation->add('email', new PresenceOf(['message' => 'email is required']));
        $validation->add('password', new PresenceOf(['message' => 'username is required']));
        $validation->validate($params);
        
        if (!$session) {
            $validation->appendMessage(new Message('A session is required', 'session', 'PresenceOf', 403));
        }
        
        $messages = $validation->getMessages();
        
        if (!$messages->count()) {
            
            $userClass = $this->getUserClass();
            $user = $userClass::findFirstByEmail($this->filter->sanitize($params['email'] ?? '', 'string'));
            $user = $userClass::findFirst();
            
            if (!$user) {
                // user not found, login failed
                $validation->appendMessage(new Message('Login Failed', ['email', 'password'], 'LoginFailed', 401));
            }
            
            else if (empty($user->getPassword())) {
                // password disabled, login failed
                $validation->appendMessage(new Message('Password Login Disabled', 'password', 'LoginFailed', 401));
            }
            
            else if (!$user->checkPassword($params['password'])) {
                // password failed, login failed
                $validation->appendMessage(new Message('Login Failed', ['email', 'password'], 'LoginFailed', 401));
            }
            
            else if ($user->isDeleted()) {
                // access forbidden, login failed
                $validation->appendMessage(new Message('Login Forbidden', 'password', 'LoginForbidden', 403));
            }
            
            // login success
            else {
                
                $loggedInUser = $user;
            }
        }
        
        if ($session) {
            $saved = $session->setUserId($loggedInUser ? $loggedInUser->getId() : null)->save();
            foreach ($session->getMessages() as $message) {
                $validation->appendMessage($message);
            }
        }
        
        return [
            'saved' => $saved,
            'loggedIn' => $this->isLoggedIn(),
            'messages' => $validation->getMessages(),
        ];
    }
    
    /**
     * Log the user out from the database session
     *
     * @return bool|mixed|null
     */
    public function logout()
    {
        $saved = false;
        
        $session = $this->getSession(...$this->getKeyToken());
        $validation = new Validation();
        $validation->validate();
        
        if (!$session) {
            $validation->appendMessage(new Message('A session is required', 'session', 'PresenceOf', 403));
        }
        else {
            // Logout
            $saved = $session->setUserId(null)->save();
            
            foreach ($session->getMessages() as $message) {
                $validation->appendMessage($message);
            }
        }
        
        return [
            'saved' => $saved,
            'loggedIn' => $this->isLoggedIn(),
            'messages' => $validation->getMessages(),
        ];
    }
    
    /**
     * Get key / token fields to use for the session fetch & validation
     *
     * @return array
     */
    public function getKeyToken()
    {
        $basicAuth = $this->request->getBasicAuth();
        $authorization = array_filter(explode(' ', $this->request->getHeader('Authorization') ? : ''));
        
        $jwt = $this->request->get('jwt', 'string');
        $key = $this->request->get('key', 'string');
        $token = $this->request->get('token', 'string');
        
        if (!empty($jwt)) {
            $sessionClaim = $this->getClaim($jwt, $this->sessionKey);
            $key = $sessionClaim->key ?? null;
            $token = $sessionClaim->token ?? null;
        }
        
        else if (!empty($basicAuth)) {
            $key = $basicAuth['username'] ?? null;
            $token = $basicAuth['password'] ?? null;
        }
        
        else if (!empty($authorization)) {
            $authorizationType = $authorization[0] ?? 'Bearer';
            $authorizationToken = $authorization[1] ?? null;
            
            if (strtolower($authorizationType) === 'bearer') {
                
                $sessionClaim = $this->getClaim($authorizationToken, $this->sessionKey);
                $key = $sessionClaim->key ?? null;
                $token = $sessionClaim->token ?? null;
            }
        }
        
        else if ($this->session->has($this->sessionKey)) {
            $sessionStore = $this->session->get($this->sessionKey);
            $key = $sessionStore['key'] ?? null;
            $token = $sessionStore['token'] ?? null;
        }
        
        return [$key, $token];
    }
    
    /**
     * Return the session by key if the token is valid
     *
     * @param string $key
     * @param string $token
     *
     * @return void|bool|Session Return the session by key if the token is valid, false otherwise
     */
    public function getSession(string $key = null, string $token = null)
    {
        if (empty($key) || empty($token)) {
            return false;
        }
        
        $sessionClass = $this->getSessionClass();
        $session = $sessionClass::findFirstByKey($this->filter->sanitize($key, 'string'));
        
        if ($session && $session->checkHash($session->getToken(), $key . $token)) {
            
            return $session;
        }
        
        return false;
    }
    
    /**
     * Get a claim
     * @TODO generate private & public keys
     *
     * @param string $token
     * @param string|null $claim
     *
     * @return array|mixed
     */
    public function getClaim(string $token, string $claim = null)
    {
        $jwt = (new Parser())->parse((string)$token);
        
        return $claim ? $jwt->getClaim($claim) : $jwt->getClaims();
    }
    
    /**
     * Generate a new JWT
     * @TODO generate private & public keys and use them
     *
     * @param $claim
     * @param $data
     *
     * @return string
     */
    public function getJwtToken($claim, $data)
    {
        $uri = $this->request->getScheme() . '://' . $this->request->getHttpHost();

//        $privateKey = new Key('file://{path to your private key}');
        $signer = new Sha512();
        $time = time();
        
        $token = (new Builder())
            ->issuedBy($uri) // Configures the issuer (iss claim)
            ->permittedFor($uri) // Configures the audience (aud claim)
            ->identifiedBy($claim, true) // Configures the id (jti claim), replicating as a header item
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->canOnlyBeUsedAfter($time + 60) // Configures the time that the token can be used (nbf claim)
            ->expiresAt($time + 3600) // Configures the expiration time of the token (exp claim)
            ->withClaim($claim, $data) // Configures a new claim, called "uid"
            ->getToken($signer) // Retrieves the generated token
//            ->getToken($signer,  $privateKey); // Retrieves the generated token
        ;
        
        return (string)$token;
    }
}
