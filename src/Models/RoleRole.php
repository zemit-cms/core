<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);
 
namespace Zemit\Models;

use Zemit\Models\Abstracts\RoleRoleAbstract;
use Zemit\Models\Interfaces\RoleRoleInterface;

/**
 * Class RoleRole
 *
 * This class represents a RoleRole model.
 * It extends the RoleRoleAbstract class and implements the RoleRoleInterface.
 */
class RoleRole extends RoleRoleAbstract implements RoleRoleInterface
{
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