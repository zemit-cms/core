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

namespace Zemit\Identity;

use Zemit\Di\Injectable;
use Zemit\Filter\Validation;
use Zemit\Identity\Traits\Acl;
use Zemit\Identity\Traits\Impersonation;
use Zemit\Identity\Traits\Jwt;
use Zemit\Identity\Traits\Oauth2;
use Zemit\Identity\Traits\Role;
use Zemit\Identity\Traits\Session;
use Zemit\Identity\Traits\User;
use Zemit\Support\Options\Options;
use Zemit\Support\Options\OptionsInterface;

use Phalcon\Filter\Validation\Validator\Confirmation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Messages\Message;

class Manager extends Injectable implements ManagerInterface, OptionsInterface
{
    use Options;
    
    use Acl;
    use Impersonation;
    use Jwt;
    use Oauth2;
    use Role;
    use Session;
    use User;
    
    public function get(?array $userExpose = null): array {
        return $this->getIdentity($userExpose);
    }
    
    /**
     * Get basic Identity information
     * @throws \Exception
     */
    public function getIdentity(?array $userExpose = null): array
    {
        $userAs = $this->getUserAs();
        $user = $this->getUser();
        
        return [
            'loggedInAs' => $this->isLoggedInAs(),
            'userAs' => isset($userExpose, $userAs) ? $userAs->expose($userExpose) : $userAs,
            
            'loggedIn' => $this->isLoggedIn(),
            'user' => isset($userExpose, $user) ? $user->expose($userExpose) : $user,
            
            'roleList' => $this->collectList($user->rolelist ?? []),
            'typeList' => $this->collectList($user->grouplist ?? []),
            'groupList' => $this->collectList($user->rolelist ?? []),
        ];
    }
    
    /**
     * Login request
     * Requires an active session to bind the logged in userId
     */
    public function login(array $params = null): array
    {
        $validation = new Validation();
        $validation->add('email', new PresenceOf(['message' => 'required']));
        $validation->add('email', new Email(['message' => 'email-not-valid']));
        $validation->add('password', new PresenceOf(['message' => 'required']));
        $validation->validate($params);
        
        $messages = $validation->getMessages();
        if (!$messages->count()) {
            $user = $this->findUserByEmail($params['email']);
            
            $loginFailedMessage = new Message('Login Failed', ['email', 'password'], 'LoginFailed', 401);
            $loginForbiddenMessage = new Message('Login Forbidden', ['email', 'password'], 'LoginForbidden', 403);
            
            if (!isset($user)) {
                // user not found, login failed
                $validation->appendMessage($loginFailedMessage);
            }
            else if (empty($user->getPassword())) {
                // password disabled, login failed
                $validation->appendMessage($loginFailedMessage);
            }
            else if (!$user->checkHash($user->getPassword(), $params['password'])) {
                // password failed, login failed
                $validation->appendMessage($loginFailedMessage);
            }
            else if ($user->isDeleted()) {
                // password match, user is deleted login forbidden
                $validation->appendMessage($loginForbiddenMessage);
            }
            
            // login success
            else {
                // save userId into session
                $this->setSessionIdentity(['userId' => $user->getId()]);
            }
        }
        
        return [
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
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
        $this->removeSessionIdentity();
        
        return [
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
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
        
        $validation = new Validation();
        $validation->add('email', new PresenceOf(['message' => 'required']));
        $validation->add('email', new Email(['message' => 'email-not-valid']));
        $validation->validate($params);
        
        $user = false;
        if (isset($params['email'])) {
            $user = $this->findUserByEmail($params['email']);
        }
        
        // Reset
        if ($user) {
            assert($user instanceof \Zemit\Models\Interfaces\UserInterface);
            
            // Password reset request
            if (!empty($params['token'])) {
                $validation->add('password', new PresenceOf(['message' => 'required']));
                $validation->add('passwordConfirm', new PresenceOf(['message' => 'required']));
                $validation->add('passwordConfirm', new Confirmation(['message' => 'password-not-match', 'with' => 'passwordConfirm']));
                $validation->validate($params);
                if (!$user->checkToken($params['token'])) {
                    $validation->appendMessage(new Message('not-valid', 'token', 'NotValid', 400));
                }
                else if (!count($validation->getMessages())) {
                    $params['token'] = null;
                    $user->assign($params, ['token', 'password', 'passwordConfirm']);
                    $saved = $user->save();
                }
            }
            
            // Reset token request
            else {
                // Setup a new reset token hash for the user
                $token = $this->security->getRandom()->base64Safe(32);
                $user->setResetToken($user->hash($token, $user->getEmail()));
                
                if ($user->save()) {
                    $email = $this->models->getEmail();
                    $email->setViewPath('template/email');
                    $email->setTemplateByIndex('reset-password');
                    $email->setTo([$user->getEmail()]);
                    $email->setMeta([
                        'resetLink' => $this->url->get('/reset-password/' . $token),
                        'user' => $user->expose([
                            false,
                            'firstName',
                            'lastName',
                            'email',
                        ]),
                    ]);
                    $sent = $email->send();
                    foreach ($email->getMessages() as $message) {
                        $validation->appendMessage($message);
                    }
                }
                
                foreach ($user->getMessages() as $message) {
                    $validation->appendMessage($message);
                }
            }
        }
        else {
            // OWASP Protect User Enumeration
            $saved = true;
            $sent = true;
        }
        
        return [
            'saved' => $saved,
            'sent' => $sent,
            'messages' => $validation->getMessages(),
        ];
    }
    
    private function collectList(array $list)
    {
        $ret = [];
        foreach ($list as $entity) {
            assert(method_exists($entity, 'getIndex'));
            $ret [$entity->getIndex()] = $entity;
        }
        
        return $ret;
    }
}
