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

interface AuditDetailInterface extends ModelInterface
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
     * Returns the value of field auditId
     * Column: audit_id
     * @return int
     */
    public function getAuditId(): int;
    
    /**
     * Sets the value of field auditId
     * Column: audit_id 
     * @param int $auditId
     * @return void
     */
    public function setAuditId(int $auditId): void;
    
    /**
     * Returns the value of field model
     * Column: model
     * @return string
     */
    public function getModel(): string;
    
    /**
     * Sets the value of field model
     * Column: model 
     * @param string $model
     * @return void
     */
    public function setModel(string $model): void;
    
    /**
     * Returns the value of field table
     * Column: table
     * @return string
     */
    public function getTable(): string;
    
    /**
     * Sets the value of field table
     * Column: table 
     * @param string $table
     * @return void
     */
    public function setTable(string $table): void;
    
    /**
     * Returns the value of field primary
     * Column: primary
     * @return int
     */
    public function getPrimary(): int;
    
    /**
     * Sets the value of field primary
     * Column: primary 
     * @param int $primary
     * @return void
     */
    public function setPrimary(int $primary): void;
    
    /**
     * Returns the value of field event
     * Column: event
     * @return string
     */
    public function getEvent(): string;
    
    /**
     * Sets the value of field event
     * Column: event 
     * @param string $event
     * @return void
     */
    public function setEvent(string $event): void;
    
    /**
     * Returns the value of field column
     * Column: column
     * @return string
     */
    public function getColumn(): string;
    
    /**
     * Sets the value of field column
     * Column: column 
     * @param string $column
     * @return void
     */
    public function setColumn(string $column): void;
    
    /**
     * Returns the value of field map
     * Column: map
     * @return string
     */
    public function getMap(): string;
    
    /**
     * Sets the value of field map
     * Column: map 
     * @param string $map
     * @return void
     */
    public function setMap(string $map): void;
    
    /**
     * Returns the value of field before
     * Column: before
     * @return ?string
     */
    public function getBefore(): ?string;
    
    /**
     * Sets the value of field before
     * Column: before 
     * @param ?string $before
     * @return void
     */
    public function setBefore(?string $before): void;
    
    /**
     * Returns the value of field after
     * Column: after
     * @return ?string
     */
    public function getAfter(): ?string;
    
    /**
     * Sets the value of field after
     * Column: after 
     * @param ?string $after
     * @return void
     */
    public function setAfter(?string $after): void;
    
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