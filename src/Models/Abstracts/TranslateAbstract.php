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
use Zemit\Models\Lang;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\TranslateAbstractInterface;

/**
 * Class TranslateAbstract
 *
 * This class defines a Translate abstract model that extends the AbstractModel class and implements the TranslateAbstractInterface.
 * It provides properties and methods for managing Translate data.
 * 
 * @property Lang $langentity
 * @property Lang $LangEntity
 * @method Lang getLangEntity(?array $params = null)
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
abstract class TranslateAbstract extends \Zemit\Models\AbstractModel implements TranslateAbstractInterface
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
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @var mixed
     */
    public mixed $langId = null;
        
    /**
     * Column: translatable_table
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $translatableTable = null;
        
    /**
     * Column: translatable_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $translatableId = null;
        
    /**
     * Column: field
     * Attributes: NotNull | Size(60) | Type(2)
     * @var mixed
     */
    public mixed $field = null;
        
    /**
     * Column: value
     * Attributes: Type(23)
     * @var mixed
     */
    public mixed $value = null;
        
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
    public function setUuid(mixed $uuid): void
    {
        $this->uuid = $uuid;
    }
    
    /**
     * Returns the value of field langId
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @return mixed
     */
    #[\Override]
    public function getLangId(): mixed
    {
        return $this->langId;
    }
    
    /**
     * Sets the value of field langId
     * Column: lang_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @param mixed $langId
     * @return void
     */
    #[\Override]
    public function setLangId(mixed $langId): void
    {
        $this->langId = $langId;
    }
    
    /**
     * Returns the value of field translatableTable
     * Column: translatable_table
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    #[\Override]
    public function getTranslatableTable(): mixed
    {
        return $this->translatableTable;
    }
    
    /**
     * Sets the value of field translatableTable
     * Column: translatable_table 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $translatableTable
     * @return void
     */
    #[\Override]
    public function setTranslatableTable(mixed $translatableTable): void
    {
        $this->translatableTable = $translatableTable;
    }
    
    /**
     * Returns the value of field translatableId
     * Column: translatable_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    #[\Override]
    public function getTranslatableId(): mixed
    {
        return $this->translatableId;
    }
    
    /**
     * Sets the value of field translatableId
     * Column: translatable_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $translatableId
     * @return void
     */
    #[\Override]
    public function setTranslatableId(mixed $translatableId): void
    {
        $this->translatableId = $translatableId;
    }
    
    /**
     * Returns the value of field field
     * Column: field
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    #[\Override]
    public function getField(): mixed
    {
        return $this->field;
    }
    
    /**
     * Sets the value of field field
     * Column: field 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $field
     * @return void
     */
    #[\Override]
    public function setField(mixed $field): void
    {
        $this->field = $field;
    }
    
    /**
     * Returns the value of field value
     * Column: value
     * Attributes: Type(23)
     * @return mixed
     */
    #[\Override]
    public function getValue(): mixed
    {
        return $this->value;
    }
    
    /**
     * Sets the value of field value
     * Column: value 
     * Attributes: Type(23)
     * @param mixed $value
     * @return void
     */
    #[\Override]
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @return mixed
     */
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
    #[\Override]
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
        $this->belongsTo('langId', Lang::class, 'id', ['alias' => 'LangEntity']);

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
        $this->addUnsignedIntValidation($validator, 'langId', false);
        $this->addStringLengthValidation($validator, 'translatableTable', 0, 60, false);
        $this->addUnsignedIntValidation($validator, 'translatableId', false);
        $this->addStringLengthValidation($validator, 'field', 0, 60, false);
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
            'lang_id' => 'langId',
            'translatable_table' => 'translatableTable',
            'translatable_id' => 'translatableId',
            'field' => 'field',
            'value' => 'value',
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
