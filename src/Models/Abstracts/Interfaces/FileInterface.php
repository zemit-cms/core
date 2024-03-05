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

interface FileInterface extends ModelInterface
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
     * @return ?int
     */
    public function getUserId(): ?int;
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * @param ?int $userId
     * @return void
     */
    public function setUserId(?int $userId): void;
    
    /**
     * Returns the value of field category
     * Column: category
     * @return string
     */
    public function getCategory(): string;
    
    /**
     * Sets the value of field category
     * Column: category 
     * @param string $category
     * @return void
     */
    public function setCategory(string $category): void;
    
    /**
     * Returns the value of field key
     * Column: key
     * @return ?string
     */
    public function getKey(): ?string;
    
    /**
     * Sets the value of field key
     * Column: key 
     * @param ?string $key
     * @return void
     */
    public function setKey(?string $key): void;
    
    /**
     * Returns the value of field path
     * Column: path
     * @return ?string
     */
    public function getPath(): ?string;
    
    /**
     * Sets the value of field path
     * Column: path 
     * @param ?string $path
     * @return void
     */
    public function setPath(?string $path): void;
    
    /**
     * Returns the value of field type
     * Column: type
     * @return ?string
     */
    public function getType(): ?string;
    
    /**
     * Sets the value of field type
     * Column: type 
     * @param ?string $type
     * @return void
     */
    public function setType(?string $type): void;
    
    /**
     * Returns the value of field typeReal
     * Column: type_real
     * @return ?string
     */
    public function getTypeReal(): ?string;
    
    /**
     * Sets the value of field typeReal
     * Column: type_real 
     * @param ?string $typeReal
     * @return void
     */
    public function setTypeReal(?string $typeReal): void;
    
    /**
     * Returns the value of field extension
     * Column: extension
     * @return ?string
     */
    public function getExtension(): ?string;
    
    /**
     * Sets the value of field extension
     * Column: extension 
     * @param ?string $extension
     * @return void
     */
    public function setExtension(?string $extension): void;
    
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
     * Returns the value of field nameTemp
     * Column: name_temp
     * @return ?string
     */
    public function getNameTemp(): ?string;
    
    /**
     * Sets the value of field nameTemp
     * Column: name_temp 
     * @param ?string $nameTemp
     * @return void
     */
    public function setNameTemp(?string $nameTemp): void;
    
    /**
     * Returns the value of field size
     * Column: size
     * @return ?string
     */
    public function getSize(): ?string;
    
    /**
     * Sets the value of field size
     * Column: size 
     * @param ?string $size
     * @return void
     */
    public function setSize(?string $size): void;
    
    /**
     * Returns the value of field error
     * Column: error
     * @return ?string
     */
    public function getError(): ?string;
    
    /**
     * Sets the value of field error
     * Column: error 
     * @param ?string $error
     * @return void
     */
    public function setError(?string $error): void;
    
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
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return ?int
     */
    public function getRestoredAs(): ?int;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param ?int $restoredAs
     * @return void
     */
    public function setRestoredAs(?int $restoredAs): void;
}