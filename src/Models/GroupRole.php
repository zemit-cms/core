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

use Zemit\Models\Abstracts\GroupRoleAbstract;
use Zemit\Models\Interfaces\GroupRoleInterface;

/**
 * Class GroupRole
 *
 * This class represents a GroupRole object.
 * It extends the GroupRoleAbstract class and implements the GroupRoleInterface.
 */
class GroupRole extends GroupRoleAbstract implements GroupRoleInterface
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
