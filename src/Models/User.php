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

use Phalcon\Messages\Message;
use Phalcon\Security;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PasswordStrength;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use Phalcon\Validation\Validator\StringLength\Min;
use Phalcon\Validation\Validator\Uniqueness;


/**
 * Class User
 *
 * @property \App\Provider\Square\Square $square
 * @property Identity $identity
 *
 * @package Zemit\Models
 */
class User extends AbstractUser
{
    protected $deleted = self::NO;
    
    /**
     * @var string
     */
    protected $passwordConfirm;
    
    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }
    
    /**
     * Method to set the value of field password
     *
     * @param string $passwordConfirm
     * @return $this
     */
    public function setPassword($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
        
        return $this;
    }
    
    public function initialize()
    {
        parent::initialize();
    }
    
    public function beforeValidationOnCreate()
    {
        if (empty($this->username)) {
            $this->setUsername(md5(uniqid()));
        }
    }
    
    /**
     * Validation
     * @return bool
     */
    public function validation()
    {
        $validator = $this->genericValidation();
        
        // Email
        $validator->add('email', new Uniqueness(['message' => $this->_('notUnique')]));
        $validator->add('email', new Email(['message' => $this->_('notValid')]));
        $validator->add('email', new Max(['message' => $this->_('maxLength'), 'allowEmpty' => true, 'max' => 255]));
        $validator->add('email', new Min(['message' => $this->_('minLength'), 'allowEmpty' => true, 'max' => 6]));
        if (empty($this->getName())) {
            $validator->add('email', new PresenceOf(['message' => $this->_('emailRequired')]));
        }
        
        // Username
        $validator->add('name', new Uniqueness(['message' => $this->_('notUnique')]));
        $validator->add('name', new Max(['message' => $this->_('maxLength'), 'allowEmpty' => true, 'max' => 60]));
        $validator->add('name', new Min(['message' => $this->_('minLength'), 'allowEmpty' => true, 'min' => 6]));
        if (empty($this->getEmail())) {
            $validator->add('name', new PresenceOf(['message' => $this->_('usernameRequired')]));
        }
        
        if (!empty($this->getPasswordConfirm())) {
        
        }

        return $this->validate($validator);
    }
    
    public function prepareSave()
    {
        $this->preparePassword();
    }
    
    /**
     * Change the token hash and return its original value
     */
    public function prepareToken($token = null)
    {
        /** @var Security $security */
        $security = $this->getDI()->get('security');
        
        $token ??= $security->getRandom()->uuid();
        
        $this->setToken($this->hash($token));
        
        return $token;
    }
    
    /**
     * Salt & hash the passwordConfirm field into password
     */
    public function preparePassword()
    {
        $password = $this->getPassword();
        $passwordConfirm = $this->getPasswordConfirm();
        if (!empty($passwordConfirm) && $password === $passwordConfirm) {
            $this->setPassword($this->hash($this->getEmail() . $passwordConfirm));
            $this->setPasswordConfirm(null);
        }
    }
    
    /**
     * @param string $password
     *
     * @return bool If the hash is valid or not
     */
    public function checkPassword(string $password = null)
    {
        return $password ? $this->checkHash($this->getPassword(), $this->getEmail() . $password) : false;
    }
}
