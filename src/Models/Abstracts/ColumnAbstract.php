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

namespace Zemit\Models\Abstracts;

use Phalcon\Db\RawValue;
use Zemit\Filter\Validation;
use Zemit\Models\AbstractModel;
use Zemit\Models\Data;
use Zemit\Models\Workspace;
use Zemit\Models\Table;
use Zemit\Models\Record;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\ColumnAbstractInterface;

/**
 * Class ColumnAbstract
 *
 * This class defines a Column abstract model that extends the AbstractModel class and implements the ColumnAbstractInterface.
 * It provides properties and methods for managing Column data.
 * 
 * @property Data[] $datalist
 * @property Data[] $DataList
 * @method Data[] getDataList(?array $params = null)
 *
 * @property Workspace[] $dataworkspacelist
 * @property Workspace[] $DataWorkspaceList
 * @method Workspace[] getDataWorkspaceList(?array $params = null)
 *
 * @property Table[] $datatablelist
 * @property Table[] $DataTableList
 * @method Table[] getDataTableList(?array $params = null)
 *
 * @property Record[] $datarecordlist
 * @property Record[] $DataRecordList
 * @method Record[] getDataRecordList(?array $params = null)
 *
 * @property Workspace $workspaceentity
 * @property Workspace $WorkspaceEntity
 * @method Workspace getWorkspaceEntity(?array $params = null)
 *
 * @property Table $tableentity
 * @property Table $TableEntity
 * @method Table getTableEntity(?array $params = null)
 *
 * @property User $createdbyentity
 * @property User $CreatedByEntity
 * @method User getCreatedByEntity(?array $params = null)
 *
 * @property User $createdasentity
 * @property User $CreatedAsEntity
 * @method User getCreatedAsEntity(?array $params = null)
 *
 * @property User $updatedbyentity
 * @property User $UpdatedByEntity
 * @method User getUpdatedByEntity(?array $params = null)
 *
 * @property User $updatedasentity
 * @property User $UpdatedAsEntity
 * @method User getUpdatedAsEntity(?array $params = null)
 *
 * @property User $deletedasentity
 * @property User $DeletedAsEntity
 * @method User getDeletedAsEntity(?array $params = null)
 *
 * @property User $deletedbyentity
 * @property User $DeletedByEntity
 * @method User getDeletedByEntity(?array $params = null)
 *
 * @property User $restoredbyentity
 * @property User $RestoredByEntity
 * @method User getRestoredByEntity(?array $params = null)
 */
abstract class ColumnAbstract extends AbstractModel implements ColumnAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public mixed $id = null;
        
    /**
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @var mixed
     */
    public mixed $uuid = null;
        
    /**
     * Column: workspace_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public mixed $workspaceId = null;
        
    /**
     * Column: table_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public mixed $tableId = null;
        
    /**
     * Column: name
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $name = null;
        
    /**
     * Column: description
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public mixed $description = null;
        
    /**
     * Column: type
     * Attributes: NotNull | Size('linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button') | Type(18)
     * @var mixed
     */
    public mixed $type = 'singleLineText';
        
    /**
     * Column: validation_regex
     * Attributes: Size(1000) | Type(2)
     * @var mixed
     */
    public mixed $validationRegex = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public mixed $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public mixed $createdAt = null;
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $createdBy = null;
        
    /**
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $createdAs = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $updatedBy = null;
        
    /**
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $updatedAs = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $deletedAt = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedAs = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedBy = null;
        
    /**
     * Column: restored_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $restoredAt = null;
        
    /**
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $restoredBy = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid(): mixed
    {
        return $this->uuid;
    }
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid(mixed $uuid): void
    {
        $this->uuid = $uuid;
    }
    
    /**
     * Returns the value of field workspaceId
     * Column: workspace_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getWorkspaceId(): mixed
    {
        return $this->workspaceId;
    }
    
    /**
     * Sets the value of field workspaceId
     * Column: workspace_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $workspaceId
     * @return void
     */
    public function setWorkspaceId(mixed $workspaceId): void
    {
        $this->workspaceId = $workspaceId;
    }
    
    /**
     * Returns the value of field tableId
     * Column: table_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getTableId(): mixed
    {
        return $this->tableId;
    }
    
    /**
     * Sets the value of field tableId
     * Column: table_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $tableId
     * @return void
     */
    public function setTableId(mixed $tableId): void
    {
        $this->tableId = $tableId;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field description
     * Column: description
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }
    
    /**
     * Sets the value of field description
     * Column: description 
     * Attributes: Size(120) | Type(2)
     * @param mixed $description
     * @return void
     */
    public function setDescription(mixed $description): void
    {
        $this->description = $description;
    }
    
    /**
     * Returns the value of field type
     * Column: type
     * Attributes: NotNull | Size('linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button') | Type(18)
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }
    
    /**
     * Sets the value of field type
     * Column: type 
     * Attributes: NotNull | Size('linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button') | Type(18)
     * @param mixed $type
     * @return void
     */
    public function setType(mixed $type): void
    {
        $this->type = $type;
    }
    
    /**
     * Returns the value of field validationRegex
     * Column: validation_regex
     * Attributes: Size(1000) | Type(2)
     * @return mixed
     */
    public function getValidationRegex(): mixed
    {
        return $this->validationRegex;
    }
    
    /**
     * Sets the value of field validationRegex
     * Column: validation_regex 
     * Attributes: Size(1000) | Type(2)
     * @param mixed $validationRegex
     * @return void
     */
    public function setValidationRegex(mixed $validationRegex): void
    {
        $this->validationRegex = $validationRegex;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted(mixed $deleted): void
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy(): mixed
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs(): mixed
    {
        return $this->createdAs;
    }
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs(mixed $createdAs): void
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt(mixed $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy(): mixed
    {
        return $this->updatedBy;
    }
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs(): mixed
    {
        return $this->updatedAs;
    }
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs(mixed $updatedAs): void
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt(): mixed
    {
        return $this->deletedAt;
    }
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt(mixed $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs(): mixed
    {
        return $this->deletedAs;
    }
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs(mixed $deletedAs): void
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy(): mixed
    {
        return $this->deletedBy;
    }
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt(): mixed
    {
        return $this->restoredAt;
    }
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt(mixed $restoredAt): void
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy(): mixed
    {
        return $this->restoredBy;
    }
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy(mixed $restoredBy): void
    {
        $this->restoredBy = $restoredBy;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->hasMany('id', Data::class, 'columnId', ['alias' => 'DataList']);

        $this->hasManyToMany(
            'id',
            Data::class,
            'columnId',
            'workspaceId',
            Workspace::class,
            'id',
            ['alias' => 'DataWorkspaceList']
        );

        $this->hasManyToMany(
            'id',
            Data::class,
            'columnId',
            'tableId',
            Table::class,
            'id',
            ['alias' => 'DataTableList']
        );

        $this->hasManyToMany(
            'id',
            Data::class,
            'columnId',
            'recordId',
            Record::class,
            'id',
            ['alias' => 'DataRecordList']
        );

        $this->belongsTo('workspaceId', Workspace::class, 'id', ['alias' => 'WorkspaceEntity']);

        $this->belongsTo('tableId', Table::class, 'id', ['alias' => 'TableEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);

        $this->belongsTo('createdAs', User::class, 'id', ['alias' => 'CreatedAsEntity']);

        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);

        $this->belongsTo('updatedAs', User::class, 'id', ['alias' => 'UpdatedAsEntity']);

        $this->belongsTo('deletedAs', User::class, 'id', ['alias' => 'DeletedAsEntity']);

        $this->belongsTo('deletedBy', User::class, 'id', ['alias' => 'DeletedByEntity']);

        $this->belongsTo('restoredBy', User::class, 'id', ['alias' => 'RestoredByEntity']);
    }
    
    /**
     * Adds the default validations to the model.
     * @param Validation|null $validator
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addStringLengthValidation($validator, 'uuid', 0, 36, false);
        $this->addUnsignedIntValidation($validator, 'workspaceId', false);
        $this->addUnsignedIntValidation($validator, 'tableId', false);
        $this->addStringLengthValidation($validator, 'name', 0, 60, false);
        $this->addStringLengthValidation($validator, 'description', 0, 120, true);
        $this->addInclusionInValidation($validator, 'type', ['linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button'], false);
        $this->addStringLengthValidation($validator, 'validationRegex', 0, 1000, true);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        $this->addUnsignedIntValidation($validator, 'createdAs', true);
        $this->addDateTimeValidation($validator, 'updatedAt', true);
        $this->addUnsignedIntValidation($validator, 'updatedBy', true);
        $this->addUnsignedIntValidation($validator, 'updatedAs', true);
        $this->addDateTimeValidation($validator, 'deletedAt', true);
        $this->addUnsignedIntValidation($validator, 'deletedAs', true);
        $this->addUnsignedIntValidation($validator, 'deletedBy', true);
        $this->addDateTimeValidation($validator, 'restoredAt', true);
        $this->addUnsignedIntValidation($validator, 'restoredBy', true);
        
        return $validator;
    }

        
    /**
     * Returns an array that maps the column names of the database
     * table to the corresponding property names of the model.
     * 
     * @returns array The array mapping the column names to the property names
     */
    public function columnMap(): array
    {
        return [
            'id' => 'id',
            'uuid' => 'uuid',
            'workspace_id' => 'workspaceId',
            'table_id' => 'tableId',
            'name' => 'name',
            'description' => 'description',
            'type' => 'type',
            'validation_regex' => 'validationRegex',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'created_as' => 'createdAs',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'updated_as' => 'updatedAs',
            'deleted_at' => 'deletedAt',
            'deleted_as' => 'deletedAs',
            'deleted_by' => 'deletedBy',
            'restored_at' => 'restoredAt',
            'restored_by' => 'restoredBy',
        ];
    }
}
