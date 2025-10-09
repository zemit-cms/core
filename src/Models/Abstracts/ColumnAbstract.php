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
use \Zemit\Models\AbstractModel;
use Zemit\Models\Data;
use Zemit\Models\Record;
use Zemit\Models\Validator;
use Zemit\Models\Table;
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
 * @property Record[] $datarecordlist
 * @property Record[] $DataRecordList
 * @method Record[] getDataRecordList(?array $params = null)
 *
 * @property Validator[] $validatorlist
 * @property Validator[] $ValidatorList
 * @method Validator[] getValidatorList(?array $params = null)
 *
 * @property Table $tableentity
 * @property Table $TableEntity
 * @method Table getTableEntity(?array $params = null)
 *
 * @property User $createdbyentity
 * @property User $CreatedByEntity
 * @method User getCreatedByEntity(?array $params = null)
 *
 * @property User $updatedbyentity
 * @property User $UpdatedByEntity
 * @method User getUpdatedByEntity(?array $params = null)
 *
 * @property User $deletedbyentity
 * @property User $DeletedByEntity
 * @method User getDeletedByEntity(?array $params = null)
 */
abstract class ColumnAbstract extends \Zemit\Models\AbstractModel implements ColumnAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
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
     * Column: table_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $tableId = null;
        
    /**
     * Column: label
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $label = null;
        
    /**
     * Column: type
     * Attributes: NotNull | Size('linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button') | Type(18)
     * @var mixed
     */
    public mixed $type = 'singleLineText';
        
    /**
     * Column: description
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public mixed $description = null;
        
    /**
     * Column: options
     * Attributes: Type(24)
     * @var mixed
     */
    public mixed $options = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @var mixed
     */
    public mixed $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public mixed $createdAt = 'current_timestamp()';
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $createdBy = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $updatedBy = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $deletedAt = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $deletedBy = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
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
     * Returns the value of field tableId
     * Column: table_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getTableId(): mixed
    {
        return $this->tableId;
    }
    
    /**
     * Sets the value of field tableId
     * Column: table_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $tableId
     * @return void
     */
    public function setTableId(mixed $tableId): void
    {
        $this->tableId = $tableId;
    }
    
    /**
     * Returns the value of field label
     * Column: label
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getLabel(): mixed
    {
        return $this->label;
    }
    
    /**
     * Sets the value of field label
     * Column: label 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel(mixed $label): void
    {
        $this->label = $label;
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
     * Returns the value of field options
     * Column: options
     * Attributes: Type(24)
     * @return mixed
     */
    public function getOptions(): mixed
    {
        return $this->options;
    }
    
    /**
     * Sets the value of field options
     * Column: options 
     * Attributes: Type(24)
     * @param mixed $options
     * @return void
     */
    public function setOptions(mixed $options): void
    {
        $this->options = $options;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
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
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getCreatedBy(): mixed
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void
    {
        $this->createdBy = $createdBy;
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
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getUpdatedBy(): mixed
    {
        return $this->updatedBy;
    }
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
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
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getDeletedBy(): mixed
    {
        return $this->deletedBy;
    }
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
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
            'recordId',
            Record::class,
            'id',
            ['alias' => 'DataRecordList']
        );

        $this->hasMany('id', Validator::class, 'columnId', ['alias' => 'ValidatorList']);

        $this->belongsTo('tableId', Table::class, 'id', ['alias' => 'TableEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);

        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);

        $this->belongsTo('deletedBy', User::class, 'id', ['alias' => 'DeletedByEntity']);
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
        $this->addUnsignedIntValidation($validator, 'tableId', false);
        $this->addStringLengthValidation($validator, 'label', 0, 60, false);
        $this->addInclusionInValidation($validator, 'type', ['linkToAnotherRecord','singleLineText','longText','attachment','checkbox','multipleSelect','singleSelect','user','date','phoneNumber','email','url','number','currency','percent','duration','rating','formula','rollup','count','lookup','createdTime','lastModifiedTime','createdBy','lastModifiedBy','autonumber','barcode','button'], false);
        $this->addStringLengthValidation($validator, 'description', 0, 120, true);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        $this->addDateTimeValidation($validator, 'updatedAt', true);
        $this->addUnsignedIntValidation($validator, 'updatedBy', true);
        $this->addDateTimeValidation($validator, 'deletedAt', true);
        $this->addUnsignedIntValidation($validator, 'deletedBy', true);
        
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
            'table_id' => 'tableId',
            'label' => 'label',
            'type' => 'type',
            'description' => 'description',
            'options' => 'options',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'deleted_at' => 'deletedAt',
            'deleted_by' => 'deletedBy',
        ];
    }
}
