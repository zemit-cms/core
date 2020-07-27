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
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class Role
 *
* @package Zemit\Models
*/
class Role extends AbstractRole
{
    protected $position = self::NO;
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        // User relationship
        $this->hasMany('id', UserRole::class, 'roleId', ['alias' => 'RoleNode']);
        $this->hasManyToMany('id', UserRole::class, 'roleId',
            'userId', User::class, 'id', ['alias' => 'UserList']);

        // Group relationship
        $this->hasMany('id', GroupRole::class, 'roleId', ['alias' => 'GroupNode']);
        $this->hasManyToMany('id', GroupRole::class, 'roleId',
            'groupId', Group::class, 'id', ['alias' => 'GroupList']);
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
