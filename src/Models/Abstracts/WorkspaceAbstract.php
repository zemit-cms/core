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
use Zemit\Models\Column;
use Zemit\Models\Table;
use Zemit\Models\Data;
use Zemit\Models\Record;
use Zemit\Models\Lang;
use Zemit\Models\WorkspaceLang;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\WorkspaceAbstractInterface;

/**
 * Class WorkspaceAbstract
 *
 * This class defines a Workspace abstract model that extends the AbstractModel class and implements the WorkspaceAbstractInterface.
 * It provides properties and methods for managing Workspace data.
 * 
 * @property Column[] $columnlist
 * @property Column[] $ColumnList
 * @method Column[] getColumnList(?array $params = null)
 *
 * @property Table[] $columntablelist
 * @property Table[] $ColumnTableList
 * @method Table[] getColumnTableList(?array $params = null)
 *
 * @property Data[] $datalist
 * @property Data[] $DataList
 * @method Data[] getDataList(?array $params = null)
 *
 * @property Table[] $datatablelist
 * @property Table[] $DataTableList
 * @method Table[] getDataTableList(?array $params = null)
 *
 * @property Column[] $datacolumnlist
 * @property Column[] $DataColumnList
 * @method Column[] getDataColumnList(?array $params = null)
 *
 * @property Record[] $datarecordlist
 * @property Record[] $DataRecordList
 * @method Record[] getDataRecordList(?array $params = null)
 *
 * @property Record[] $recordlist
 * @property Record[] $RecordList
 * @method Record[] getRecordList(?array $params = null)
 *
 * @property Table[] $recordtablelist
 * @property Table[] $RecordTableList
 * @method Table[] getRecordTableList(?array $params = null)
 *
 * @property Table[] $tablelist
 * @property Table[] $TableList
 * @method Table[] getTableList(?array $params = null)
 *
 * @property Lang[] $tablelanglist
 * @property Lang[] $TableLangList
 * @method Lang[] getTableLangList(?array $params = null)
 *
 * @property WorkspaceLang[] $workspacelanglist
 * @property WorkspaceLang[] $WorkspaceLangList
 * @method WorkspaceLang[] getWorkspaceLangList(?array $params = null)
 *
 * @property Lang[] $langlist
 * @property Lang[] $LangList
 * @method Lang[] getLangList(?array $params = null)
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
 *
 * @property User $restoredasentity
 * @property User $RestoredAsEntity
 * @method User getRestoredAsEntity(?array $params = null)
 */
abstract class WorkspaceAbstract extends AbstractModel implements WorkspaceAbstractInterface
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
     * Column: name
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $name = null;
        
    /**
     * Column: description
     * Attributes: Size(240) | Type(2)
     * @var mixed
     */
    public mixed $description = null;
        
    /**
     * Column: icon
     * Attributes: Size(64) | Type(2)
     * @var mixed
     */
    public mixed $icon = null;
        
    /**
     * Column: color
     * Attributes: Size(9) | Type(5)
     * @var mixed
     */
    public mixed $color = null;
        
    /**
     * Column: status
     * Attributes: NotNull | Size('active','inactive') | Type(18)
     * @var mixed
     */
    public mixed $status = 'active';
        
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
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $restoredAs = null;
    
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
     * Attributes: Size(240) | Type(2)
     * @return mixed
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }
    
    /**
     * Sets the value of field description
     * Column: description 
     * Attributes: Size(240) | Type(2)
     * @param mixed $description
     * @return void
     */
    public function setDescription(mixed $description): void
    {
        $this->description = $description;
    }
    
    /**
     * Returns the value of field icon
     * Column: icon
     * Attributes: Size(64) | Type(2)
     * @return mixed
     */
    public function getIcon(): mixed
    {
        return $this->icon;
    }
    
    /**
     * Sets the value of field icon
     * Column: icon 
     * Attributes: Size(64) | Type(2)
     * @param mixed $icon
     * @return void
     */
    public function setIcon(mixed $icon): void
    {
        $this->icon = $icon;
    }
    
    /**
     * Returns the value of field color
     * Column: color
     * Attributes: Size(9) | Type(5)
     * @return mixed
     */
    public function getColor(): mixed
    {
        return $this->color;
    }
    
    /**
     * Sets the value of field color
     * Column: color 
     * Attributes: Size(9) | Type(5)
     * @param mixed $color
     * @return void
     */
    public function setColor(mixed $color): void
    {
        $this->color = $color;
    }
    
    /**
     * Returns the value of field status
     * Column: status
     * Attributes: NotNull | Size('active','inactive') | Type(18)
     * @return mixed
     */
    public function getStatus(): mixed
    {
        return $this->status;
    }
    
    /**
     * Sets the value of field status
     * Column: status 
     * Attributes: NotNull | Size('active','inactive') | Type(18)
     * @param mixed $status
     * @return void
     */
    public function setStatus(mixed $status): void
    {
        $this->status = $status;
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
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs(): mixed
    {
        return $this->restoredAs;
    }
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs(mixed $restoredAs): void
    {
        $this->restoredAs = $restoredAs;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->hasMany('id', Column::class, 'workspaceId', ['alias' => 'ColumnList']);

        $this->hasManyToMany(
            'id',
            Column::class,
            'workspaceId',
            'tableId',
            Table::class,
            'id',
            ['alias' => 'ColumnTableList']
        );

        $this->hasMany('id', Data::class, 'workspaceId', ['alias' => 'DataList']);

        $this->hasManyToMany(
            'id',
            Data::class,
            'workspaceId',
            'tableId',
            Table::class,
            'id',
            ['alias' => 'DataTableList']
        );

        $this->hasManyToMany(
            'id',
            Data::class,
            'workspaceId',
            'columnId',
            Column::class,
            'id',
            ['alias' => 'DataColumnList']
        );

        $this->hasManyToMany(
            'id',
            Data::class,
            'workspaceId',
            'recordId',
            Record::class,
            'id',
            ['alias' => 'DataRecordList']
        );

        $this->hasMany('id', Record::class, 'workspaceId', ['alias' => 'RecordList']);

        $this->hasManyToMany(
            'id',
            Record::class,
            'workspaceId',
            'tableId',
            Table::class,
            'id',
            ['alias' => 'RecordTableList']
        );

        $this->hasMany('id', Table::class, 'workspaceId', ['alias' => 'TableList']);

        $this->hasManyToMany(
            'id',
            Table::class,
            'workspaceId',
            'langId',
            Lang::class,
            'id',
            ['alias' => 'TableLangList']
        );

        $this->hasMany('id', WorkspaceLang::class, 'workspaceId', ['alias' => 'WorkspaceLangList']);

        $this->hasManyToMany(
            'id',
            WorkspaceLang::class,
            'workspaceId',
            'langId',
            Lang::class,
            'id',
            ['alias' => 'LangList']
        );

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);

        $this->belongsTo('createdAs', User::class, 'id', ['alias' => 'CreatedAsEntity']);

        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);

        $this->belongsTo('updatedAs', User::class, 'id', ['alias' => 'UpdatedAsEntity']);

        $this->belongsTo('deletedAs', User::class, 'id', ['alias' => 'DeletedAsEntity']);

        $this->belongsTo('deletedBy', User::class, 'id', ['alias' => 'DeletedByEntity']);

        $this->belongsTo('restoredBy', User::class, 'id', ['alias' => 'RestoredByEntity']);

        $this->belongsTo('restoredAs', User::class, 'id', ['alias' => 'RestoredAsEntity']);
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
        $this->addStringLengthValidation($validator, 'name', 0, 60, false);
        $this->addStringLengthValidation($validator, 'description', 0, 240, true);
        $this->addStringLengthValidation($validator, 'icon', 0, 64, true);
        $this->addStringLengthValidation($validator, 'color', 0, 9, true);
        $this->addInclusionInValidation($validator, 'status', ['active','inactive'], false);
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
        $this->addUnsignedIntValidation($validator, 'restoredAs', true);
        
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
            'name' => 'name',
            'description' => 'description',
            'icon' => 'icon',
            'color' => 'color',
            'status' => 'status',
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
            'restored_as' => 'restoredAs',
        ];
    }
}
