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

use PhalconKit\Models\Abstracts\RoleRoleAbstract;
use PhalconKit\Models\Interfaces\RoleRoleInterface;

/**
 * Class RoleRole
 *
 * This class represents a RoleRole object.
 * It extends the RoleRoleAbstract class and implements the RoleRoleInterface.
 */
class RoleRole extends RoleRoleAbstract implements RoleRoleInterface
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
