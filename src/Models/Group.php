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

use Zemit\Models\Base\AbstractGroup;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Group
 *
 * @property UserGroup[] $UserNode
 * @property User[] $UserList
 * @property GroupRole[] $RoleNode
 * @property Role[] $RoleList
 * @property GroupType[] $TypeNode
 * @property Type[] $TypeList
 *
 * @method UserGroup[] getUserNode($params = null)
 * @method User[] getUserList($params = null)
 * @method GroupRole[] getRoleNode($params = null)
 * @method Role[] getRoleList($params = null)
 * @method GroupType[] getTypeNode($params = null)
 * @method Type[] getTypeList($params = null)
 *
 * @package Zemit\Models
 */
class Group extends AbstractGroup
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();

        // User relationship
        $this->hasMany('id', UserGroup::class, 'groupId', ['alias' => 'UserNode']);
        $this->hasManyToMany('id', UserGroup::Class, 'groupId',
            'userId', User::class, 'id', ['alias' => 'UserList']);

        // Role relationship
        $this->hasMany('id', GroupRole::class, 'groupId', ['alias' => 'RoleNode']);
        $this->hasManyToMany('id', GroupRole::class, 'groupId',
            'roleId', Role::class, 'id', ['alias' => 'RoleList']);

        // Type relationship
        $this->hasMany('id', GroupType::class, 'groupId', ['alias' => 'TypeNode']);
        $this->hasManyToMany('id', GroupType::class, 'groupId',
            'typeId', Type::class, 'id', ['alias' => 'TypeList']);
    }

    public function beforeValidation()
    {
        if (!$this->index) {
            $this->setIndex($this->getLabel());
        }
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('index', new Max(['max' => 50, 'message' => $this->_('length-exceeded')]));
        $validator->add('index', new PresenceOf(['message' => $this->_('required')]));

        $validator->add('label', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('label', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
