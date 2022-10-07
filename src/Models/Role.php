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

use Zemit\Models\Base\AbstractRole;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

/**
 * Class Role
 *
 * @property UserRole[] $UserNode
 * @property User[] $UserList
 * @property Group[] $GroupList
 * @property GroupRole[] $GroupNode
 *
 * @method UserRole[] getUserNode($params = null)
 * @method User[] getUserList($params = null)
 * @method GroupRole[] getGroupNode($params = null)
 * @method Group[] getGroupList($params = null)
 *
 * @package Zemit\Models
 */
class Role extends AbstractRole
{
    protected $position = 0;
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', UserRole::class, 'roleId', ['alias' => 'UserNode']);
        $this->hasManyToMany('id', UserRole::class, 'roleId',
            'userId', User::class, 'id', ['alias' => 'UserList']);

        $this->hasMany('id', GroupRole::class, 'roleId', ['alias' => 'GroupNode']);
        $this->hasManyToMany('id', GroupRole::class, 'roleId',
            'groupId', Group::class, 'id', ['alias' => 'GroupList']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('index', new PresenceOf(['message' => $this->_('index') .': '. $this->_('required')]));
        $validator->add('index', new Max(['max' => 50, 'message' => $this->_('index') .': '. $this->_('length-exceeded')]));

        $validator->add('label', new PresenceOf(['message' => $this->_('label') .': '. $this->_('required')]));
        $validator->add('label', new Max(['max' => 100, 'message' => $this->_('label') .': '. $this->_('length-exceeded')]));

        return $this->validate($validator);
    }
}
