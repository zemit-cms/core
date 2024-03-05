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

interface AuditDetailAbstractInterface extends ModelInterface
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
     * Returns the value of field auditId
     * Column: audit_id
     * @return RawValue|int|null
     */
    public function getAuditId(): RawValue|int|null;
    
    /**
     * Sets the value of field auditId
     * Column: audit_id 
     * @param RawValue|int|null $auditId
     * @return void
     */
    public function setAuditId(RawValue|int|null $auditId): void;
    
    /**
     * Returns the value of field model
     * Column: model
     * @return RawValue|string|null
     */
    public function getModel(): RawValue|string|null;
    
    /**
     * Sets the value of field model
     * Column: model 
     * @param RawValue|string|null $model
     * @return void
     */
    public function setModel(RawValue|string|null $model): void;
    
    /**
     * Returns the value of field table
     * Column: table
     * @return RawValue|string|null
     */
    public function getTable(): RawValue|string|null;
    
    /**
     * Sets the value of field table
     * Column: table 
     * @param RawValue|string|null $table
     * @return void
     */
    public function setTable(RawValue|string|null $table): void;
    
    /**
     * Returns the value of field primary
     * Column: primary
     * @return RawValue|int|null
     */
    public function getPrimary(): RawValue|int|null;
    
    /**
     * Sets the value of field primary
     * Column: primary 
     * @param RawValue|int|null $primary
     * @return void
     */
    public function setPrimary(RawValue|int|null $primary): void;
    
    /**
     * Returns the value of field event
     * Column: event
     * @return RawValue|string
     */
    public function getEvent(): RawValue|string;
    
    /**
     * Sets the value of field event
     * Column: event 
     * @param RawValue|string $event
     * @return void
     */
    public function setEvent(RawValue|string $event): void;
    
    /**
     * Returns the value of field column
     * Column: column
     * @return RawValue|string|null
     */
    public function getColumn(): RawValue|string|null;
    
    /**
     * Sets the value of field column
     * Column: column 
     * @param RawValue|string|null $column
     * @return void
     */
    public function setColumn(RawValue|string|null $column): void;
    
    /**
     * Returns the value of field map
     * Column: map
     * @return RawValue|string|null
     */
    public function getMap(): RawValue|string|null;
    
    /**
     * Sets the value of field map
     * Column: map 
     * @param RawValue|string|null $map
     * @return void
     */
    public function setMap(RawValue|string|null $map): void;
    
    /**
     * Returns the value of field before
     * Column: before
     * @return RawValue|string|null
     */
    public function getBefore(): RawValue|string|null;
    
    /**
     * Sets the value of field before
     * Column: before 
     * @param RawValue|string|null $before
     * @return void
     */
    public function setBefore(RawValue|string|null $before): void;
    
    /**
     * Returns the value of field after
     * Column: after
     * @return RawValue|string|null
     */
    public function getAfter(): RawValue|string|null;
    
    /**
     * Sets the value of field after
     * Column: after 
     * @param RawValue|string|null $after
     * @return void
     */
    public function setAfter(RawValue|string|null $after): void;
    
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
     * @return RawValue|string|null
     */
    public function getCreatedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string|null $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string|null $createdAt): void;
    
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