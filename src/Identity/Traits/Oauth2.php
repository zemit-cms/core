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

use Phalcon\Db\Column;
use Phalcon\Filter\Exception;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Messages\Message;
use Zemit\Filter\Validation;
use Zemit\Identity\Traits\Abstracts\AbstractSession;

trait Oauth2
{
    use AbstractSession;
    
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
     * @throws Exception
     */
    public function oauth2(string $provider, int $providerUuid, string $accessToken, ?string $refreshToken = null, ?array $meta = []): array
    {
        $loggedInUser = null;
        
        // retrieve and prepare oauth2 entity
        $oauth2 = \Zemit\Models\Oauth2::findFirst([
            'provider = :provider: and provider_uuid = :providerUuid:',
            'bind' => [
                'provider' => $this->filter->sanitize($provider, 'string'),
                'providerUuid' => (int)$providerUuid,
            ],
            'bindTypes' => [
                'provider' => Column::BIND_PARAM_STR,
                'id' => Column::BIND_PARAM_STR,
            ],
        ]);
        if (!$oauth2) {
            $oauth2 = new \Zemit\Models\Oauth2();
            $oauth2->setProvider($provider);
            $oauth2->setProviderUuid($providerUuid);
        }
        $oauth2->setAccessToken($accessToken);
        $oauth2->setRefreshToken($refreshToken);
        $oauth2->setMeta(!empty($meta) ? json_encode($meta) : null);
        $oauth2->setName($meta['name'] ?? null);
        $oauth2->setFirstName($meta['first_name'] ?? null);
        $oauth2->setLastName($meta['last_name'] ?? null);
        $oauth2->setEmail($meta['email'] ?? null);
        
        // link the current user to the oauth2 entity
        $oauth2UserId = $oauth2->getUserId();
        $sessionUserId = $this->getUserId();
        if (empty($oauth2UserId) && !empty($sessionUserId)) {
            $oauth2->setUserId($sessionUserId);
        }
        
        // prepare validation
        $validation = new Validation();
        
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
            else if ($user->isDeleted()) {
                $validation->appendMessage(new Message('Login Forbidden', 'password', 'LoginForbidden', 403));
            }
            
            // login success
            else {
                $this->setSessionIdentity(['userId' => $user->getId()]);
            }
        }
        
        return [
            'saved' => $saved,
            'loggedIn' => $this->isLoggedIn(false, true),
            'loggedInAs' => $this->isLoggedIn(true, true),
            'messages' => $validation->getMessages(),
        ];
    }
}
