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

use Zemit\Models\Abstracts\AbstractUserRole;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Zemit\Models\Interfaces\UserRoleInterface;

/**
 * @property User $UserEntity
 * @property Role $RoleEntity
 *
 * @method User getUserEntity(?array $params = null)
 * @method Role getRoleEntity(?array $params = null)
 */
class UserRole extends AbstractUserRole implements UserRoleInterface
{
    protected $deleted = self::NO;
    protected $position = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('userId', User::class, 'id', ['alias' => 'UserEntity']);
        $this->hasOne('roleId', Role::class, 'id', ['alias' => 'RoleEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();
        
        $validator->add('userId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add('roleId', new PresenceOf(['message' => $this->_('required')]));
        $validator->add(['userId', 'roleId'], new Uniqueness(['message' => $this->_('not-unique')]));

        return $this->validate($validator);
    }
}
