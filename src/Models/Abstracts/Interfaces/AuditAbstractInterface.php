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

/**
 * @property AuditDetailAbstractInterface[] $auditdetaillist
 * @property AuditDetailAbstractInterface[] $AuditDetailList
 * @method AuditDetailAbstractInterface[] getAuditDetailList(?array $params = null)
 *
 * @property AuditAbstractInterface $parententity
 * @property AuditAbstractInterface $ParentEntity
 * @method AuditAbstractInterface getParentEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdbyentity
 * @property UserAbstractInterface $CreatedByEntity
 * @method UserAbstractInterface getCreatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdasentity
 * @property UserAbstractInterface $CreatedAsEntity
 * @method UserAbstractInterface getCreatedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $updatedbyentity
 * @property UserAbstractInterface $UpdatedByEntity
 * @method UserAbstractInterface getUpdatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $updatedasentity
 * @property UserAbstractInterface $UpdatedAsEntity
 * @method UserAbstractInterface getUpdatedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $deletedasentity
 * @property UserAbstractInterface $DeletedAsEntity
 * @method UserAbstractInterface getDeletedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $deletedbyentity
 * @property UserAbstractInterface $DeletedByEntity
 * @method UserAbstractInterface getDeletedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $restoredbyentity
 * @property UserAbstractInterface $RestoredByEntity
 * @method UserAbstractInterface getRestoredByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $restoredasentity
 * @property UserAbstractInterface $RestoredAsEntity
 * @method UserAbstractInterface getRestoredAsEntity(?array $params = null)
 */
interface AuditAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Type(14)
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Type(14)
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void;
    
    /**
     * Returns the value of field parentId
     * Column: parent_id
     * Attributes: Numeric | Unsigned | Type(14)
     * @return mixed
     */
    public function getParentId(): mixed;
    
    /**
     * Sets the value of field parentId
     * Column: parent_id 
     * Attributes: Numeric | Unsigned | Type(14)
     * @param mixed $parentId
     * @return void
     */
    public function setParentId(mixed $parentId): void;
    
    /**
     * Returns the value of field model
     * Column: model
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getModel(): mixed;
    
    /**
     * Sets the value of field model
     * Column: model 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $model
     * @return void
     */
    public function setModel(mixed $model): void;
    
    /**
     * Returns the value of field table
     * Column: table
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getTable(): mixed;
    
    /**
     * Sets the value of field table
     * Column: table 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $table
     * @return void
     */
    public function setTable(mixed $table): void;
    
    /**
     * Returns the value of field primary
     * Column: primary
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getPrimary(): mixed;
    
    /**
     * Sets the value of field primary
     * Column: primary 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $primary
     * @return void
     */
    public function setPrimary(mixed $primary): void;
    
    /**
     * Returns the value of field event
     * Column: event
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @return mixed
     */
    public function getEvent(): mixed;
    
    /**
     * Sets the value of field event
     * Column: event 
     * Attributes: NotNull | Size('create','update','delete','restore','other') | Type(18)
     * @param mixed $event
     * @return void
     */
    public function setEvent(mixed $event): void;
    
    /**
     * Returns the value of field columns
     * Column: columns
     * Attributes: Type(6)
     * @return mixed
     */
    public function getColumns(): mixed;
    
    /**
     * Sets the value of field columns
     * Column: columns 
     * Attributes: Type(6)
     * @param mixed $columns
     * @return void
     */
    public function setColumns(mixed $columns): void;
    
    /**
     * Returns the value of field before
     * Column: before
     * Attributes: Type(23)
     * @return mixed
     */
    public function getBefore(): mixed;
    
    /**
     * Sets the value of field before
     * Column: before 
     * Attributes: Type(23)
     * @param mixed $before
     * @return void
     */
    public function setBefore(mixed $before): void;
    
    /**
     * Returns the value of field after
     * Column: after
     * Attributes: Type(23)
     * @return mixed
     */
    public function getAfter(): mixed;
    
    /**
     * Sets the value of field after
     * Column: after 
     * Attributes: Type(23)
     * @param mixed $after
     * @return void
     */
    public function setAfter(mixed $after): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted(mixed $deleted): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt(): mixed;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt(mixed $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy(): mixed;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs(): mixed;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs(mixed $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt(): mixed;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt(mixed $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy(): mixed;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs(): mixed;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs(mixed $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt(): mixed;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt(mixed $deletedAt): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs(): mixed;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs(mixed $deletedAs): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy(): mixed;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt(): mixed;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt(mixed $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy(): mixed;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy(mixed $restoredBy): void;
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs(): mixed;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs(mixed $restoredAs): void;
}
