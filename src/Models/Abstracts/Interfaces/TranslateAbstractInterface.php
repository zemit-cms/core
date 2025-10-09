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
 * @property LangAbstractInterface $langentity
 * @property LangAbstractInterface $LangEntity
 * @method LangAbstractInterface getLangEntity(?array $params = null)
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
interface TranslateAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement | Size(1) | Type(14)
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
     * Returns the value of field langId
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @return mixed
     */
    public function getLangId(): mixed;
    
    /**
     * Sets the value of field langId
     * Column: lang_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1)
     * @param mixed $langId
     * @return void
     */
    public function setLangId(mixed $langId): void;
    
    /**
     * Returns the value of field translatableTable
     * Column: translatable_table
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getTranslatableTable(): mixed;
    
    /**
     * Sets the value of field translatableTable
     * Column: translatable_table 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $translatableTable
     * @return void
     */
    public function setTranslatableTable(mixed $translatableTable): void;
    
    /**
     * Returns the value of field translatableId
     * Column: translatable_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getTranslatableId(): mixed;
    
    /**
     * Sets the value of field translatableId
     * Column: translatable_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $translatableId
     * @return void
     */
    public function setTranslatableId(mixed $translatableId): void;
    
    /**
     * Returns the value of field field
     * Column: field
     * Attributes: NotNull | Size(60) | Type(2)
     * @return mixed
     */
    public function getField(): mixed;
    
    /**
     * Sets the value of field field
     * Column: field 
     * Attributes: NotNull | Size(60) | Type(2)
     * @param mixed $field
     * @return void
     */
    public function setField(mixed $field): void;
    
    /**
     * Returns the value of field value
     * Column: value
     * Attributes: Type(23)
     * @return mixed
     */
    public function getValue(): mixed;
    
    /**
     * Sets the value of field value
     * Column: value 
     * Attributes: Type(23)
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(26)
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
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getCreatedBy(): mixed;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void;
    
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
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getUpdatedBy(): mixed;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void;
    
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
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getDeletedBy(): mixed;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void;
}
