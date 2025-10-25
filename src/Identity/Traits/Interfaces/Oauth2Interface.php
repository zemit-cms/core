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

namespace Zemit\Identity\Traits\Interfaces;

interface Oauth2Interface
{
    public function oauth2(string $provider, string $providerUuid, string $accessToken, ?string $refreshToken = null, ?array $meta = []): array;
}
