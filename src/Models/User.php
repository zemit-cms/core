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

use Zemit\Models\Base\AbstractUser;
use Phalcon\Encryption\Security;
use Phalcon\Filter\Validation\Validator\Between;
use Phalcon\Filter\Validation\Validator\Confirmation;
use Phalcon\Filter\Validation\Validator\Date;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\InclusionIn;

use Zemit\Identity;

/**
 * Class User
 *
 * @property UserGroup[] $GroupNode
 * @property Group[] $GroupList
 * @property UserRole[] $RoleNode
 * @property Role[] $RoleList
 * @property UserType[] $TypeNode
 * @property Type[] $TypeList
 * @property File[] $FileList
 * @property Identity $Identity
 *
 * @method UserGroup[] getGroupNode($params = null)
 * @method Group[] getGroupList($params = null)
 * @method UserRole[] getRoleNode($params = null)
 * @method Role[] getRoleList($params = null)
 * @method UserType[] getTypeNode($params = null)
 * @method Type[] getTypeList($params = null)
 * @method File[] getFileList($params = null)
 *
 * @package Zemit\Models
 */
class User extends AbstractUser
{
    protected $language = self::LANG_FR;
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', File::Class, 'userId', ['alias' => 'FileList']);

        $this->hasMany('id', UserGroup::class, 'userId', ['alias' => 'GroupNode']);
        $this->hasManyToMany('id', UserGroup::Class, 'userId',
            'groupId', Group::class, 'id', ['alias' => 'GroupList']);

        $this->hasMany('id', UserRole::class, 'userId', ['alias' => 'RoleNode']);
        $this->hasManyToMany('id', UserRole::Class, 'userId',
            'roleId', Role::class, 'id', ['alias' => 'RoleList']);

        $this->hasMany('id', UserType::class, 'userId', ['alias' => 'TypeNode']);
        $this->hasManyToMany('id', UserType::Class, 'userId',
            'typeId', Type::class, 'id', ['alias' => 'TypeList']);
    }

    public function validation()
    {
        $validator = $this->genericValidation();

        $validator->add('username', new PresenceOf(['message' => $this->_('username') . ': ' . $this->_('required')]));
        $validator->add('email', new Max(['max' => 120, 'message' => $this->_('email') . ': ' . $this->_('length-exceeded')]));

        $validator->add('firstName', new PresenceOf(['message' => $this->_('first-name') . ': ' . $this->_('required')]));
        $validator->add('firstName', new Max(['max' => 60, 'message' => $this->_('first-name') . ': ' . $this->_('length-exceeded')]));

        $validator->add('lastName', new PresenceOf(['message' => $this->_('last-name') . ': ' . $this->_('required')]));
        $validator->add('lastName', new Max(['max' => 60, 'message' => $this->_('last-name') . ': ' . $this->_('length-exceeded')]));

        $validator->add('email', new PresenceOf(['message' => $this->_('email') . ': ' . $this->_('required')]));
        $validator->add('email', new Email(['message' => $this->_('email') . ': ' . 'email-not-valid']));
        $validator->add('email', new Uniqueness(['message' => $this->_('email') . ': ' . $this->_('not-unique')]));
        $validator->add('email', new Max(['max' => 191, 'message' => $this->_('email') . ': ' . $this->_('length-exceeded')]));

        $validator->add('gender', new Between(["minimum" => 0, "maximum" => 1, 'message' => $this->_('boolean-not-valid')]));

        if ($this->getDob()) {
            $validator->add('dob', new Date(['format' => self::DATE_FORMAT, 'message' => $this->_('date-not-valid')]));
        }

        $validator->add(['phone', 'phone2', 'cellphone', 'fax'], new Max(['max' => 60, 'message' => $this->_('length-exceeded')]));

        $validator->add('token', new Max(['max' => 120, 'message' => $this->_('length-exceeded')]));

        // Password
        if (!$this->hasSnapshotData() || $this->hasChanged('password')) {
            $validator->add(['password', 'passwordConfirm'], new Max(['max' => 255, 'message' => 'Le mot de passe ne doit pas dépasser :max caractères']));
            $validator->add('passwordConfirm', new Confirmation([
                'message' => 'La mot de passe et la confirmation doivent être identique',
                'with' => 'password',
            ]));
        }

        return $this->validate($validator);
    }

    /**
     * Prepare save after validation
     */
    public function beforeSave()
    {
        $this->preparePassword();
    }

    /**
     * Salt & hash the passwordConfirm field into password
     */
    public function preparePassword(): void
    {
        $password = $this->getPassword();
        $passwordConfirm = $this->getPasswordConfirm();
        if (!empty($passwordConfirm) && $password === $passwordConfirm) {
            $this->setPassword($this->hash($passwordConfirm));
        }
        $this->setPasswordConfirm(null);
    }

    /**
     * @param string|null $password
     *
     * @return bool If the hash is valid or not
     */
    public function checkPassword(string $password = null): bool
    {
        return $password ? $this->checkHash($this->getPassword(), $password) : false;
    }
}
