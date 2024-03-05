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

namespace Zemit\Models\Abstracts\Interfaces;

use Phalcon\Db\RawValue;
use Zemit\Mvc\ModelInterface;

interface Oauth2AbstractInterface extends ModelInterface
{
/**
     * Returns the value of field id
     * Column: id
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void;
    
    /**
     * Returns the value of field userId
     * Column: user_id
     * @return RawValue|int
     */
    public function getUserId(): RawValue|int;
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * @param RawValue|int $userId
     * @return void
     */
    public function setUserId(RawValue|int $userId): void;
    
    /**
     * Returns the value of field provider
     * Column: provider
     * @return RawValue|string
     */
    public function getProvider(): RawValue|string;
    
    /**
     * Sets the value of field provider
     * Column: provider 
     * @param RawValue|string $provider
     * @return void
     */
    public function setProvider(RawValue|string $provider): void;
    
    /**
     * Returns the value of field providerUuid
     * Column: provider_uuid
     * @return RawValue|string
     */
    public function getProviderUuid(): RawValue|string;
    
    /**
     * Sets the value of field providerUuid
     * Column: provider_uuid 
     * @param RawValue|string $providerUuid
     * @return void
     */
    public function setProviderUuid(RawValue|string $providerUuid): void;
    
    /**
     * Returns the value of field accessToken
     * Column: access_token
     * @return RawValue|string
     */
    public function getAccessToken(): RawValue|string;
    
    /**
     * Sets the value of field accessToken
     * Column: access_token 
     * @param RawValue|string $accessToken
     * @return void
     */
    public function setAccessToken(RawValue|string $accessToken): void;
    
    /**
     * Returns the value of field refreshToken
     * Column: refresh_token
     * @return RawValue|string|null
     */
    public function getRefreshToken(): RawValue|string|null;
    
    /**
     * Sets the value of field refreshToken
     * Column: refresh_token 
     * @param RawValue|string|null $refreshToken
     * @return void
     */
    public function setRefreshToken(RawValue|string|null $refreshToken): void;
    
    /**
     * Returns the value of field email
     * Column: email
     * @return RawValue|string|null
     */
    public function getEmail(): RawValue|string|null;
    
    /**
     * Sets the value of field email
     * Column: email 
     * @param RawValue|string|null $email
     * @return void
     */
    public function setEmail(RawValue|string|null $email): void;
    
    /**
     * Returns the value of field name
     * Column: name
     * @return RawValue|string|null
     */
    public function getName(): RawValue|string|null;
    
    /**
     * Sets the value of field name
     * Column: name 
     * @param RawValue|string|null $name
     * @return void
     */
    public function setName(RawValue|string|null $name): void;
    
    /**
     * Returns the value of field firstName
     * Column: first_name
     * @return RawValue|string|null
     */
    public function getFirstName(): RawValue|string|null;
    
    /**
     * Sets the value of field firstName
     * Column: first_name 
     * @param RawValue|string|null $firstName
     * @return void
     */
    public function setFirstName(RawValue|string|null $firstName): void;
    
    /**
     * Returns the value of field lastName
     * Column: last_name
     * @return RawValue|string|null
     */
    public function getLastName(): RawValue|string|null;
    
    /**
     * Sets the value of field lastName
     * Column: last_name 
     * @param RawValue|string|null $lastName
     * @return void
     */
    public function setLastName(RawValue|string|null $lastName): void;
    
    /**
     * Returns the value of field meta
     * Column: meta
     * @return RawValue|string|null
     */
    public function getMeta(): RawValue|string|null;
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * @param RawValue|string|null $meta
     * @return void
     */
    public function setMeta(RawValue|string|null $meta): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return RawValue|int
     */
    public function getDeleted(): RawValue|int;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param RawValue|int $deleted
     * @return void
     */
    public function setDeleted(RawValue|int $deleted): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return RawValue|string
     */
    public function getCreatedAt(): RawValue|string;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return RawValue|int|null
     */
    public function getCreatedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param RawValue|int|null $createdBy
     * @return void
     */
    public function setCreatedBy(RawValue|int|null $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return RawValue|int|null
     */
    public function getCreatedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param RawValue|int|null $createdAs
     * @return void
     */
    public function setCreatedAs(RawValue|int|null $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return RawValue|string|null
     */
    public function getUpdatedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param RawValue|string|null $updatedAt
     * @return void
     */
    public function setUpdatedAt(RawValue|string|null $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return RawValue|int|null
     */
    public function getUpdatedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param RawValue|int|null $updatedBy
     * @return void
     */
    public function setUpdatedBy(RawValue|int|null $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return RawValue|int|null
     */
    public function getUpdatedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param RawValue|int|null $updatedAs
     * @return void
     */
    public function setUpdatedAs(RawValue|int|null $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return RawValue|string|null
     */
    public function getDeletedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param RawValue|string|null $deletedAt
     * @return void
     */
    public function setDeletedAt(RawValue|string|null $deletedAt): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return RawValue|int|null
     */
    public function getDeletedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param RawValue|int|null $deletedAs
     * @return void
     */
    public function setDeletedAs(RawValue|int|null $deletedAs): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return RawValue|int|null
     */
    public function getDeletedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param RawValue|int|null $deletedBy
     * @return void
     */
    public function setDeletedBy(RawValue|int|null $deletedBy): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return RawValue|string|null
     */
    public function getRestoredAt(): RawValue|string|null;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param RawValue|string|null $restoredAt
     * @return void
     */
    public function setRestoredAt(RawValue|string|null $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return RawValue|int|null
     */
    public function getRestoredBy(): RawValue|int|null;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param RawValue|int|null $restoredBy
     * @return void
     */
    public function setRestoredBy(RawValue|int|null $restoredBy): void;
}