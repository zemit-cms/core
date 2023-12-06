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

use Zemit\Models\Abstracts\AbstractGroup;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Zemit\Models\Interfaces\GroupInterface;

/**
 * @property UserGroup[] $UserNode
 * @method UserGroup[] getUserNode(?array $params = null)
 *
 * @property User[] $UserList
 * @method User[] getUserList(?array $params = null)
 *
 * @property GroupRole[] $RoleNode
 * @method GroupRole[] getRoleNode(?array $params = null)
 *
 * @property Role[] $RoleList
 * @method Role[] getRoleList(?array $params = null)
 *
 * @property GroupType[] $TypeNode
 * @method GroupType[] getTypeNode(?array $params = null)
 *
 * @property Type[] $TypeList
 * @method Type[] getTypeList(?array $params = null)
 */
class Group extends AbstractGroup implements GroupInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        // User relationship
        $this->hasMany('id', UserGroup::class, 'groupId', ['alias' => 'UserNode']);
        $this->hasManyToMany(
            'id',
            UserGroup::Class,
            'groupId',
            'userId',
            User::class,
            'id',
            ['alias' => 'UserList']
        );

        // Role relationship
        $this->hasMany('id', GroupRole::class, 'groupId', ['alias' => 'RoleNode']);
        $this->hasManyToMany(
            'id',
            GroupRole::class,
            'groupId',
            'roleId',
            Role::class,
            'id',
            ['alias' => 'RoleList']
        );

        // Type relationship
        $this->hasMany('id', GroupType::class, 'groupId', ['alias' => 'TypeNode']);
        $this->hasManyToMany(
            'id',
            GroupType::class,
            'groupId',
            'typeId',
            Type::class,
            'id',
            ['alias' => 'TypeList']
        );
    }

    public function beforeValidation()
    {
        if (!$this->index) {
            $this->setIndex($this->getLabel());
        }
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('index', new Max(['max' => 50, 'message' => $this->_('length-exceeded')]));
        $validator->add('index', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('label', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('label', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
