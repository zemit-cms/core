<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Zemit\Models\Abstracts\AbstractRoleRole;
use Zemit\Models\Interfaces\RoleRoleInterface;

/**
 * @property Role $Parent
 * @method Role getParent(?array $params = null)
 * 
 * @property Role $Child
 * @method Role getChild(?array $params = null)
 */
class RoleRole extends AbstractRoleRole implements RoleRoleInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('parentId', Role::class, 'id', ['alias' => 'Parent']);
        $this->hasOne('childId', Role::class, 'id', ['alias' => 'Child']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        $this->addUniquenessValidation($validator, ['parentId', 'childId']);
        $this->addUnsignedIntValidation($validator, 'parentId', false);
        $this->addUnsignedIntValidation($validator, 'childId', false);

        return $this->validate($validator);
    }
}
