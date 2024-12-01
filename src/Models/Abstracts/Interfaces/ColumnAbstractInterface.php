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
 * @property DataAbstractInterface[] $datalist
 * @property DataAbstractInterface[] $DataList
 * @method DataAbstractInterface[] getDataList(?array $params = null)
 *
 * @property WorkspaceAbstractInterface[] $dataworkspacelist
 * @property WorkspaceAbstractInterface[] $DataWorkspaceList
 * @method WorkspaceAbstractInterface[] getDataWorkspaceList(?array $params = null)
 *
 * @property TableAbstractInterface[] $datatablelist
 * @property TableAbstractInterface[] $DataTableList
 * @method TableAbstractInterface[] getDataTableList(?array $params = null)
 *
 * @property RecordAbstractInterface[] $datarecordlist
 * @property RecordAbstractInterface[] $DataRecordList
 * @method RecordAbstractInterface[] getDataRecordList(?array $params = null)
 *
 * @property WorkspaceAbstractInterface $workspaceentity
 * @property WorkspaceAbstractInterface $WorkspaceEntity
 * @method WorkspaceAbstractInterface getWorkspaceEntity(?array $params = null)
 *
 * @property TableAbstractInterface $tableentity
 * @property TableAbstractInterface $TableEntity
 * @method TableAbstractInterface getTableEntity(?array $params = null)
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
 */
interface ColumnAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void;
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid(): mixed;
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid(mixed $uuid): void;
    
    /**
     * Returns the value of field workspaceId
     * Column: workspace_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getWorkspaceId(): mixed;
    
    /**
     * Sets the value of field workspaceId
     * Column: workspace_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $workspaceId
     * @return void
     */
    public function setWorkspaceId(mixed $workspaceId): void;
    
    /**
     * Returns the value of field tableId
     * Column: table_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getTableId(): mixed;
    
    /**
     * Sets the value of field tableId
     * Column: table_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $tableId
     * @return void
     */
    public function setTableId(mixed $tableId): void;
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getName(): mixed;
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName(mixed $name): void;
    
    /**
     * Returns the value of field description
     * Column: description
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getDescription(): mixed;
    
    /**
     * Sets the value of field description
     * Column: description 
     * Attributes: Size(120) | Type(2)
     * @param mixed $description
     * @return void
     */
    public function setDescription(mixed $description): void;
    
    /**
     * Returns the value of field type
     * Column: type
     * Attributes: NotNull | Size('linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button') | Type(18)
     * @return mixed
     */
    public function getType(): mixed;
    
    /**
     * Sets the value of field type
     * Column: type 
     * Attributes: NotNull | Size('linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button') | Type(18)
     * @param mixed $type
     * @return void
     */
    public function setType(mixed $type): void;
    
    /**
     * Returns the value of field validationRegex
     * Column: validation_regex
     * Attributes: Size(1000) | Type(2)
     * @return mixed
     */
    public function getValidationRegex(): mixed;
    
    /**
     * Sets the value of field validationRegex
     * Column: validation_regex 
     * Attributes: Size(1000) | Type(2)
     * @param mixed $validationRegex
     * @return void
     */
    public function setValidationRegex(mixed $validationRegex): void;
    
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
}
