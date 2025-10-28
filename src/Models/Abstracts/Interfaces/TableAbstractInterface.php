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
 * @property ColumnAbstractInterface[] $columnlist
 * @property ColumnAbstractInterface[] $ColumnList
 * @method ColumnAbstractInterface[] getColumnList(?array $params = null)
 *
 * @property DataAbstractInterface[] $datalist
 * @property DataAbstractInterface[] $DataList
 * @method DataAbstractInterface[] getDataList(?array $params = null)
 *
 * @property RecordAbstractInterface[] $datarecordlist
 * @property RecordAbstractInterface[] $DataRecordList
 * @method RecordAbstractInterface[] getDataRecordList(?array $params = null)
 *
 * @property ColumnAbstractInterface[] $datacolumnlist
 * @property ColumnAbstractInterface[] $DataColumnList
 * @method ColumnAbstractInterface[] getDataColumnList(?array $params = null)
 *
 * @property RecordAbstractInterface[] $recordlist
 * @property RecordAbstractInterface[] $RecordList
 * @method RecordAbstractInterface[] getRecordList(?array $params = null)
 *
 * @property WorkspaceAbstractInterface $workspaceentity
 * @property WorkspaceAbstractInterface $WorkspaceEntity
 * @method WorkspaceAbstractInterface getWorkspaceEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdbyentity
 * @property UserAbstractInterface $CreatedByEntity
 * @method UserAbstractInterface getCreatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $updatedbyentity
 * @property UserAbstractInterface $UpdatedByEntity
 * @method UserAbstractInterface getUpdatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $deletedbyentity
 * @property UserAbstractInterface $DeletedByEntity
 * @method UserAbstractInterface getDeletedByEntity(?array $params = null)
 */
interface TableAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of the field "id"
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of the field "id"
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void;
    
    /**
     * Returns the value of the field "uuid"
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid(): mixed;
    
    /**
     * Sets the value of the field "uuid"
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid(mixed $uuid): void;
    
    /**
     * Returns the value of the field "workspaceId"
     * Column: workspace_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getWorkspaceId(): mixed;
    
    /**
     * Sets the value of the field "workspaceId"
     * Column: workspace_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $workspaceId
     * @return void
     */
    public function setWorkspaceId(mixed $workspaceId): void;
    
    /**
     * Returns the value of the field "label"
     * Column: label
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getLabel(): mixed;
    
    /**
     * Sets the value of the field "label"
     * Column: label
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel(mixed $label): void;
    
    /**
     * Returns the value of the field "description"
     * Column: description
     * Attributes: Size(240) | Type(2)
     * @return mixed
     */
    public function getDescription(): mixed;
    
    /**
     * Sets the value of the field "description"
     * Column: description
     * Attributes: Size(240) | Type(2)
     * @param mixed $description
     * @return void
     */
    public function setDescription(mixed $description): void;
    
    /**
     * Returns the value of the field "icon"
     * Column: icon
     * Attributes: Size(64) | Type(2)
     * @return mixed
     */
    public function getIcon(): mixed;
    
    /**
     * Sets the value of the field "icon"
     * Column: icon
     * Attributes: Size(64) | Type(2)
     * @param mixed $icon
     * @return void
     */
    public function setIcon(mixed $icon): void;
    
    /**
     * Returns the value of the field "color"
     * Column: color
     * Attributes: Size(9) | Type(5)
     * @return mixed
     */
    public function getColor(): mixed;
    
    /**
     * Sets the value of the field "color"
     * Column: color
     * Attributes: Size(9) | Type(5)
     * @param mixed $color
     * @return void
     */
    public function setColor(mixed $color): void;
    
    /**
     * Returns the value of the field "deleted"
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed;
    
    /**
     * Sets the value of the field "deleted"
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted(mixed $deleted): void;
    
    /**
     * Returns the value of the field "createdAt"
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt(): mixed;
    
    /**
     * Sets the value of the field "createdAt"
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt(mixed $createdAt): void;
    
    /**
     * Returns the value of the field "createdBy"
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getCreatedBy(): mixed;
    
    /**
     * Sets the value of the field "createdBy"
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void;
    
    /**
     * Returns the value of the field "updatedAt"
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt(): mixed;
    
    /**
     * Sets the value of the field "updatedAt"
     * Column: updated_at
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt(mixed $updatedAt): void;
    
    /**
     * Returns the value of the field "updatedBy"
     * Column: updated_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getUpdatedBy(): mixed;
    
    /**
     * Sets the value of the field "updatedBy"
     * Column: updated_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void;
    
    /**
     * Returns the value of the field "deletedAt"
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt(): mixed;
    
    /**
     * Sets the value of the field "deletedAt"
     * Column: deleted_at
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt(mixed $deletedAt): void;
    
    /**
     * Returns the value of the field "deletedBy"
     * Column: deleted_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getDeletedBy(): mixed;
    
    /**
     * Sets the value of the field "deletedBy"
     * Column: deleted_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void;
}
