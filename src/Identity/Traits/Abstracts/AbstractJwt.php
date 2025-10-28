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

namespace Zemit\Identity\Traits\Abstracts;

trait AbstractJwt
{
    abstract public function getJwt(bool $refresh = false): array;
    
    abstract public function getClaim(bool $refresh = false, bool $force = false): array;
    
    abstract public function setClaim(array $claim): void;
    
    abstract public function getJwtToken(string $id, array $data = [], array $options = []): string;
    
    abstract public function getClaimFromToken(string $token, ?string $claim = null): array;
    
    abstract public function getClaimFromAuthorization(array $authorization): array;
}
