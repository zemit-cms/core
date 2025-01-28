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

use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Messages\Message;
use Zemit\Filter\Validation;

trait Impersonation
{
    /**
     * Login as User
     */
    public function loginAs(?array $params = []): array
    {
        // Validation
        $validation = new Validation();
        $validation->add('userId', new PresenceOf(['message' => 'required']));
        $validation->add('userId', new Numericality(['message' => 'not-numeric']));
        $messages = $validation->validate($params);
        
        // must be an admin or a dev @todo improve using config permissions
        if (!count($messages) && $this->hasRole(['admin', 'dev'])) {
            $sessionIdentity = $this->getSessionIdentity();
            
            // himself, return back to normal login
            if ((int)$sessionIdentity['asUserId'] === (int)$params['userId']) {
                return $this->logoutAs();
            }
            
            // login as using id
            $asUser = $this->findUserById((int)$params['userId']);
            if ($asUser) {
                $this->setSessionIdentity([
                    'userId' => (int)$params['userId'],
                    'asUserId' => $sessionIdentity['userId']
                ]);
            }
            else {
                $validation->appendMessage(new Message('User Not Found', 'userId', 'PresenceOf', 404));
            }
        }
        
        return [
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
        $sessionIdentity = $this->getSessionIdentity();
        if (!empty($sessionIdentity['userId']) && !empty($sessionIdentity['asUserId'])) {
            $this->setSessionIdentity(['userId' => $sessionIdentity['asUserId']]);
        }
        
        return [
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
        ];
    }
}
