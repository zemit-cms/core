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

use Zemit\Mvc\ModelInterface;

interface Oauth2Interface extends ModelInterface
{
/**
     * Returns the value of field id
     * Column: id
     * @return ?int
     */
    public function getId(): ?int;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param ?int $id
     * @return void
     */
    public function setId(?int $id): void;
    
    /**
     * Returns the value of field userId
     * Column: user_id
     * @return int
     */
    public function getUserId(): int;
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId): void;
    
    /**
     * Returns the value of field provider
     * Column: provider
     * @return string
     */
    public function getProvider(): string;
    
    /**
     * Sets the value of field provider
     * Column: provider 
     * @param string $provider
     * @return void
     */
    public function setProvider(string $provider): void;
    
    /**
     * Returns the value of field providerUuid
     * Column: provider_uuid
     * @return string
     */
    public function getProviderUuid(): string;
    
    /**
     * Sets the value of field providerUuid
     * Column: provider_uuid 
     * @param string $providerUuid
     * @return void
     */
    public function setProviderUuid(string $providerUuid): void;
    
    /**
     * Returns the value of field accessToken
     * Column: access_token
     * @return string
     */
    public function getAccessToken(): string;
    
    /**
     * Sets the value of field accessToken
     * Column: access_token 
     * @param string $accessToken
     * @return void
     */
    public function setAccessToken(string $accessToken): void;
    
    /**
     * Returns the value of field refreshToken
     * Column: refresh_token
     * @return ?string
     */
    public function getRefreshToken(): ?string;
    
    /**
     * Sets the value of field refreshToken
     * Column: refresh_token 
     * @param ?string $refreshToken
     * @return void
     */
    public function setRefreshToken(?string $refreshToken): void;
    
    /**
     * Returns the value of field email
     * Column: email
     * @return ?string
     */
    public function getEmail(): ?string;
    
    /**
     * Sets the value of field email
     * Column: email 
     * @param ?string $email
     * @return void
     */
    public function setEmail(?string $email): void;
    
    /**
     * Returns the value of field name
     * Column: name
     * @return ?string
     */
    public function getName(): ?string;
    
    /**
     * Sets the value of field name
     * Column: name 
     * @param ?string $name
     * @return void
     */
    public function setName(?string $name): void;
    
    /**
     * Returns the value of field firstName
     * Column: first_name
     * @return ?string
     */
    public function getFirstName(): ?string;
    
    /**
     * Sets the value of field firstName
     * Column: first_name 
     * @param ?string $firstName
     * @return void
     */
    public function setFirstName(?string $firstName): void;
    
    /**
     * Returns the value of field lastName
     * Column: last_name
     * @return ?string
     */
    public function getLastName(): ?string;
    
    /**
     * Sets the value of field lastName
     * Column: last_name 
     * @param ?string $lastName
     * @return void
     */
    public function setLastName(?string $lastName): void;
    
    /**
     * Returns the value of field meta
     * Column: meta
     * @return ?string
     */
    public function getMeta(): ?string;
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * @param ?string $meta
     * @return void
     */
    public function setMeta(?string $meta): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return int
     */
    public function getDeleted(): int;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param int $deleted
     * @return void
     */
    public function setDeleted(int $deleted): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return string
     */
    public function getCreatedAt(): string;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return ?int
     */
    public function getCreatedBy(): ?int;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param ?int $createdBy
     * @return void
     */
    public function setCreatedBy(?int $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return ?int
     */
    public function getCreatedAs(): ?int;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param ?int $createdAs
     * @return void
     */
    public function setCreatedAs(?int $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return ?string
     */
    public function getUpdatedAt(): ?string;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param ?string $updatedAt
     * @return void
     */
    public function setUpdatedAt(?string $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return ?int
     */
    public function getUpdatedBy(): ?int;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param ?int $updatedBy
     * @return void
     */
    public function setUpdatedBy(?int $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return ?int
     */
    public function getUpdatedAs(): ?int;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param ?int $updatedAs
     * @return void
     */
    public function setUpdatedAs(?int $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return ?string
     */
    public function getDeletedAt(): ?string;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param ?string $deletedAt
     * @return void
     */
    public function setDeletedAt(?string $deletedAt): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return ?int
     */
    public function getDeletedAs(): ?int;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param ?int $deletedAs
     * @return void
     */
    public function setDeletedAs(?int $deletedAs): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return ?int
     */
    public function getDeletedBy(): ?int;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param ?int $deletedBy
     * @return void
     */
    public function setDeletedBy(?int $deletedBy): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return ?string
     */
    public function getRestoredAt(): ?string;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param ?string $restoredAt
     * @return void
     */
    public function setRestoredAt(?string $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return ?int
     */
    public function getRestoredBy(): ?int;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param ?int $restoredBy
     * @return void
     */
    public function setRestoredBy(?int $restoredBy): void;
}