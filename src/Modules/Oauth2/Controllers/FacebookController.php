<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Modules\Oauth2\Controllers;

class FacebookController extends AbstractController
{
    public string $providerName = self::PROVIDER_FACEBOOK;
    
    public string $sessionKey = 'oauth2-facebook-state';
}
