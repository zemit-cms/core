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

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Zemit\Models\Abstracts\AbstractRole;
use Zemit\Models\Interfaces\RoleInterface;

/**
 * @property UserRole[] $UserNode
 * @property User[] $UserList
 * @property Group[] $GroupList
 * @property GroupRole[] $GroupNode
 *
 * @method UserRole[] getUserNode(?array $params = null)
 * @method User[] getUserList(?array $params = null)
 * @method GroupRole[] getGroupNode(?array $params = null)
 * @method Group[] getGroupList(?array $params = null)
 */
class Role extends AbstractRole implements RoleInterface
{
    protected $position = 0;
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasMany('id', UserRole::class, 'roleId', ['alias' => 'UserNode']);
        $this->hasManyToMany('id', UserRole::class, 'roleId',
            'userId', User::class, 'id', ['alias' => 'UserList']);

        $this->hasMany('id', GroupRole::class, 'roleId', ['alias' => 'GroupNode']);
        $this->hasManyToMany('id', GroupRole::class, 'roleId',
            'groupId', Group::class, 'id', ['alias' => 'GroupList']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('index', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('index', new Max(['max' => 50, 'message' => $this->_('length-exceeded')]));

        $validator->add('label', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('label', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
