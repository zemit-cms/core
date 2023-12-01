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

use Zemit\Models\Abstracts\AbstractGroupRole;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Zemit\Models\Interfaces\GroupRoleInterface;

/**
 * @property Group $Group
 * @property Role $Role
 * @property Group $GroupEntity
 * @property Role $RoleEntity
 *
 * @method Group getGroup(?array $params = null)
 * @method Role getRole(?array $params = null)
 * @method Group getGroupEntity(?array $params = null)
 * @method Role getRoleEntity(?array $params = null)
 */
class GroupRole extends AbstractGroupRole implements GroupRoleInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'GroupEntity']);
        $this->hasOne('roleId', Role::class, 'id', ['alias' => 'RoleEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('groupId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('roleId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['groupId', 'roleId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
