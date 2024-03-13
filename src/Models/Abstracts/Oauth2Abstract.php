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
use Zemit\Models\Abstracts\Interfaces\Oauth2AbstractInterface;

/**
 * Class Oauth2Abstract
 *
 * This class defines a Oauth2 abstract model that extends the AbstractModel class and implements the Oauth2AbstractInterface.
 * It provides properties and methods for managing Oauth2 data.
 * 
 * @property User $userentity
 * @property User $UserEntity
 * @method User getUserEntity(?array $params = null)
 *
 * @property User $createdbyentity
 * @property User $CreatedByEntity
 * @method User getCreatedByEntity(?array $params = null)
 *
 * @property User $createdasentity
 * @property User $CreatedAsEntity
 * @method User getCreatedAsEntity(?array $params = null)
 *
 * @property User $updatedbyentity
 * @property User $UpdatedByEntity
 * @method User getUpdatedByEntity(?array $params = null)
 *
 * @property User $updatedasentity
 * @property User $UpdatedAsEntity
 * @method User getUpdatedAsEntity(?array $params = null)
 *
 * @property User $deletedasentity
 * @property User $DeletedAsEntity
 * @method User getDeletedAsEntity(?array $params = null)
 *
 * @property User $deletedbyentity
 * @property User $DeletedByEntity
 * @method User getDeletedByEntity(?array $params = null)
 *
 * @property User $restoredbyentity
 * @property User $RestoredByEntity
 * @method User getRestoredByEntity(?array $params = null)
 */
abstract class Oauth2Abstract extends AbstractModel implements Oauth2AbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public mixed $id = null;
        
    /**
     * Column: user_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public mixed $userId = null;
        
    /**
     * Column: provider
     * Attributes: NotNull | Size('google','microsoft') | Type(18)
     * @var mixed
     */
    public mixed $provider = null;
        
    /**
     * Column: provider_uuid
     * Attributes: NotNull | Size(120) | Type(2)
     * @var mixed
     */
    public mixed $providerUuid = null;
        
    /**
     * Column: access_token
     * Attributes: NotNull | Size(120) | Type(2)
     * @var mixed
     */
    public mixed $accessToken = null;
        
    /**
     * Column: refresh_token
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public mixed $refreshToken = null;
        
    /**
     * Column: email
     * Attributes: Size(320) | Type(2)
     * @var mixed
     */
    public mixed $email = null;
        
    /**
     * Column: name
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public mixed $name = null;
        
    /**
     * Column: first_name
     * Attributes: Size(60) | Type(2)
     * @var mixed
     */
    public mixed $firstName = null;
        
    /**
     * Column: last_name
     * Attributes: Size(60) | Type(2)
     * @var mixed
     */
    public mixed $lastName = null;
        
    /**
     * Column: meta
     * Attributes: Type(15)
     * @var mixed
     */
    public mixed $meta = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public mixed $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public mixed $createdAt = null;
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $createdBy = null;
        
    /**
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $createdAs = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $updatedBy = null;
        
    /**
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $updatedAs = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $deletedAt = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedAs = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedBy = null;
        
    /**
     * Column: restored_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $restoredAt = null;
        
    /**
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $restoredBy = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId(): mixed
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
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field userId
     * Column: user_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getUserId(): mixed
    {
        return $this->userId;
    }
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $userId
     * @return void
     */
    public function setUserId(mixed $userId): void
    {
        $this->userId = $userId;
    }
    
    /**
     * Returns the value of field provider
     * Column: provider
     * Attributes: NotNull | Size('google','microsoft') | Type(18)
     * @return mixed
     */
    public function getProvider(): mixed
    {
        return $this->provider;
    }
    
    /**
     * Sets the value of field provider
     * Column: provider 
     * Attributes: NotNull | Size('google','microsoft') | Type(18)
     * @param mixed $provider
     * @return void
     */
    public function setProvider(mixed $provider): void
    {
        $this->provider = $provider;
    }
    
    /**
     * Returns the value of field providerUuid
     * Column: provider_uuid
     * Attributes: NotNull | Size(120) | Type(2)
     * @return mixed
     */
    public function getProviderUuid(): mixed
    {
        return $this->providerUuid;
    }
    
    /**
     * Sets the value of field providerUuid
     * Column: provider_uuid 
     * Attributes: NotNull | Size(120) | Type(2)
     * @param mixed $providerUuid
     * @return void
     */
    public function setProviderUuid(mixed $providerUuid): void
    {
        $this->providerUuid = $providerUuid;
    }
    
    /**
     * Returns the value of field accessToken
     * Column: access_token
     * Attributes: NotNull | Size(120) | Type(2)
     * @return mixed
     */
    public function getAccessToken(): mixed
    {
        return $this->accessToken;
    }
    
    /**
     * Sets the value of field accessToken
     * Column: access_token 
     * Attributes: NotNull | Size(120) | Type(2)
     * @param mixed $accessToken
     * @return void
     */
    public function setAccessToken(mixed $accessToken): void
    {
        $this->accessToken = $accessToken;
    }
    
    /**
     * Returns the value of field refreshToken
     * Column: refresh_token
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getRefreshToken(): mixed
    {
        return $this->refreshToken;
    }
    
    /**
     * Sets the value of field refreshToken
     * Column: refresh_token 
     * Attributes: Size(120) | Type(2)
     * @param mixed $refreshToken
     * @return void
     */
    public function setRefreshToken(mixed $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }
    
    /**
     * Returns the value of field email
     * Column: email
     * Attributes: Size(320) | Type(2)
     * @return mixed
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }
    
    /**
     * Sets the value of field email
     * Column: email 
     * Attributes: Size(320) | Type(2)
     * @param mixed $email
     * @return void
     */
    public function setEmail(mixed $email): void
    {
        $this->email = $email;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: Size(120) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field firstName
     * Column: first_name
     * Attributes: Size(60) | Type(2)
     * @return mixed
     */
    public function getFirstName(): mixed
    {
        return $this->firstName;
    }
    
    /**
     * Sets the value of field firstName
     * Column: first_name 
     * Attributes: Size(60) | Type(2)
     * @param mixed $firstName
     * @return void
     */
    public function setFirstName(mixed $firstName): void
    {
        $this->firstName = $firstName;
    }
    
    /**
     * Returns the value of field lastName
     * Column: last_name
     * Attributes: Size(60) | Type(2)
     * @return mixed
     */
    public function getLastName(): mixed
    {
        return $this->lastName;
    }
    
    /**
     * Sets the value of field lastName
     * Column: last_name 
     * Attributes: Size(60) | Type(2)
     * @param mixed $lastName
     * @return void
     */
    public function setLastName(mixed $lastName): void
    {
        $this->lastName = $lastName;
    }
    
    /**
     * Returns the value of field meta
     * Column: meta
     * Attributes: Type(15)
     * @return mixed
     */
    public function getMeta(): mixed
    {
        return $this->meta;
    }
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * Attributes: Type(15)
     * @param mixed $meta
     * @return void
     */
    public function setMeta(mixed $meta): void
    {
        $this->meta = $meta;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed
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
    public function setDeleted(mixed $deleted): void
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt(): mixed
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
    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy(): mixed
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
    public function setCreatedBy(mixed $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs(): mixed
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
    public function setCreatedAs(mixed $createdAs): void
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt(): mixed
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
    public function setUpdatedAt(mixed $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy(): mixed
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
    public function setUpdatedBy(mixed $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs(): mixed
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
    public function setUpdatedAs(mixed $updatedAs): void
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt(): mixed
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
    public function setDeletedAt(mixed $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs(): mixed
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
    public function setDeletedAs(mixed $deletedAs): void
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy(): mixed
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
    public function setDeletedBy(mixed $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt(): mixed
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
    public function setRestoredAt(mixed $restoredAt): void
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy(): mixed
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
    public function setRestoredBy(mixed $restoredBy): void
    {
        $this->restoredBy = $restoredBy;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->belongsTo('userId', User::class, 'id', ['alias' => 'UserEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);

        $this->belongsTo('createdAs', User::class, 'id', ['alias' => 'CreatedAsEntity']);

        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);

        $this->belongsTo('updatedAs', User::class, 'id', ['alias' => 'UpdatedAsEntity']);

        $this->belongsTo('deletedAs', User::class, 'id', ['alias' => 'DeletedAsEntity']);

        $this->belongsTo('deletedBy', User::class, 'id', ['alias' => 'DeletedByEntity']);

        $this->belongsTo('restoredBy', User::class, 'id', ['alias' => 'RestoredByEntity']);
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
        $this->addUnsignedIntValidation($validator, 'userId', false);
        $this->addInclusionInValidation($validator, 'provider', ['google','microsoft'], false);
        $this->addStringLengthValidation($validator, 'providerUuid', 0, 120, false);
        $this->addStringLengthValidation($validator, 'accessToken', 0, 120, false);
        $this->addStringLengthValidation($validator, 'refreshToken', 0, 120, true);
        $this->addStringLengthValidation($validator, 'email', 0, 320, true);
        $this->addStringLengthValidation($validator, 'name', 0, 120, true);
        $this->addStringLengthValidation($validator, 'firstName', 0, 60, true);
        $this->addStringLengthValidation($validator, 'lastName', 0, 60, true);
        $this->addJsonValidation($validator, 'meta', true);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        $this->addUnsignedIntValidation($validator, 'createdAs', true);
        $this->addDateTimeValidation($validator, 'updatedAt', true);
        $this->addUnsignedIntValidation($validator, 'updatedBy', true);
        $this->addUnsignedIntValidation($validator, 'updatedAs', true);
        $this->addDateTimeValidation($validator, 'deletedAt', true);
        $this->addUnsignedIntValidation($validator, 'deletedAs', true);
        $this->addUnsignedIntValidation($validator, 'deletedBy', true);
        $this->addDateTimeValidation($validator, 'restoredAt', true);
        $this->addUnsignedIntValidation($validator, 'restoredBy', true);
        
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
            'provider' => 'provider',
            'provider_uuid' => 'providerUuid',
            'access_token' => 'accessToken',
            'refresh_token' => 'refreshToken',
            'email' => 'email',
            'name' => 'name',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'meta' => 'meta',
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
        ];
    }
}