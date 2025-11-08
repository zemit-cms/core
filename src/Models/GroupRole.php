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

use PhalconKit\Models\Abstracts\GroupRoleAbstract;
use PhalconKit\Models\Interfaces\GroupRoleInterface;

/**
 * Class GroupRole
 *
 * This class represents a GroupRole object.
 * It extends the GroupRoleAbstract class and implements the GroupRoleInterface.
 */
class GroupRole extends GroupRoleAbstract implements GroupRoleInterface
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
