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
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;

/**
 * Class UserGroup
 *
 * @property User $UserEntity
 * @property Group $GroupEntity
 *
 * @method User getUserEntity($params = null)
 * @method Group getGroupEntity($params = null)
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

        $this->hasOne('userId', User::class, 'id', ['alias' => 'UserEntity']);
        $this->hasOne('groupId', Group::class, 'id', ['alias' => 'GroupEntity']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('userId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('groupId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['userId', 'groupId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
