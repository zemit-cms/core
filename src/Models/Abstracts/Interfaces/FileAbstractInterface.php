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

interface FileAbstractInterface extends ModelInterface
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
     * @return RawValue|int|null
     */
    public function getUserId(): RawValue|int|null;
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * @param RawValue|int|null $userId
     * @return void
     */
    public function setUserId(RawValue|int|null $userId): void;
    
    /**
     * Returns the value of field category
     * Column: category
     * @return RawValue|string
     */
    public function getCategory(): RawValue|string;
    
    /**
     * Sets the value of field category
     * Column: category 
     * @param RawValue|string $category
     * @return void
     */
    public function setCategory(RawValue|string $category): void;
    
    /**
     * Returns the value of field key
     * Column: key
     * @return RawValue|string|null
     */
    public function getKey(): RawValue|string|null;
    
    /**
     * Sets the value of field key
     * Column: key 
     * @param RawValue|string|null $key
     * @return void
     */
    public function setKey(RawValue|string|null $key): void;
    
    /**
     * Returns the value of field path
     * Column: path
     * @return RawValue|string|null
     */
    public function getPath(): RawValue|string|null;
    
    /**
     * Sets the value of field path
     * Column: path 
     * @param RawValue|string|null $path
     * @return void
     */
    public function setPath(RawValue|string|null $path): void;
    
    /**
     * Returns the value of field type
     * Column: type
     * @return RawValue|string|null
     */
    public function getType(): RawValue|string|null;
    
    /**
     * Sets the value of field type
     * Column: type 
     * @param RawValue|string|null $type
     * @return void
     */
    public function setType(RawValue|string|null $type): void;
    
    /**
     * Returns the value of field typeReal
     * Column: type_real
     * @return RawValue|string|null
     */
    public function getTypeReal(): RawValue|string|null;
    
    /**
     * Sets the value of field typeReal
     * Column: type_real 
     * @param RawValue|string|null $typeReal
     * @return void
     */
    public function setTypeReal(RawValue|string|null $typeReal): void;
    
    /**
     * Returns the value of field extension
     * Column: extension
     * @return RawValue|string|null
     */
    public function getExtension(): RawValue|string|null;
    
    /**
     * Sets the value of field extension
     * Column: extension 
     * @param RawValue|string|null $extension
     * @return void
     */
    public function setExtension(RawValue|string|null $extension): void;
    
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
     * Returns the value of field nameTemp
     * Column: name_temp
     * @return RawValue|string|null
     */
    public function getNameTemp(): RawValue|string|null;
    
    /**
     * Sets the value of field nameTemp
     * Column: name_temp 
     * @param RawValue|string|null $nameTemp
     * @return void
     */
    public function setNameTemp(RawValue|string|null $nameTemp): void;
    
    /**
     * Returns the value of field size
     * Column: size
     * @return RawValue|string|null
     */
    public function getSize(): RawValue|string|null;
    
    /**
     * Sets the value of field size
     * Column: size 
     * @param RawValue|string|null $size
     * @return void
     */
    public function setSize(RawValue|string|null $size): void;
    
    /**
     * Returns the value of field error
     * Column: error
     * @return RawValue|string|null
     */
    public function getError(): RawValue|string|null;
    
    /**
     * Sets the value of field error
     * Column: error 
     * @param RawValue|string|null $error
     * @return void
     */
    public function setError(RawValue|string|null $error): void;
    
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
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return RawValue|int|null
     */
    public function getRestoredAs(): RawValue|int|null;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param RawValue|int|null $restoredAs
     * @return void
     */
    public function setRestoredAs(RawValue|int|null $restoredAs): void;
}