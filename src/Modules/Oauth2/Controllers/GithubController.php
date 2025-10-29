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

namespace Zemit\Modules\Oauth2\Controllers;

class GithubController extends AbstractController
{
    public string $providerName = self::PROVIDER_GITHUB;
    
    public string $sessionKey = 'oauth2-github-state';
}
