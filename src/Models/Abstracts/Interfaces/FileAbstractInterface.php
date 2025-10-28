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
 * @property EmailFileAbstractInterface[] $emailfilelist
 * @property EmailFileAbstractInterface[] $EmailFileList
 * @method EmailFileAbstractInterface[] getEmailFileList(?array $params = null)
 *
 * @property EmailAbstractInterface[] $emaillist
 * @property EmailAbstractInterface[] $EmailList
 * @method EmailAbstractInterface[] getEmailList(?array $params = null)
 *
 * @property FileRelationAbstractInterface[] $filerelationlist
 * @property FileRelationAbstractInterface[] $FileRelationList
 * @method FileRelationAbstractInterface[] getFileRelationList(?array $params = null)
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
interface FileAbstractInterface extends ModelInterface
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
     * Returns the value of field label
     * Column: label
     * Attributes: Size(255) | Type(2)
     * @return mixed
     */
    public function getLabel(): mixed;
    
    /**
     * Sets the value of field label
     * Column: label 
     * Attributes: Size(255) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel(mixed $label): void;
    
    /**
     * Returns the value of field category
     * Column: category
     * Attributes: NotNull | Size('other') | Type(18)
     * @return mixed
     */
    public function getCategory(): mixed;
    
    /**
     * Sets the value of field category
     * Column: category 
     * Attributes: NotNull | Size('other') | Type(18)
     * @param mixed $category
     * @return void
     */
    public function setCategory(mixed $category): void;
    
    /**
     * Returns the value of field path
     * Column: path
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getPath(): mixed;
    
    /**
     * Sets the value of field path
     * Column: path 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $path
     * @return void
     */
    public function setPath(mixed $path): void;
    
    /**
     * Returns the value of field mimeType
     * Column: mime_type
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getMimeType(): mixed;
    
    /**
     * Sets the value of field mimeType
     * Column: mime_type 
     * Attributes: Size(100) | Type(2)
     * @param mixed $mimeType
     * @return void
     */
    public function setMimeType(mixed $mimeType): void;
    
    /**
     * Returns the value of field extension
     * Column: extension
     * Attributes: Size(20) | Type(2)
     * @return mixed
     */
    public function getExtension(): mixed;
    
    /**
     * Sets the value of field extension
     * Column: extension 
     * Attributes: Size(20) | Type(2)
     * @param mixed $extension
     * @return void
     */
    public function setExtension(mixed $extension): void;
    
    /**
     * Returns the value of field size
     * Column: size
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getSize(): mixed;
    
    /**
     * Sets the value of field size
     * Column: size 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $size
     * @return void
     */
    public function setSize(mixed $size): void;
    
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
