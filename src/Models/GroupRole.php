<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace App\Common\Models;

use Zemit\Models\Base\AbstractGroupRole;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class GroupRole
 *
 * @package App\Common\Models
 */
class GroupRole extends AbstractGroupRole
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();
        
        // Belongs to
        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'Group']);
        $this->hasOne('roleId', Role::class, 'id', ['alias' => 'Role']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $validator->add('groupId', new PresenceOf(['message' => $this->_('groupIdRequired')]));
        $validator->add('roleId', new PresenceOf(['message' => $this->_('roleIdRequired')]));
        $validator->add(['groupId', 'roleId'], new Uniqueness(['message' => $this->_('groupRoleNotUnique')]));
        
        return $this->validate($validator);
    }
}
