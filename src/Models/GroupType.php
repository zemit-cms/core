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

use Zemit\Models\Base\AbstractGroupType;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class GroupType
 *
 * @package App\Common\Models
 */
class GroupType extends AbstractGroupType
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();
        
        // Belongs to
        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'Group']);
        $this->hasOne('typeId', Type::class, 'id', ['alias' => 'Type']);
    }
    
    public function validation()
    {
        $validator = $this->genericValidation();
        
        $validator->add('groupId', new PresenceOf(['message' => $this->_('groupIdRequired')]));
        $validator->add('typeId', new PresenceOf(['message' => $this->_('typeIdRequired')]));
        $validator->add(['groupId', 'typeId'], new Uniqueness(['message' => $this->_('groupTypeNotUnique')]));
        
        return $this->validate($validator);
    }
}
