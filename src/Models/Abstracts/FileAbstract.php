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
use Zemit\Models\EmailFile;
use Zemit\Models\Email;
use Zemit\Models\FileRelation;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\FileAbstractInterface;

/**
 * Class FileAbstract
 *
 * This class defines a File abstract model that extends the AbstractModel class and implements the FileAbstractInterface.
 * It provides properties and methods for managing File data.
 * 
 * @property EmailFile[] $emailfilelist
 * @property EmailFile[] $EmailFileList
 * @method EmailFile[] getEmailFileList(?array $params = null)
 *
 * @property Email[] $emaillist
 * @property Email[] $EmailList
 * @method Email[] getEmailList(?array $params = null)
 *
 * @property FileRelation[] $filerelationlist
 * @property FileRelation[] $FileRelationList
 * @method FileRelation[] getFileRelationList(?array $params = null)
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
abstract class FileAbstract extends \Zemit\Models\AbstractModel implements FileAbstractInterface
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
     * Column: label
     * Attributes: Size(255) | Type(2)
     * @var mixed
     */
    public mixed $label = null;
        
    /**
     * Column: category
     * Attributes: NotNull | Size('other') | Type(18)
     * @var mixed
     */
    public mixed $category = 'other';
        
    /**
     * Column: path
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public mixed $path = null;
        
    /**
     * Column: mime_type
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public mixed $mimeType = null;
        
    /**
     * Column: extension
     * Attributes: Size(20) | Type(2)
     * @var mixed
     */
    public mixed $extension = null;
        
    /**
     * Column: size
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $size = null;
        
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
     * Returns the value of field label
     * Column: label
     * Attributes: Size(255) | Type(2)
     * @return mixed
     */
    public function getLabel(): mixed
    {
        return $this->label;
    }
    
    /**
     * Sets the value of field label
     * Column: label 
     * Attributes: Size(255) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel(mixed $label): void
    {
        $this->label = $label;
    }
    
    /**
     * Returns the value of field category
     * Column: category
     * Attributes: NotNull | Size('other') | Type(18)
     * @return mixed
     */
    public function getCategory(): mixed
    {
        return $this->category;
    }
    
    /**
     * Sets the value of field category
     * Column: category 
     * Attributes: NotNull | Size('other') | Type(18)
     * @param mixed $category
     * @return void
     */
    public function setCategory(mixed $category): void
    {
        $this->category = $category;
    }
    
    /**
     * Returns the value of field path
     * Column: path
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getPath(): mixed
    {
        return $this->path;
    }
    
    /**
     * Sets the value of field path
     * Column: path 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $path
     * @return void
     */
    public function setPath(mixed $path): void
    {
        $this->path = $path;
    }
    
    /**
     * Returns the value of field mimeType
     * Column: mime_type
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getMimeType(): mixed
    {
        return $this->mimeType;
    }
    
    /**
     * Sets the value of field mimeType
     * Column: mime_type 
     * Attributes: Size(100) | Type(2)
     * @param mixed $mimeType
     * @return void
     */
    public function setMimeType(mixed $mimeType): void
    {
        $this->mimeType = $mimeType;
    }
    
    /**
     * Returns the value of field extension
     * Column: extension
     * Attributes: Size(20) | Type(2)
     * @return mixed
     */
    public function getExtension(): mixed
    {
        return $this->extension;
    }
    
    /**
     * Sets the value of field extension
     * Column: extension 
     * Attributes: Size(20) | Type(2)
     * @param mixed $extension
     * @return void
     */
    public function setExtension(mixed $extension): void
    {
        $this->extension = $extension;
    }
    
    /**
     * Returns the value of field size
     * Column: size
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getSize(): mixed
    {
        return $this->size;
    }
    
    /**
     * Sets the value of field size
     * Column: size 
     * Attributes: Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $size
     * @return void
     */
    public function setSize(mixed $size): void
    {
        $this->size = $size;
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
        $this->hasMany('id', EmailFile::class, 'fileId', ['alias' => 'EmailFileList']);

        $this->hasManyToMany(
            'id',
            EmailFile::class,
            'fileId',
            'emailId',
            Email::class,
            'id',
            ['alias' => 'EmailList']
        );

        $this->hasMany('id', FileRelation::class, 'fileId', ['alias' => 'FileRelationList']);

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
        $this->addStringLengthValidation($validator, 'label', 0, 255, true);
        $this->addInclusionInValidation($validator, 'category', ['other'], false);
        $this->addStringLengthValidation($validator, 'path', 0, 255, false);
        $this->addStringLengthValidation($validator, 'mimeType', 0, 100, true);
        $this->addStringLengthValidation($validator, 'extension', 0, 20, true);
        $this->addUnsignedIntValidation($validator, 'size', true);
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
            'label' => 'label',
            'category' => 'category',
            'path' => 'path',
            'mime_type' => 'mimeType',
            'extension' => 'extension',
            'size' => 'size',
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
