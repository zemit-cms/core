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

use Zemit\Models\Abstracts\AbstractGroupType;
use Zemit\Models\Interfaces\GroupTypeInterface;

/**
 * @property Group $Group
 * @method Group getGroup(?array $params = null)
 *
 * @property Type $Type
 * @method Type getType(?array $params = null)
 */
class GroupType extends AbstractGroupType implements GroupTypeInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;
    
    public function initialize(): void
    {
        parent::initialize();
        
        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'Group']);
        $this->hasOne('typeId', Type::class, 'id', ['alias' => 'Type']);
    }
    
    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        $this->addUnsignedIntValidation($validator, 'groupId', false);
        $this->addUnsignedIntValidation($validator, 'typeId', false);
        $this->addUniquenessValidation($validator, ['groupId', 'typeId'], false);
        
        return $this->validate($validator);
    }
}
