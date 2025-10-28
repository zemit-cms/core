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

use Zemit\Identity\Traits\Interfaces\AclInterface;
use Zemit\Identity\Traits\Interfaces\ImpersonationInterface;
use Zemit\Identity\Traits\Interfaces\JwtInterface;
use Zemit\Identity\Traits\Interfaces\Oauth2Interface;
use Zemit\Identity\Traits\Interfaces\RoleInterface;
use Zemit\Identity\Traits\Interfaces\SessionInterface;
use Zemit\Identity\Traits\Interfaces\UserInterface;

interface ManagerInterface extends
    AclInterface,
    ImpersonationInterface,
    JwtInterface,
    Oauth2Interface,
    RoleInterface,
    SessionInterface,
    UserInterface
{
}
