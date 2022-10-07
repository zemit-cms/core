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
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;

/**
 * Class UserType
 *
 * @property User $UserEntity
 * @property Type $TypeEntity
 *
 * @method User getUserEntity($params = null)
 * @method Type getTypeEntity($params = null)
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

        $this->hasOne('userId', User::class, 'id', ['alias' => 'UserEntity']);
        $this->hasOne('typeId', Type::class, 'id', ['alias' => 'TypeEntity']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('userId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('typeId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['userId', 'typeId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
