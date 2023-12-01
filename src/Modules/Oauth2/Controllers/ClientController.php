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
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Phalcon\Http\ResponseInterface;

class ClientController extends AbstractController
{
    public string $providerName = self::PROVIDER_CLIENT;
    
    public string $sessionKey = 'oauth2-client-state';
}
