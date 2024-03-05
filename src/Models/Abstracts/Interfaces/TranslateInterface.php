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

interface TranslateInterface extends ModelInterface
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
     * Returns the value of field langId
     * Column: lang_id
     * @return int
     */
    public function getLangId(): int;
    
    /**
     * Sets the value of field langId
     * Column: lang_id 
     * @param int $langId
     * @return void
     */
    public function setLangId(int $langId): void;
    
    /**
     * Returns the value of field siteId
     * Column: site_id
     * @return ?int
     */
    public function getSiteId(): ?int;
    
    /**
     * Sets the value of field siteId
     * Column: site_id 
     * @param ?int $siteId
     * @return void
     */
    public function setSiteId(?int $siteId): void;
    
    /**
     * Returns the value of field pageId
     * Column: page_id
     * @return ?int
     */
    public function getPageId(): ?int;
    
    /**
     * Sets the value of field pageId
     * Column: page_id 
     * @param ?int $pageId
     * @return void
     */
    public function setPageId(?int $pageId): void;
    
    /**
     * Returns the value of field postId
     * Column: post_id
     * @return ?int
     */
    public function getPostId(): ?int;
    
    /**
     * Sets the value of field postId
     * Column: post_id 
     * @param ?int $postId
     * @return void
     */
    public function setPostId(?int $postId): void;
    
    /**
     * Returns the value of field categoryId
     * Column: category_id
     * @return ?int
     */
    public function getCategoryId(): ?int;
    
    /**
     * Sets the value of field categoryId
     * Column: category_id 
     * @param ?int $categoryId
     * @return void
     */
    public function setCategoryId(?int $categoryId): void;
    
    /**
     * Returns the value of field key
     * Column: key
     * @return string
     */
    public function getKey(): string;
    
    /**
     * Sets the value of field key
     * Column: key 
     * @param string $key
     * @return void
     */
    public function setKey(string $key): void;
    
    /**
     * Returns the value of field value
     * Column: value
     * @return ?string
     */
    public function getValue(): ?string;
    
    /**
     * Sets the value of field value
     * Column: value 
     * @param ?string $value
     * @return void
     */
    public function setValue(?string $value): void;
    
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