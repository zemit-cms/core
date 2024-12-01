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

use Phalcon\Acl\Role;
use Phalcon\Db\Column;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Filter\Validation\Validator\Confirmation;
use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Messages\Message;
use Phalcon\Mvc\EntityInterface;
use Phalcon\Support\Helper\Str\Random;
use Zemit\Di\Injectable;
use Zemit\Filter\Validation;
use Zemit\Models\Interfaces\RoleInterface;
use Zemit\Models\Interfaces\SessionInterface;
use Zemit\Models\Interfaces\UserInterface;
use Zemit\Models\Oauth2;
use Zemit\Models\User;
use Zemit\Mvc\Model\Behavior\Security as SecurityBehavior;
use Zemit\Support\ModelsMap;
use Zemit\Support\Options\Options;
use Zemit\Support\Options\OptionsInterface;

/**
 * Identity Management
 */
class Identity extends Injectable implements OptionsInterface
{
    use Options;
    use ModelsMap;
    
    public string $sessionKey;
    
    public array $store = [];
    
    public ?UserInterface $user;
    
    public ?UserInterface $userAs;
    
    public ?SessionInterface $currentSession = null;
    
    /**
     * Forces some options
     */
    public function initialize(): void
    {
        $this->sessionKey = $this->getOption('sessionKey') ?? $this->sessionKey;
        $this->setModelsMap($this->getOption('modelsMap'));
    }
    
    /**
     * Check whether the current identity has roles
     */
    public function hasRole(?array $roles = null, bool $or = false, bool $inherit = true): bool
    {
        return $this->has($roles, array_keys($this->getRoleList($inherit) ?: []), $or);
    }
    
    /**
     * Get the User ID
     */
    public function getUserId(bool $as = false): ?int
    {
        $user = $this->getUser($as);
        return isset($user)? (int)$user->getId() : null;
    }
    
    /**
     * Get the User (As) ID
     */
    public function getUserAsId(): ?int
    {
        return $this->getUserId(true);
    }
    
    /**
     * Check if the needles meet the haystack using nested arrays
     * Reversing ANDs and ORs within each nested subarray
     *
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), true); // 'dev' OR 'admin'
     * $this->has(['dev', 'admin'], $this->getUser()->getRoles(), false); // 'dev' AND 'admin'
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
    public function has(array|string|null $needles = null, array $haystack = [], bool $or = false): bool
    {
        if (!is_array($needles)) {
            $needles = isset($needles)? [$needles] : [];
        }
        
        $result = [];
        foreach ($needles as $needle) {
            if (is_array($needle)) {
                $result [] = $this->has($needle, $haystack, !$or);
            } else {
                $result [] = in_array($needle, $haystack, true);
            }
        }
        
        return $or ?
            !in_array(false, $result, true) :
            in_array(true, $result, true);
    }
    
    /**
     * Create or refresh a session
     * @throws ValidatorException|\Phalcon\Encryption\Security\Exception
     */
    public function getJwt(bool $refresh = false): array
    {
        [$key, $token] = $this->getKeyToken();
        
        // generate new key & token pair if not set
        $key ??= $this->security->getRandom()->uuid();
        $token ??= $this->helper->random(Random::RANDOM_ALNUM, rand(111, 222));
        $newToken = $refresh ? $this->helper->random(Random::RANDOM_ALNUM, rand(111, 222)) : $token;
        
        $adapter = $this->config->path('identity.adapter') ?: 'database';
//        if ($adapter === 'database') {
            // retrieve or create a new session
            $sessionClass = $this->getSessionClass();
            $session = $this->getSession($key, $token) ?? new $sessionClass();
            assert($session instanceof SessionInterface);
            
            // save the key token into the store (database or session)
            $session->setKey($key);
            $session->setToken($session->hash($key . $newToken));
            $session->setDate(date('Y-m-d H:i:s'));
            $saved = $session->save();
//        }
//        else if ($adapter === 'session') {
//            $this->session->get($key);
//            $this->session->set($key, $newToken);
//        }
        
        // temporary store the new key token pair
        $this->store = ['key' => $session->getKey(), 'token' => $newToken];
        
        if ($saved && $this->config->path('identity.sessionFallback', false)) {
            // store key & token into the session
            $this->session->set($this->sessionKey, $this->store);
        }
        else {
            // delete the session
            $this->session->remove($this->sessionKey);
        }
        
        // jwt token
        $tokenOptions = $this->getConfig()->pathToArray('identity.token') ?? [];
        $token = $this->getJwtToken($this->sessionKey, $this->store, $tokenOptions);
        
        // refresh jwt token
        $refreshTokenOptions = $this->getConfig()->pathToArray('identity.refreshToken') ?? [];
        $refreshToken = $this->getJwtToken($this->sessionKey . '-refresh', $this->store, $refreshTokenOptions);
        
        return [
            'saved' => $saved,
            'hasSession' => $this->session->has($this->sessionKey),
            'refreshed' => $saved && $refresh,
            'validated' => $session->checkHash($session->getToken(), $session->getKey() . $newToken),
            'messages' => $session->getMessages(),
            'jwt' => $token,
            'refreshToken' => $refreshToken,
        ];
    }
    
    /**
     * Get basic Identity information
     * @throws \Exception
     */
    public function getIdentity(bool $inherit = true): array
    {
        $user = $this->getUser();
        $userAs = $this->getUserAs();
        
        $roleList = [];
        $groupList = [];
        $typeList = [];
        
        if (isset($user)) {
            if (!empty($user->rolelist)) {
                foreach ($user->rolelist as $role) {
                    $roleList [$role->getIndex()] = $role;
                }
            }
            
            if (!empty($user->grouplist)) {
                foreach ($user->grouplist as $group) {
                    $groupList [$group->getIndex()] = $group;
                    if (!empty($group->rolelist)) {
                        foreach ($group->rolelist as $role) {
                            $roleList [$role->getIndex()] = $role;
                        }
                    }
                }
            }
            
            if (!empty($user->typelist)) {
                foreach ($user->typelist as $type) {
                    $typeList [$type->getIndex()] = $type;
                    if (!empty($type->grouplist)) {
                        foreach ($type->grouplist as $group) {
                            $groupList [$group->getIndex()] = $group;
                            if (!empty($group->rolelist)) {
                                foreach ($group->rolelist as $role) {
                                    $roleList [$role->getIndex()] = $role;
                                }
                            }
                        }
                    }
                }
            }
        }
        
        // Append inherit roles
        if ($inherit) {
            $roleIndexList = [];
            foreach ($roleList as $role) {
                $roleIndexList [] = $role->getIndex();
            }
            
            $inheritedRoleIndexList = $this->getInheritedRoleList($roleIndexList);
            if (!empty($inheritedRoleIndexList)) {
                
                SecurityBehavior::staticStart();
                $inheritedRoleList = $this->models->getRole()::find([
                    'index in ({role:array})',
                    'bind' => ['role' => $inheritedRoleIndexList],
                    'bindTypes' => ['role' => Column::BIND_PARAM_STR],
                ]);
                SecurityBehavior::staticStop();
                
                assert(is_iterable($inheritedRoleList));
                foreach ($inheritedRoleList as $inheritedRoleEntity) {
                    assert($inheritedRoleEntity instanceof RoleInterface);
                    $inheritedRoleIndex = $inheritedRoleEntity->getIndex();
                    $roleList[$inheritedRoleIndex] = $inheritedRoleEntity;
                    
                    if (($key = array_search($inheritedRoleIndex, $inheritedRoleIndexList)) !== false) {
                        unset($inheritedRoleIndexList[$key]);
                    }
                }
                
                // unable to find some roles by index
                if (!empty($inheritedRoleIndexList)) {
                    
                    // To avoid breaking stuff in production, create a new role if it doesn't exist
                    if (!$this->config->path('app.debug', false)) {
                        $roleClass = $this->getRoleClass();
                        foreach ($inheritedRoleIndexList as $inheritedRoleIndex) {
                            $roleList[$inheritedRoleIndex] = new $roleClass();
                            $roleList[$inheritedRoleIndex]->setIndex($inheritedRoleIndex);
                            $roleList[$inheritedRoleIndex]->setLabel(ucfirst($inheritedRoleIndex));
                        }
                    }
                    
                    // throw an exception under development so it can be fixed
                    else {
                        throw new \Exception('Role `' . implode('`, `', $inheritedRoleIndexList) . '` not found using the class `' . $this->getRoleClass() . '`.', 404);
                    }
                }
            }
        }
        
        // We don't need userAs group / type / role list
        return [
            'loggedIn' => $this->isLoggedIn(),
            'loggedInAs' => $this->isLoggedInAs(),
            'user' => $user,
            'userAs' => $userAs,
            'roleList' => $roleList,
            'typeList' => $typeList,
            'groupList' => $groupList,
        ];
    }
    
    /**
     * Return the list of inherited role list (recursively)
     */
    public function getInheritedRoleList(array $roleIndexList = []): array
    {
        $inheritedRoleList = [];
        $processedRoleIndexList = [];
        
        // While we still have role index list to process
        while (!empty($roleIndexList)) {
            
            // Process role index list
            foreach ($roleIndexList as $roleIndex) {
                // Get inherited roles from config service
                
                $configRoleList = $this->config->path('permissions.roles.' . $roleIndex . '.inherit', false);
                
                if ($configRoleList) {
                    
                    // Append inherited role to process list
                    $roleList = $configRoleList->toArray();
                    $roleIndexList = array_merge($roleIndexList, $roleList);
                    $inheritedRoleList = array_merge($inheritedRoleList, $roleList);
                }
                
                // Add role index to processed list
                $processedRoleIndexList [] = $roleIndex;
            }
            
            // Keep the unprocessed role index list
            $roleIndexList = array_filter(array_unique(array_diff($roleIndexList, $processedRoleIndexList)));
        }
        
        // Return the list of inherited role list (recursively)
        return array_values(array_filter(array_unique($inheritedRoleList)));
    }
    
    /**
     * Return true if the user is currently logged in
     */
    public function isLoggedIn(bool $as = false, bool $force = false): bool
    {
        return !!$this->getUser($as, $force);
    }
    
    /**
     * Return true if the user is currently logged in
     */
    public function isLoggedInAs(bool $force = false): bool
    {
        return $this->isLoggedIn(true, $force);
    }
    
    /**
     * Return the user object based on the session
     *
     * @param bool $as Flag to indicate whether to get the user as another user
     * @param bool|null $force Flag to indicate whether to force the retrieval of the user object
     * 
     * @return UserInterface|null The user object or null if session is not available
     */
    public function getUser(bool $as = false, ?bool $force = null): ?UserInterface
    {
        // session required to fetch user
        $session = $this->getSession();
        if (!$session) {
            return null;
        }
        
        $force = $force
            || ($as && empty($this->userAs))
            || (!$as && empty($this->user));
        
        if ($force) {
            
            $userId = $as
                ? $session->getAsUserId()
                : $session->getUserId();
            
            $user = null;
            if (!empty($userId)) {
                SecurityBehavior::staticStart();
                
                $user = $this->models->getUser()::findFirstWith([
                    'RoleList',
                    'GroupList.RoleList',
                    'TypeList.GroupList.RoleList',
                ], [
                    'id = :id:',
                    'bind' => ['id' => (int)$userId],
                    'bindTypes' => ['id' => Column::BIND_PARAM_INT]
                ]);
                if ($user) {
                    assert($user instanceof UserInterface);
                }
                
                SecurityBehavior::staticStop();
            }
            
            $as
                ? $this->setUserAs($user)
                : $this->setUser($user);
            
            return $user instanceof UserInterface? $user : null;
        }
        
        return $as
            ? $this->userAs
            : $this->user;
    }
    
    /**
     * Get Identity User (As)
     */
    public function getUserAs(): ?UserInterface
    {
        return $this->getUser(true);
    }
    
    /**
     * Set Identity User
     */
    public function setUser(?UserInterface $user): void
    {
        $this->user = $user;
    }
    
    /**
     * Set Identity User (As)
     */
    public function setUserAs(?UserInterface $user): void
    {
        $this->userAs = $user;
    }
    
    /**
     * Get the "Roles" related to the current session
     */
    public function getRoleList(bool $inherit = true): array
    {
        return $this->getIdentity($inherit)['roleList'] ?? [];
    }
    
    /**
     * Get the "Groups" related to the current session
     */
    public function getGroupList(bool $inherit = true): array
    {
        return $this->getIdentity($inherit)['groupList'] ?? [];
    }
    
    /**
     * Get the "Types" related to the current session
     */
    public function getTypeList(bool $inherit = true): array
    {
        return $this->getIdentity($inherit)['typeList'] ?? [];
    }
    
    /**
     * Return the list of ACL roles
     * - Reserved roles: guest, cli, everyone
     *
     * @param array|null $roleList
     * @return array
     */
    public function getAclRoles(?array $roleList = null): array
    {
        $roleList ??= $this->getRoleList();
        $aclRoles = [];
        
        // Add everyone role
        $aclRoles['everyone'] = new Role('everyone', 'Everyone');
        
        // Add guest role if no roles was detected
        if (count($roleList) === 0) {
            $aclRoles['guest'] = new Role('guest', 'Guest');
        }
        
        // Add roles from databases
        foreach ($roleList as $role) {
            if ($role) {
                $aclRoles[$role->getIndex()] ??= new Role($role->getIndex());
            }
        }
        
        // Add console role
        if ($this->bootstrap->isCli()) {
            $aclRoles['cli'] = new Role('cli', 'Cli');
        }
        
        return array_filter(array_values(array_unique($aclRoles)));
    }
    
    /**
     * Login as User
     */
    public function loginAs(?array $params = []): array
    {
        $session = $this->getSession();
        
        // Validation
        $validation = new Validation();
        $validation->add('userId', new PresenceOf(['message' => 'required']));
        $validation->add('userId', new Numericality(['message' => 'not-numeric']));
        $validation->validate($params);
        $messages = $validation->getMessages();
    
        $saved = false;
        
        // must be an admin
        if (isset($session, $params['userId']) && !$messages->count() && $this->hasRole(['admin', 'dev'])) {
            $userId = $session->getUserId();
            
            // himself, return back to normal login
            if ((int)$params['userId'] === (int)$userId) {
                return $this->logoutAs();
            }
    
            // login as using id
            $asUser = $this->findUserById((int)$params['userId']);
            if (isset($asUser)) {
                $session->setAsUserId($userId);
                $session->setUserId($params['userId']);
            }
            else {
                $validation->appendMessage(new Message('User Not Found', 'userId', 'PresenceOf', 404));
            }
    
            $saved = $session->save();
            foreach ($session->getMessages() as $message) {
                $validation->appendMessage($message);
            }
        }
        
        return [
            'saved' => $saved,
            'messages' => $validation->getMessages(),
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
        ];
    }
    
    /**
     * Log off User (As)
     */
    public function logoutAs(): array
    {
        $session = $this->getSession();
        
        if ($session) {
            $asUserId = $session->getAsUserId();
            $userId = $session->getUserId();
            if (!empty($asUserId) && !empty($userId)) {
                $session->setUserId($asUserId);
                $session->setAsUserId(null);
            }
        }
        
        return [
            'saved' => $session && $session->save(),
            'messages' => $session && $session->getMessages(),
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
        ];
    }
    
    /**
     * OAuth2 authentication
     *
     * @param string $provider The OAuth2 provider
     * @param int $providerUuid The UUID associated with the provider
     * @param string $accessToken The access token provided by the provider
     * @param string|null $refreshToken The refresh token provided by the provider (optional)
     * @param array|null $meta Additional metadata associated with the user (optional)
     *
     * @return array Returns an array with the following keys:
     *   - 'saved': Indicates whether the OAuth2 entity was saved successfully
     *   - 'loggedIn': Indicates whether the user is currently logged in
     *   - 'loggedInAs': Indicates the user that is currently logged in
     *   - 'messages': An array of validation messages
     * 
     * @throws \Phalcon\Filter\Exception
     */
    public function oauth2(string $provider, int $providerUuid, string $accessToken, ?string $refreshToken = null, ?array $meta = []): array
    {
        $loggedInUser = null;
        $saved = false;
        
        // get the current session
        $session = $this->getSession();
        
        // prepare validation
        $validation = new Validation();
        
        // a session is required
        if (!isset($session)) {
            $validation->appendMessage(new Message('A session is required', 'session', 'PresenceOf', 403));
        }
        else {
            // retrieve and prepare oauth2 entity
            $oauth2 = Oauth2::findFirst([
                'provider = :provider: and provider_uuid = :providerUuid:',
                'bind' => [
                    'provider' => $this->filter->sanitize($provider, 'string'),
                    'providerUuid' => $providerUuid,
                ],
                'bindTypes' => [
                    'provider' => Column::BIND_PARAM_STR,
                    'id' => Column::BIND_PARAM_STR,
                ],
            ]);
            if (!$oauth2) {
                $oauth2 = new Oauth2();
                $oauth2->setProvider($provider);
                $oauth2->setProviderUuid($providerUuid);
            }
            $oauth2->setAccessToken($accessToken);
            $oauth2->setRefreshToken($refreshToken);
            $oauth2->setMeta(!empty($meta)? json_encode($meta) : null);
            $oauth2->setName($meta['name'] ?? null);
            $oauth2->setFirstName($meta['first_name'] ?? null);
            $oauth2->setLastName($meta['last_name'] ?? null);
            $oauth2->setEmail($meta['email'] ?? null);
            
            // link the current user to the oauth2 entity
            $oauth2UserId = $oauth2->getUserId();
            $sessionUserId = $session->getUserId();
            if (empty($oauth2UserId) && !empty($sessionUserId)) {
                $oauth2->setUserId($sessionUserId);
            }
            
            // save the oauth2 entity
            $saved = $oauth2->save();
            
            // append oauth2 error messages
            foreach ($oauth2->getMessages() as $message) {
                $validation->appendMessage($message);
            }
            
            // user id is required
            $validation->add('userId', new PresenceOf(['message' => 'userId is required']));
            $validation->validate($oauth2->toArray());
            
            // All validation passed
            if ($saved && !$validation->getMessages()->count()) {
                $user = $this->findUserById($oauth2->getUserId());
                
                // user not found, login failed
                if (!isset($user)) {
                    $validation->appendMessage(new Message('Login Failed', ['id'], 'LoginFailed', 401));
                }
                
                // access forbidden, login failed
                elseif ($user->isDeleted()) {
                    $validation->appendMessage(new Message('Login Forbidden', 'password', 'LoginForbidden', 403));
                }
                
                // login success
                else {
                    $loggedInUser = $user;
                }
                
                // Set the oauth user id into the session
                $session->setUserId($loggedInUser?->getId());
                $saved = $session->save();
                
                // append session error messages
                foreach ($session->getMessages() as $message) {
                    $validation->appendMessage($message);
                }
            }
        }
        
        return [
            'saved' => $saved,
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
            'messages' => $validation->getMessages(),
        ];
    }
    
    /**
     * Login request
     * Requires an active session to bind the logged in userId
     */
    public function login(array $params = null): array
    {
        $loggedInUser = null;
        $saved = null;
        $session = $this->getSession();
        $validation = new Validation();
        $validation->add('email', new PresenceOf(['message' => 'required']));
        $validation->add('password', new PresenceOf(['message' => 'required']));
        $validation->validate($params);
        
        if (!$session) {
            $validation->appendMessage(new Message('required', 'Session Required', 'PresenceOf', 403));
        }
        
        $messages = $validation->getMessages();
        if (isset($session, $params['email'], $params['password']) && !$messages->count()) {
            $user = empty($params['email'])? null : $this->findUser($params['email']);
            
            $loginFailedMessage = new Message('Login Failed', ['email', 'password'], 'LoginFailed', 401);
            $loginForbiddenMessage = new Message('Login Forbidden', ['email', 'password'], 'LoginForbidden', 403);
            
            if (!isset($user)) {
                // user not found, login failed
                $validation->appendMessage($loginFailedMessage);
            }
            elseif (empty($user->getPassword())) {
                // password disabled, login failed
                $validation->appendMessage($loginFailedMessage);
            }
            elseif (!$user->checkHash($user->getPassword(), $params['password'])) {
                // password failed, login failed
                $validation->appendMessage($loginFailedMessage);
            }
            elseif ($user->isDeleted()) {
                // password match, user is deleted login forbidden
                $validation->appendMessage($loginForbiddenMessage);
            }
            
            // login success
            else {
                $loggedInUser = $user;
            }
            
            $session->setUserId($loggedInUser?->getId());
            $saved = $session->save();
            foreach ($session->getMessages() as $message) {
                $validation->appendMessage($message);
            }
        }
        
        return [
            'saved' => $saved,
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
            'messages' => $validation->getMessages(),
        ];
    }
    
    /**
     * Logout the user and return the logout status, login status, and validation messages
     * 
     * @return array The array containing the logout status, login status, and validation messages
     */
    public function logout(): array
    {
        $saved = false;
        $sessionEntity = $this->getSession();
        $validation = new Validation();
        $validation->validate();
        if (!$sessionEntity) {
            $validation->appendMessage(new Message('A session is required', 'session', 'PresenceOf', 403));
        }
        else {
            // Logout
            $sessionEntity->setUserId(null);
            $sessionEntity->setAsUserId(null);
            $saved = $sessionEntity->save();
            foreach ($sessionEntity->getMessages() as $message) {
                $validation->appendMessage($message);
            }
        }
        
        return [
            'saved' => $saved,
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
            'messages' => $validation->getMessages(),
        ];
    }
    
    /**
     * @param array|null $params
     *
     * @return array
     */
    public function reset(array $params = null)
    {
        $saved = false;
        $sent = false;
        $session = $this->getSession();
        $validation = new Validation();
        $validation->add('email', new PresenceOf(['message' => 'email is required']));
        $validation->validate($params);
        if (!$session) {
            $validation->appendMessage(new Message('A session is required', 'session', 'PresenceOf', 403));
        }
        else {
            $user = false;
            if (isset($params['email'])) {
                $user = $this->models->getUser()::findFirst([
                    'email = :email:',
                    'bind' => ['email' => $params['email']],
                    'bindTypes' => ['email', Column::BIND_PARAM_STR]
                ]);
            }
            
            // Reset
            if ($user) {
                // Password reset request
                if (empty($params['token'])) {
                    
                    // Generate a new token
                    $token = $user->prepareToken();
                    
                    // Send it by email
                    $emailClass = $this->getEmailClass();
                    $email = new $emailClass();
                    $email->setViewPath('template/email');
                    $email->setTemplateByIndex('reset-password');
                    $email->setTo([$user->getEmail()]);
                    $meta = [];
                    $meta['user'] = $user->expose(['User' => [
                        false,
                        'firstName',
                        'lastName',
                        'email',
                    ]]);
                    $meta['resetLink'] = $this->url->get('/reset-password/' . $token);
                    $email->setMeta($meta);
                    $saved = $user->save();
                    $sent = $saved ? $email->send() : false;
                    
                    // Appending error messages
                    foreach (['user', 'email'] as $e) {
                        foreach ($$e->getMessages() as $message) {
                            $validation->appendMessage($message);
                        }
                    }
                }
                
                // Password reset
                else {
                    $validation->add('password', new PresenceOf(['message' => 'password is required']));
                    $validation->add('passwordConfirm', new PresenceOf(['message' => 'password confirm is required']));
                    $validation->add('password', new Confirmation(['message' => 'password does not match passwordConfirm', 'with' => 'passwordConfirm']));
                    $validation->validate($params);
                    if (!$user->checkToken($params['token'])) {
                        $validation->appendMessage(new Message('invalid token', 'token', 'NotValid', 400));
                    }
                    elseif (!$validation->getMessages()->count()) {
                        $params['token'] = null;
                        $user->assign($params, ['token', 'password', 'passwordConfirm']);
                        $saved = $user->save();
                    }
                }
                
                // Appending error messages
                foreach ($user->getMessages() as $message) {
                    $validation->appendMessage($message);
                }
            }
            else {
                // removed - OWASP Protect User Enumeration
//                $validation->appendMessage(new Message('User not found', 'user', 'PresenceOf', 404));
                $saved = true;
                $sent = true;
            }
        }
        
        return [
            'saved' => $saved,
            'sent' => $sent,
            'messages' => $validation->getMessages(),
        ];
    }
    
    /**
     * Retrieve the key and token from various authorization sources
     *
     * @param string|null $jwt The JWT token
     * @param string|null $key The key
     * @param string|null $token The token
     * @return array An array containing the key and token
     * @throws ValidatorException
     */
    public function getKeyToken(string $jwt = null, string $key = null, string $token = null): array
    {
        try {
            $json = $this->request->getJsonRawBody();
        } catch (\InvalidArgumentException $e) {
            $json = new \stdClass();
        }
        
        $refreshToken = $this->request->get('refreshToken', 'string', $json->refreshToken ?? null);
        $jwt ??= $this->request->get('jwt', 'string', $json->jwt ?? null);
        $key ??= $this->request->get('key', 'string', $this->store['key'] ?? $json->key ?? null);
        $token ??= $this->request->get('token', 'string', $this->store['token'] ?? $json->token ?? null);
        
        // Using provided key & token
        if (isset($key, $token)) {
            return [$key, $token];
        }
        
        // Using refresh token
        if (!empty($refreshToken)) {
            return $this->getKeyTokenFromClaimToken($refreshToken, $this->sessionKey . '-refresh');
        }
        
        // Using JWT
        if (!empty($jwt)) {
            return $this->getKeyTokenFromClaimToken($jwt, $this->sessionKey);
        }
        
        // Using X-Authorization Header
        $authorizationHeaderKey = $this->config->path('identity.authorizationHeader', 'Authorization');
        $authorizationHeaderValue = $this->request->getHeader($authorizationHeaderKey);
        $authorization = array_filter(explode(' ', $authorizationHeaderValue));
        if (!empty($authorization)) {
            return $this->getKeyTokenFromAuthorization($authorization);
        }
        
        // Using Basic Auth from HTTP request
        $basicAuth = $this->request->getBasicAuth();
        if (!empty($basicAuth)) {
            return [
                $basicAuth['username'] ?? null,
                $basicAuth['password'] ?? null,
            ];
        }
        
        // Using Session Fallback
        $sessionFallback = $this->config->path('identity.sessionFallback', false);
        if ($sessionFallback && $this->session->has($this->sessionKey)) {
            $sessionStore = $this->session->get($this->sessionKey);
            return [
                $sessionStore['key'] ?? null,
                $sessionStore['token'] ?? null,
            ];
        }
        
        // Unsupported authorization method
        return [null, null];
    }
    
    /**
     * Get key and token from authorization
     * @param array $authorization The authorization array, where the first element is the authorization type and the second element is the authorization token
     * @return array The key and token extracted from the authorization session claim. If the key or token is not found, null will be returned for that value.
     * @throws ValidatorException
     */
    public function getKeyTokenFromAuthorization(array $authorization): array
    {
        $authorizationType = $authorization[0] ?? null;
        $authorizationToken = $authorization[1] ?? null;
        
        if ($authorizationType && $authorizationToken && strtolower($authorizationType) === 'bearer') {
            return $this->getKeyTokenFromClaimToken($authorizationToken, $this->sessionKey);
        }
        
        return [null, null];
    }
    
    /**
     * Get the key and token from the claim token
     *
     * @param string $claimToken The claim token
     * @param string $sessionKey The session key
     * @return array The key and token, [key, token]
     * @throws ValidatorException
     */
    public function getKeyTokenFromClaimToken(string $claimToken, string $sessionKey): array
    {
        $sessionClaim = $this->getClaim($claimToken, $sessionKey);
        $key = $sessionClaim['key'] ?? null;
        $token = $sessionClaim['token'] ?? null;
        return [$key, $token];
    }
    
    /**
     * Return the session by key if the token is valid
     */
    public function getSession(?string $key = null, ?string $token = null, bool $refresh = false): ?SessionInterface
    {
        if (!isset($key, $token)) {
            [$key, $token] = $this->getKeyToken();
        }
        
        if (empty($key) || empty($token)) {
            return null;
        }
        
        if ($refresh) {
            $this->currentSession = null;
        }
        
        if (isset($this->currentSession)) {
            return $this->currentSession;
        }
        
        $sessionClass = $this->getSessionClass();
        $sessionEntity = $sessionClass::findFirstByKey($this->filter->sanitize($key, 'string'));
        if ($sessionEntity && $sessionEntity->checkHash($sessionEntity->getToken(), $key . $token)) {
            $this->currentSession = $sessionEntity;
        }
        
        return $this->currentSession;
    }
    
    /**
     * Return the session ID if available, otherwise return null
     *
     * @return int|null
     */
    public function getSessionId(): ?int
    {
        $session = $this->getSession();
        return $session instanceof EntityInterface? $session->readAttribute('id') : null;
    }
    
    /**
     * @param string $token
     * @param string|null $claim
     * @return array
     * @throws ValidatorException
     */
    public function getClaim(string $token, string $claim = null): array
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
     * Get the User from the database using the ID
     */
    public function findUserById(int $id): ?UserInterface
    {
        $user = $this->models->getUser()::findFirst([
            'id = :id:',
            'bind' => ['id' => $id],
            'bindTypes' => ['id' => Column::BIND_PARAM_INT],
        ]);
        return $user instanceof UserInterface? $user : null;
    }
    
    /**
     * Get the user from the database using the username or email
     */
    public function findUser(string $string): ?UserInterface
    {
        $user = $this->models->getUser()::findFirst([
            'email = :email:',
            'bind' => [
                'email' => $string,
            ],
            'bindTypes' => [
                'email' => Column::BIND_PARAM_STR,
            ],
        ]);
        return $user instanceof UserInterface? $user : null;
    }
}
