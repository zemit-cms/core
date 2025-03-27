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

use Phalcon\Encryption\Security\Exception;
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
    
    /**
     * Retrieves the identity based on the provided user expose parameter.
     *
     * @param array|null $userExpose Optional parameter to specify user-related data exposure.
     * @return array The resulting identity data array.
     */
    public function get(?array $userExpose = null): array
    {
        return $this->getIdentity($userExpose);
    }
    
    /**
     * Retrieves the identity information based on the provided user expose parameter.
     *
     * @param array|null $userExpose Optional parameter specifying details for user data exposure.
     * @return array An associative array containing identity details such as logged-in status, user data, impersonation, roles, and groups.
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
     * Handles the login process by validating the provided parameters, checking user credentials,
     * and managing session state. Returns the login status along with any validation messages.
     *
     * @param array|null $params Parameters for login, typically including 'email' and 'password'.
     * @return array Contains login status, logged-in user information, and validation messages.
     */
    public function login(?array $params = null): array
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
     * Logs out the current user by removing the session identity and returns the login status.
     *
     * @return array An associative array containing the user's login status and identity status after logout.
     */
    public function logout(): array
    {
        $this->removeSessionIdentity();
        
        return [
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
        ];
    }
    
    /**
     * Resets a user's password or generates a reset token for the user, depending on the input parameters.
     *
     * @param array|null $params Parameters including email, token,
     *                           password, and password confirmation for the reset operation.
     *                           - 'email': The user's email address.
     *                           - 'token': An optional reset token for password update.
     *                           - 'password': The new password to set (relevant with token).
     *                           - 'passwordConfirm': The confirmation of the new password.
     * @return array An array containing the following keys:
     *               - 'saved': A boolean indicating whether the save operation was successful.
     *               - 'sent': A boolean indicating whether the reset token email was sent successfully.
     *               - 'messages': A collection of validation or processing messages.
     */
    public function reset(?array $params = null): array
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
    
    /**
     * Processes the given list of entities and organizes them into an associative array indexed by each entity's index.
     *
     * @param array $list A list of entities, each of which must have a method `getIndex`.
     * @return array An associative array where keys are derived from each entity's `getIndex` method and values are the entities.
     */
    private function collectList(array $list): array
    {
        $ret = [];
        foreach ($list as $entity) {
            assert(method_exists($entity, 'getIndex'));
            $ret [$entity->getIndex()] = $entity;
        }
        
        return $ret;
    }
}
