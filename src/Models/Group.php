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
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Group
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
        $this->hasMany('id', UserGroup::class, 'groupId', ['alias' => 'GroupNode']);
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
    
    public function validation()
    {
        $validator = $this->genericValidation();

        // index
        $validator->add('index', new Max(['max' => 50, 'message' => $this->_('indexLengthExceeded'), 'included' => true]));
        $validator->add('index', new PresenceOf(['message' => $this->_('indexRequired')]));
    
        // Label Fr
        $validator->add('labelFr', new PresenceOf(['message' => $this->_('labelFrRequired')]));
        $validator->add('labelFr', new Max(['max' => 100, 'message' => $this->_('labelFrLengthExceeded'), 'included' => true]));
    
        // Label En
        $validator->add('labelEn', new PresenceOf(['message' => $this->_('labelEnRequired')]));
        $validator->add('labelFr', new Max(['max' => 100, 'message' => $this->_('labelFrLengthExceeded'), 'included' => true]));
        
        return $this->validate($validator);
    }
}
