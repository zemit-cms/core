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

use Zemit\Models\Base\AbstractUserRole;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class UserRole
 *
 * @package Zemit\Models
 */
class UserRole extends AbstractUserRole
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();
        
        $this->hasOne('userId', User::class, 'id', ['alias' => 'User']);
        $this->hasOne('roleId', Role::class, 'id', ['alias' => 'Role']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        $validator->add('userId', new PresenceOf(['message' => $this->_('userIdRequired')]));
        $validator->add('roleId', new PresenceOf(['message' => $this->_('roleIdRequired')]));
        $validator->add(['userId', 'roleId'], new Uniqueness(['message' => $this->_('userRoleNotUnique')]));
        
        return $this->validate($validator);
    }
}
