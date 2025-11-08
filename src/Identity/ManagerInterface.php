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

namespace PhalconKit\Identity;

use PhalconKit\Identity\Traits\Interfaces\AclInterface;
use PhalconKit\Identity\Traits\Interfaces\ImpersonationInterface;
use PhalconKit\Identity\Traits\Interfaces\JwtInterface;
use PhalconKit\Identity\Traits\Interfaces\Oauth2Interface;
use PhalconKit\Identity\Traits\Interfaces\RoleInterface;
use PhalconKit\Identity\Traits\Interfaces\SessionInterface;
use PhalconKit\Identity\Traits\Interfaces\UserInterface;

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
