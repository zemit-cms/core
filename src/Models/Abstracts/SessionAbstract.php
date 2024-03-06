<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Models\Abstracts;

use Phalcon\Db\RawValue;
use Zemit\Filter\Validation;
use Zemit\Models\AbstractModel;
use Zemit\Models\User;
use Zemit\Models\AsUser;
use Zemit\Models\Abstracts\Interfaces\SessionAbstractInterface;

/**
 * Class SessionAbstract
 *
 * This class defines a Session abstract model that extends the AbstractModel class and implements the SessionAbstractInterface.
 * It provides properties and methods for managing Session data.
 * 
 * @property User $UserEntity
 * @method User getUserEntity(?array $params = null)
 *
 * @property AsUser $AsUserEntity
 * @method AsUser getAsUserEntity(?array $params = null)
 */
abstract class SessionAbstract extends AbstractModel implements SessionAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public $id = null;
        
    /**
     * Column: user_id
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $userId = null;
        
    /**
     * Column: as_user_id
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $asUserId = null;
        
    /**
     * Column: key
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public $key = null;
        
    /**
     * Column: token
     * Attributes: NotNull | Size(128) | Type(2)
     * @var mixed
     */
    public $token = null;
        
    /**
     * Column: jwt
     * Attributes: Type(6)
     * @var mixed
     */
    public $jwt = null;
        
    /**
     * Column: meta
     * Attributes: Type(6)
     * @var mixed
     */
    public $meta = null;
        
    /**
     * Column: date
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public $date = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public $createdAt = null;
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdBy = null;
        
    /**
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdAs = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedBy = null;
        
    /**
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedAs = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $deletedAt = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedBy = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedAs = null;
        
    /**
     * Column: restored_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $restoredAt = null;
        
    /**
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $restoredBy = null;
        
    /**
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $restoredAs = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field userId
     * Column: user_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $userId
     * @return void
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * Returns the value of field asUserId
     * Column: as_user_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getAsUserId()
    {
        return $this->asUserId;
    }
    
    /**
     * Sets the value of field asUserId
     * Column: as_user_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $asUserId
     * @return void
     */
    public function setAsUserId($asUserId)
    {
        $this->asUserId = $asUserId;
    }
    
    /**
     * Returns the value of field key
     * Column: key
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }
    
    /**
     * Sets the value of field key
     * Column: key 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $key
     * @return void
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
    
    /**
     * Returns the value of field token
     * Column: token
     * Attributes: NotNull | Size(128) | Type(2)
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * Sets the value of field token
     * Column: token 
     * Attributes: NotNull | Size(128) | Type(2)
     * @param mixed $token
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
    
    /**
     * Returns the value of field jwt
     * Column: jwt
     * Attributes: Type(6)
     * @return mixed
     */
    public function getJwt()
    {
        return $this->jwt;
    }
    
    /**
     * Sets the value of field jwt
     * Column: jwt 
     * Attributes: Type(6)
     * @param mixed $jwt
     * @return void
     */
    public function setJwt($jwt)
    {
        $this->jwt = $jwt;
    }
    
    /**
     * Returns the value of field meta
     * Column: meta
     * Attributes: Type(6)
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * Attributes: Type(6)
     * @param mixed $meta
     * @return void
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }
    
    /**
     * Returns the value of field date
     * Column: date
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Sets the value of field date
     * Column: date 
     * Attributes: NotNull | Type(4)
     * @param mixed $date
     * @return void
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs()
    {
        return $this->createdAs;
    }
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs($createdAs)
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs()
    {
        return $this->updatedAs;
    }
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs($updatedAs)
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs()
    {
        return $this->deletedAs;
    }
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs($deletedAs)
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt()
    {
        return $this->restoredAt;
    }
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt($restoredAt)
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy()
    {
        return $this->restoredBy;
    }
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy($restoredBy)
    {
        $this->restoredBy = $restoredBy;
    }
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs()
    {
        return $this->restoredAs;
    }
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs($restoredAs)
    {
        $this->restoredAs = $restoredAs;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->belongsTo('userId', User::class, 'id', ['alias' => 'UserEntity']);

        $this->belongsTo('asUserId', AsUser::class, 'id', ['alias' => 'AsUserEntity']);
    }
    
    /**
     * Adds the default validations to the model.
     * @param Validation|null $validator
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addUnsignedIntValidation($validator, 'userId', true);
        $this->addUnsignedIntValidation($validator, 'asUserId', true);
        $this->addStringLengthValidation($validator, 'key', 0, 60, false);
        $this->addStringLengthValidation($validator, 'token', 0, 128, false);
        $this->addDateTimeValidation($validator, 'date', false);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        $this->addUnsignedIntValidation($validator, 'createdAs', true);
        $this->addDateTimeValidation($validator, 'updatedAt', true);
        $this->addUnsignedIntValidation($validator, 'updatedBy', true);
        $this->addUnsignedIntValidation($validator, 'updatedAs', true);
        $this->addDateTimeValidation($validator, 'deletedAt', true);
        $this->addUnsignedIntValidation($validator, 'deletedBy', true);
        $this->addUnsignedIntValidation($validator, 'deletedAs', true);
        $this->addDateTimeValidation($validator, 'restoredAt', true);
        $this->addUnsignedIntValidation($validator, 'restoredBy', true);
        $this->addUnsignedIntValidation($validator, 'restoredAs', true);
        
        return $validator;
    }

        
    /**
     * Returns an array that maps the column names of the database
     * table to the corresponding property names of the model.
     * 
     * @returns array The array mapping the column names to the property names
     */
    public function columnMap(): array {
        return [
            'id' => 'id',
            'user_id' => 'userId',
            'as_user_id' => 'asUserId',
            'key' => 'key',
            'token' => 'token',
            'jwt' => 'jwt',
            'meta' => 'meta',
            'date' => 'date',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'created_as' => 'createdAs',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'updated_as' => 'updatedAs',
            'deleted_at' => 'deletedAt',
            'deleted_by' => 'deletedBy',
            'deleted_as' => 'deletedAs',
            'restored_at' => 'restoredAt',
            'restored_by' => 'restoredBy',
            'restored_as' => 'restoredAs',
        ];
    }
}