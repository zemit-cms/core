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

use Zemit\Models\Abstracts\UserRoleAbstract;
use Zemit\Models\Interfaces\UserRoleInterface;

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
