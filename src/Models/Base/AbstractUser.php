<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * --------------------------------------------------------------
 *
 * New BSD License
 *
 * Copyright (c) 2017-present, Zemit CMS Team
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Zemit nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL ZEMIT FRAMEWORK TEAM BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Zemit\Models\Base;

use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\ResultInterface;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Zemit\Models\AbstractModel;

/**
 * AbstractUser
 * @package Zemit\Models\Base
 * @autogenerated by Phalcon Developer Tools
 * @date 2023-03-02, 21:36:47
 */
abstract class AbstractUser extends AbstractModel
{
    /**
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string
     * @Column(column="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @Column(column="username", type="string", length=120, nullable=true)
     */
    protected $username;

    /**
     * @var integer
     * @Column(column="mfa", type="integer", nullable=false)
     */
    protected $mfa;

    /**
     * @var string
     * @Column(column="mfa_secret", type="string", length=255, nullable=true)
     */
    protected $mfaSecret;

    /**
     * @var string
     * @Column(column="token", type="string", length=120, nullable=true)
     */
    protected $token;

    /**
     * @var string
     * @Column(column="password", type="string", length=255, nullable=true)
     */
    protected $password;

    /**
     * @var string
     * @Column(column="password_confirm", type="string", length=255, nullable=true)
     */
    protected $passwordConfirm;

    /**
     * @var string
     * @Column(column="salt", type="string", length=255, nullable=true)
     */
    protected $salt;

    /**
     * @var string
     * @Column(column="first_name", type="string", length=120, nullable=false)
     */
    protected $firstName;

    /**
     * @var string
     * @Column(column="last_name", type="string", length=120, nullable=false)
     */
    protected $lastName;

    /**
     * @var integer
     * @Column(column="gender", type="integer", nullable=true)
     */
    protected $gender;

    /**
     * @var string
     * @Column(column="dob", type="string", nullable=true)
     */
    protected $dob;

    /**
     * @var string
     * @Column(column="title", type="string", length=120, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @Column(column="phone", type="string", length=60, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     * @Column(column="phone2", type="string", length=60, nullable=true)
     */
    protected $phone2;

    /**
     * @var string
     * @Column(column="cellphone", type="string", length=60, nullable=true)
     */
    protected $cellphone;

    /**
     * @var string
     * @Column(column="fax", type="string", length=60, nullable=true)
     */
    protected $fax;

    /**
     * @var string
     * @Column(column="status", type="string", length='new','pending','approved','not_approved', nullable=true)
     */
    protected $status;

    /**
     * @var string
     * @Column(column="category", type="string", length='company','employee','other','banned','guest', nullable=false)
     */
    protected $category;

    /**
     * @var string
     * @Column(column="language", type="string", length='fr','en', nullable=false)
     */
    protected $language;

    /**
     * @var integer
     * @Column(column="newsletter", type="integer", nullable=false)
     */
    protected $newsletter;

    /**
     * @var integer
     * @Column(column="company_id", type="integer", nullable=true)
     */
    protected $companyId;

    /**
     * @var integer
     * @Column(column="deleted", type="integer", nullable=false)
     */
    protected $deleted;

    /**
     * @var string
     * @Column(column="created_at", type="string", nullable=false)
     */
    protected $createdAt;

    /**
     * @var integer
     * @Column(column="created_by", type="integer", nullable=true)
     */
    protected $createdBy;

    /**
     * @var integer
     * @Column(column="created_as", type="integer", nullable=true)
     */
    protected $createdAs;

    /**
     * @var string
     * @Column(column="updated_at", type="string", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var integer
     * @Column(column="updated_by", type="integer", nullable=true)
     */
    protected $updatedBy;

    /**
     * @var integer
     * @Column(column="updated_as", type="integer", nullable=true)
     */
    protected $updatedAs;

    /**
     * @var string
     * @Column(column="deleted_at", type="string", nullable=true)
     */
    protected $deletedAt;

    /**
     * @var integer
     * @Column(column="deleted_as", type="integer", nullable=true)
     */
    protected $deletedAs;

    /**
     * @var integer
     * @Column(column="deleted_by", type="integer", nullable=true)
     */
    protected $deletedBy;

    /**
     * @var string
     * @Column(column="restored_at", type="string", nullable=true)
     */
    protected $restoredAt;

    /**
     * @var integer
     * @Column(column="restored_by", type="integer", nullable=true)
     */
    protected $restoredBy;

    /**
     * @var integer
     * @Column(column="restored_as", type="integer", nullable=true)
     */
    protected $restoredAs;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Method to set the value of field username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Returns the value of field username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Method to set the value of field mfa
     *
     * @param integer $mfa
     * @return $this
     */
    public function setMfa($mfa)
    {
        $this->mfa = $mfa;

        return $this;
    }

    /**
     * Returns the value of field mfa
     *
     * @return integer
     */
    public function getMfa()
    {
        return $this->mfa;
    }

    /**
     * Method to set the value of field mfa_secret
     *
     * @param string $mfaSecret
     * @return $this
     */
    public function setMfaSecret($mfaSecret)
    {
        $this->mfaSecret = $mfaSecret;

        return $this;
    }

    /**
     * Returns the value of field mfa_secret
     *
     * @return string
     */
    public function getMfaSecret()
    {
        return $this->mfaSecret;
    }

    /**
     * Method to set the value of field token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Returns the value of field token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Method to set the value of field password_confirm
     *
     * @param string $passwordConfirm
     * @return $this
     */
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    /**
     * Returns the value of field password_confirm
     *
     * @return string
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * Method to set the value of field salt
     *
     * @param string $salt
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Returns the value of field salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Method to set the value of field first_name
     *
     * @param string $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Returns the value of field first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Method to set the value of field last_name
     *
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Returns the value of field last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Method to set the value of field gender
     *
     * @param integer $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Returns the value of field gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Method to set the value of field dob
     *
     * @param string $dob
     * @return $this
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Returns the value of field dob
     *
     * @return string
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Method to set the value of field phone
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Returns the value of field phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Method to set the value of field phone2
     *
     * @param string $phone2
     * @return $this
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Returns the value of field phone2
     *
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Method to set the value of field cellphone
     *
     * @param string $cellphone
     * @return $this
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Returns the value of field cellphone
     *
     * @return string
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Method to set the value of field fax
     *
     * @param string $fax
     * @return $this
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Returns the value of field fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Method to set the value of field status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Method to set the value of field category
     *
     * @param string $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Returns the value of field category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Method to set the value of field language
     *
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Returns the value of field language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Method to set the value of field newsletter
     *
     * @param integer $newsletter
     * @return $this
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Returns the value of field newsletter
     *
     * @return integer
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Method to set the value of field company_id
     *
     * @param integer $companyId
     * @return $this
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Returns the value of field company_id
     *
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Method to set the value of field deleted
     *
     * @param integer $deleted
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Returns the value of field deleted
     *
     * @return integer
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Method to set the value of field created_at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns the value of field created_at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Method to set the value of field created_by
     *
     * @param integer $createdBy
     * @return $this
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Returns the value of field created_by
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Method to set the value of field created_as
     *
     * @param integer $createdAs
     * @return $this
     */
    public function setCreatedAs($createdAs)
    {
        $this->createdAs = $createdAs;

        return $this;
    }

    /**
     * Returns the value of field created_as
     *
     * @return integer
     */
    public function getCreatedAs()
    {
        return $this->createdAs;
    }

    /**
     * Method to set the value of field updated_at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the value of field updated_at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Method to set the value of field updated_by
     *
     * @param integer $updatedBy
     * @return $this
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Returns the value of field updated_by
     *
     * @return integer
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Method to set the value of field updated_as
     *
     * @param integer $updatedAs
     * @return $this
     */
    public function setUpdatedAs($updatedAs)
    {
        $this->updatedAs = $updatedAs;

        return $this;
    }

    /**
     * Returns the value of field updated_as
     *
     * @return integer
     */
    public function getUpdatedAs()
    {
        return $this->updatedAs;
    }

    /**
     * Method to set the value of field deleted_at
     *
     * @param string $deletedAt
     * @return $this
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Returns the value of field deleted_at
     *
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Method to set the value of field deleted_as
     *
     * @param integer $deletedAs
     * @return $this
     */
    public function setDeletedAs($deletedAs)
    {
        $this->deletedAs = $deletedAs;

        return $this;
    }

    /**
     * Returns the value of field deleted_as
     *
     * @return integer
     */
    public function getDeletedAs()
    {
        return $this->deletedAs;
    }

    /**
     * Method to set the value of field deleted_by
     *
     * @param integer $deletedBy
     * @return $this
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * Returns the value of field deleted_by
     *
     * @return integer
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * Method to set the value of field restored_at
     *
     * @param string $restoredAt
     * @return $this
     */
    public function setRestoredAt($restoredAt)
    {
        $this->restoredAt = $restoredAt;

        return $this;
    }

    /**
     * Returns the value of field restored_at
     *
     * @return string
     */
    public function getRestoredAt()
    {
        return $this->restoredAt;
    }

    /**
     * Method to set the value of field restored_by
     *
     * @param integer $restoredBy
     * @return $this
     */
    public function setRestoredBy($restoredBy)
    {
        $this->restoredBy = $restoredBy;

        return $this;
    }

    /**
     * Returns the value of field restored_by
     *
     * @return integer
     */
    public function getRestoredBy()
    {
        return $this->restoredBy;
    }

    /**
     * Method to set the value of field restored_as
     *
     * @param integer $restoredAs
     * @return $this
     */
    public function setRestoredAs($restoredAs)
    {
        $this->restoredAs = $restoredAs;

        return $this;
    }

    /**
     * Returns the value of field restored_as
     *
     * @return integer
     */
    public function getRestoredAs()
    {
        return $this->restoredAs;
    }

    /**
     * Validations and business logic
     *
     * @return bool
     */
    public function validation()
    {
        $validator = new Validation();
        $validator->add('email', new EmailValidator([
            'model'   => $this,
            'message' => 'Please enter a correct email address',
        ]));
        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
		parent::initialize();
        // $this->setSchema('zemit_core');
        $this->setSource('user');
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUser[]|AbstractUser|ResultsetInterface
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractUser|ResultInterface|ModelInterface|null
     */
    public static function findFirst($parameters = null): ?ModelInterface
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'email' => 'email',
            'username' => 'username',
            'mfa' => 'mfa',
            'mfa_secret' => 'mfaSecret',
            'token' => 'token',
            'password' => 'password',
            'password_confirm' => 'passwordConfirm',
            'salt' => 'salt',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'gender' => 'gender',
            'dob' => 'dob',
            'title' => 'title',
            'phone' => 'phone',
            'phone2' => 'phone2',
            'cellphone' => 'cellphone',
            'fax' => 'fax',
            'status' => 'status',
            'category' => 'category',
            'language' => 'language',
            'newsletter' => 'newsletter',
            'company_id' => 'companyId',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'created_as' => 'createdAs',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'updated_as' => 'updatedAs',
            'deleted_at' => 'deletedAt',
            'deleted_as' => 'deletedAs',
            'deleted_by' => 'deletedBy',
            'restored_at' => 'restoredAt',
            'restored_by' => 'restoredBy',
            'restored_as' => 'restoredAs',
        ];
    }
}
