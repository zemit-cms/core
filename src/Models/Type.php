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

use Zemit\Models\Base\AbstractType;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Type
 *
 * @property UserType[] $UserNode
 * @property User[] $UserList
 * @property GroupType $GroupNode
 * @property Group[] $GroupList
 *
 * @method UserType[] getUserNode($params = null)
 * @method User[] getUserList($params = null)
 * @method GroupType getGroupNode($params = null)
 * @method Group[] getGroupList($params = null)
 *
 * @package Zemit\Models
 */
class Type extends AbstractType
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();

        // User relationship
        $this->hasMany('id', UserType::class, 'typeId', ['alias' => 'UserNode']);
        $this->hasManyToMany('id', UserType::class, 'typeId',
            'userId', User::class, 'id', ['alias' => 'UserList']);

        // Group relationship
        $this->hasMany('id', GroupType::class, 'typeId', ['alias' => 'GroupNode']);
        $this->hasManyToMany('id', GroupType::class, 'typeId',
            'groupId', Group::class, 'id', ['alias' => 'GroupList']);
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
