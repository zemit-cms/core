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

use Zemit\Models\Base\AbstractGroupRole;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class GroupRole
 *
 * @property Group $Group
 * @property Role $Role
 * @property Group $GroupEntity
 * @property Role $RoleEntity
 *
 * @method Group getGroup($params = null)
 * @method Role getRole($params = null)
 * @method Group getGroupEntity($params = null)
 * @method Role getRoleEntity($params = null)
 *
 * @package Zemit\Models
 */
class GroupRole extends AbstractGroupRole
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();

        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'GroupEntity']);
        $this->hasOne('roleId', Role::class, 'id', ['alias' => 'RoleEntity']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('groupId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('roleId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['groupId', 'roleId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
