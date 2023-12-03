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
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Zemit\Models\Interfaces\GroupeTypeInterface;

/**
 * @property Group $Group
 * @property Type $Type
 * @property Group $GroupEntity
 * @property Type $TypeEntity
 *
 * @method Group getGroup(?array $params = null)
 * @method Type getType(?array $params = null)
 * @method Group getGroupEntity(?array $params = null)
 * @method Type getTypeEntity(?array $params = null)
 */
class GroupType extends AbstractGroupType implements GroupeTypeInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'GroupEntity']);
        $this->hasOne('typeId', Type::class, 'id', ['alias' => 'TypeEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('groupId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('typeId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['groupId', 'typeId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
