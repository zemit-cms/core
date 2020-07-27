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

use Zemit\Models\Base\AbstractUserGroup;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class UserGroup
 *
 * @package Zemit\Models
 */
class UserGroup extends AbstractUserGroup
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();
        
        $this->hasOne('userId', User::class, 'id', ['alias' => 'User']);
        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'Group']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $validator->add('userId', new PresenceOf(['message' => $this->_('userIdRequired')]));
        $validator->add('groupId', new PresenceOf(['message' => $this->_('groupIdRequired')]));
        $validator->add(['userId', 'groupId'], new Uniqueness(['message' => $this->_('userGroupNotUnique')]));
        
        return $this->validate($validator);
    }
}
