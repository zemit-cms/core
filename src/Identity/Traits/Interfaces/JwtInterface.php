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

interface JwtInterface
{
    public function getJwt(bool $refresh = false): array;
    
    public function getClaim(bool $refresh = false, bool $force = false): array;
    
    public function setClaim(array $claim): void;
    
    public function getJwtToken(string $id, array $data = [], array $options = []): string;
    
    public function getClaimFromToken(string $token, string $claim = null): array;
    
    public function getClaimFromAuthorization(array $authorization): array;
}
