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

use Zemit\Models\Base\AbstractGroupType;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class GroupType
 *
 * @property Group $Group
 * @property Type $Type
 * @property Group $GroupEntity
 * @property Type $TypeEntity
 *
 * @method Group getGroup($params = null)
 * @method Type getType($params = null)
 * @method Group getGroupEntity($params = null)
 * @method Type getTypeEntity($params = null)
 *
 * @package Zemit\Models
 */
class GroupType extends AbstractGroupType
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize()
    {
        parent::initialize();

        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'GroupEntity']);
        $this->hasOne('typeId', Type::class, 'id', ['alias' => 'TypeEntity']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('groupId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('typeId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['groupId', 'typeId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
