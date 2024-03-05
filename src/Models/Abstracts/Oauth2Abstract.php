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
 * @property User $UserEntity
 * @method User getUserEntity(?array $params = null)
 */
class Oauth2Abstract extends AbstractModel implements Oauth2AbstractInterface
{
    /**
     * Column: id
     * @var RawValue|int|null
     */
    public RawValue|int|null $id = null;
    
    /**
     * Column: user_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $userId = null;
    
    /**
     * Column: provider
     * @var RawValue|string|null
     */
    public RawValue|string|null $provider = null;
    
    /**
     * Column: provider_uuid
     * @var RawValue|string|null
     */
    public RawValue|string|null $providerUuid = null;
    
    /**
     * Column: access_token
     * @var RawValue|string|null
     */
    public RawValue|string|null $accessToken = null;
    
    /**
     * Column: refresh_token
     * @var RawValue|string|null
     */
    public RawValue|string|null $refreshToken = null;
    
    /**
     * Column: email
     * @var RawValue|string|null
     */
    public RawValue|string|null $email = null;
    
    /**
     * Column: name
     * @var RawValue|string|null
     */
    public RawValue|string|null $name = null;
    
    /**
     * Column: first_name
     * @var RawValue|string|null
     */
    public RawValue|string|null $firstName = null;
    
    /**
     * Column: last_name
     * @var RawValue|string|null
     */
    public RawValue|string|null $lastName = null;
    
    /**
     * Column: meta
     * @var RawValue|string|null
     */
    public RawValue|string|null $meta = null;
    
    /**
     * Column: deleted
     * @var RawValue|int
     */
    public RawValue|int $deleted = 0;
    
    /**
     * Column: created_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $createdAt = null;
    
    /**
     * Column: created_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $createdBy = null;
    
    /**
     * Column: created_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $createdAs = null;
    
    /**
     * Column: updated_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $updatedAt = null;
    
    /**
     * Column: updated_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $updatedBy = null;
    
    /**
     * Column: updated_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $updatedAs = null;
    
    /**
     * Column: deleted_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $deletedAt = null;
    
    /**
     * Column: deleted_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedAs = null;
    
    /**
     * Column: deleted_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedBy = null;
    
    /**
     * Column: restored_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $restoredAt = null;
    
    /**
     * Column: restored_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $restoredBy = null;
    /**
     * Returns the value of field id
     * Column: id
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field userId
     * Column: user_id
     * @return RawValue|int|null
     */
    public function getUserId(): RawValue|int|null
    {
        return $this->userId;
    }
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * @param RawValue|int|null $userId
     * @return void
     */
    public function setUserId(RawValue|int|null $userId): void
    {
        $this->userId = $userId;
    }
    
    /**
     * Returns the value of field provider
     * Column: provider
     * @return RawValue|string|null
     */
    public function getProvider(): RawValue|string|null
    {
        return $this->provider;
    }
    
    /**
     * Sets the value of field provider
     * Column: provider 
     * @param RawValue|string|null $provider
     * @return void
     */
    public function setProvider(RawValue|string|null $provider): void
    {
        $this->provider = $provider;
    }
    
    /**
     * Returns the value of field providerUuid
     * Column: provider_uuid
     * @return RawValue|string|null
     */
    public function getProviderUuid(): RawValue|string|null
    {
        return $this->providerUuid;
    }
    
    /**
     * Sets the value of field providerUuid
     * Column: provider_uuid 
     * @param RawValue|string|null $providerUuid
     * @return void
     */
    public function setProviderUuid(RawValue|string|null $providerUuid): void
    {
        $this->providerUuid = $providerUuid;
    }
    
    /**
     * Returns the value of field accessToken
     * Column: access_token
     * @return RawValue|string|null
     */
    public function getAccessToken(): RawValue|string|null
    {
        return $this->accessToken;
    }
    
    /**
     * Sets the value of field accessToken
     * Column: access_token 
     * @param RawValue|string|null $accessToken
     * @return void
     */
    public function setAccessToken(RawValue|string|null $accessToken): void
    {
        $this->accessToken = $accessToken;
    }
    
    /**
     * Returns the value of field refreshToken
     * Column: refresh_token
     * @return RawValue|string|null
     */
    public function getRefreshToken(): RawValue|string|null
    {
        return $this->refreshToken;
    }
    
    /**
     * Sets the value of field refreshToken
     * Column: refresh_token 
     * @param RawValue|string|null $refreshToken
     * @return void
     */
    public function setRefreshToken(RawValue|string|null $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }
    
    /**
     * Returns the value of field email
     * Column: email
     * @return RawValue|string|null
     */
    public function getEmail(): RawValue|string|null
    {
        return $this->email;
    }
    
    /**
     * Sets the value of field email
     * Column: email 
     * @param RawValue|string|null $email
     * @return void
     */
    public function setEmail(RawValue|string|null $email): void
    {
        $this->email = $email;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * @return RawValue|string|null
     */
    public function getName(): RawValue|string|null
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * @param RawValue|string|null $name
     * @return void
     */
    public function setName(RawValue|string|null $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field firstName
     * Column: first_name
     * @return RawValue|string|null
     */
    public function getFirstName(): RawValue|string|null
    {
        return $this->firstName;
    }
    
    /**
     * Sets the value of field firstName
     * Column: first_name 
     * @param RawValue|string|null $firstName
     * @return void
     */
    public function setFirstName(RawValue|string|null $firstName): void
    {
        $this->firstName = $firstName;
    }
    
    /**
     * Returns the value of field lastName
     * Column: last_name
     * @return RawValue|string|null
     */
    public function getLastName(): RawValue|string|null
    {
        return $this->lastName;
    }
    
    /**
     * Sets the value of field lastName
     * Column: last_name 
     * @param RawValue|string|null $lastName
     * @return void
     */
    public function setLastName(RawValue|string|null $lastName): void
    {
        $this->lastName = $lastName;
    }
    
    /**
     * Returns the value of field meta
     * Column: meta
     * @return RawValue|string|null
     */
    public function getMeta(): RawValue|string|null
    {
        return $this->meta;
    }
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * @param RawValue|string|null $meta
     * @return void
     */
    public function setMeta(RawValue|string|null $meta): void
    {
        $this->meta = $meta;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return RawValue|int
     */
    public function getDeleted(): RawValue|int
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param RawValue|int $deleted
     * @return void
     */
    public function setDeleted(RawValue|int $deleted): void
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return RawValue|string|null
     */
    public function getCreatedAt(): RawValue|string|null
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string|null $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string|null $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return RawValue|int|null
     */
    public function getCreatedBy(): RawValue|int|null
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param RawValue|int|null $createdBy
     * @return void
     */
    public function setCreatedBy(RawValue|int|null $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return RawValue|int|null
     */
    public function getCreatedAs(): RawValue|int|null
    {
        return $this->createdAs;
    }
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param RawValue|int|null $createdAs
     * @return void
     */
    public function setCreatedAs(RawValue|int|null $createdAs): void
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return RawValue|string|null
     */
    public function getUpdatedAt(): RawValue|string|null
    {
        return $this->updatedAt;
    }
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param RawValue|string|null $updatedAt
     * @return void
     */
    public function setUpdatedAt(RawValue|string|null $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return RawValue|int|null
     */
    public function getUpdatedBy(): RawValue|int|null
    {
        return $this->updatedBy;
    }
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param RawValue|int|null $updatedBy
     * @return void
     */
    public function setUpdatedBy(RawValue|int|null $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return RawValue|int|null
     */
    public function getUpdatedAs(): RawValue|int|null
    {
        return $this->updatedAs;
    }
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param RawValue|int|null $updatedAs
     * @return void
     */
    public function setUpdatedAs(RawValue|int|null $updatedAs): void
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return RawValue|string|null
     */
    public function getDeletedAt(): RawValue|string|null
    {
        return $this->deletedAt;
    }
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param RawValue|string|null $deletedAt
     * @return void
     */
    public function setDeletedAt(RawValue|string|null $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return RawValue|int|null
     */
    public function getDeletedAs(): RawValue|int|null
    {
        return $this->deletedAs;
    }
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param RawValue|int|null $deletedAs
     * @return void
     */
    public function setDeletedAs(RawValue|int|null $deletedAs): void
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return RawValue|int|null
     */
    public function getDeletedBy(): RawValue|int|null
    {
        return $this->deletedBy;
    }
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param RawValue|int|null $deletedBy
     * @return void
     */
    public function setDeletedBy(RawValue|int|null $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return RawValue|string|null
     */
    public function getRestoredAt(): RawValue|string|null
    {
        return $this->restoredAt;
    }
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param RawValue|string|null $restoredAt
     * @return void
     */
    public function setRestoredAt(RawValue|string|null $restoredAt): void
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return RawValue|int|null
     */
    public function getRestoredBy(): RawValue|int|null
    {
        return $this->restoredBy;
    }
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param RawValue|int|null $restoredBy
     * @return void
     */
    public function setRestoredBy(RawValue|int|null $restoredBy): void
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
    }
    
    /**
     * Adds the default validations to the model.
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