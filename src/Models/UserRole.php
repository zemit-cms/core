<?php

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhalconKit\Models;

use PhalconKit\Models\Abstracts\UserRoleAbstract;
use PhalconKit\Models\Interfaces\UserRoleInterface;

/**
 * Class UserRole
 *
 * This class represents a UserRole object.
 * It extends the UserRoleAbstract class and implements the UserRoleInterface.
 */
class UserRole extends UserRoleAbstract implements UserRoleInterface
{
    #[\Override]
    public function initialize(): void
    {
        parent::initialize();
        $this->addDefaultRelationships();
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        $this->addDefaultValidations($validator);
        return $this->validate($validator);
    }
}
