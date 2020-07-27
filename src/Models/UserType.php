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

use Zemit\Models\Base\AbstractUserType;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class UserType
 *
 * @package Zemit\Models
 */
class UserType extends AbstractUserType
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();
        
        $this->hasOne('userId', User::class, 'id', ['alias' => 'User']);
        $this->hasOne('typeId', Type::class, 'id', ['alias' => 'Type']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $validator->add('userId', new PresenceOf(['message' => $this->_('userIdRequired')]));
        $validator->add('typeId', new PresenceOf(['message' => $this->_('typeIdRequired')]));
        $validator->add(['userId', 'typeId'], new Uniqueness(['message' => $this->_('userTypeNotUnique')]));
        
        return $this->validate($validator);
    }
}
