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
 * @property EmailFile[] $EmailFileList
 * @method EmailFile[] getEmailFileList(?array $params = null)
 *
 * @property Email[] $EmailList
 * @method Email[] getEmailList(?array $params = null)
 *
 * @property FileRelation[] $FileRelationList
 * @method FileRelation[] getFileRelationList(?array $params = null)
 *
 * @property User $UserEntity
 * @method User getUserEntity(?array $params = null)
 */
class FileAbstract extends AbstractModel implements FileAbstractInterface
{
    /**
     * Column: id
     * @var RawValue|int|null
     */
    public RawValue|int|null $id = null;
    
    /**
     * Column: user_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $userId = null;
    
    /**
     * Column: category
     * @var RawValue|string
     */
    public RawValue|string $category = 'other';
    
    /**
     * Column: key
     * @var RawValue|string|null
     */
    public RawValue|string|null $key = null;
    
    /**
     * Column: path
     * @var RawValue|string|null
     */
    public RawValue|string|null $path = null;
    
    /**
     * Column: type
     * @var RawValue|string|null
     */
    public RawValue|string|null $type = null;
    
    /**
     * Column: type_real
     * @var RawValue|string|null
     */
    public RawValue|string|null $typeReal = null;
    
    /**
     * Column: extension
     * @var RawValue|string|null
     */
    public RawValue|string|null $extension = null;
    
    /**
     * Column: name
     * @var RawValue|string|null
     */
    public RawValue|string|null $name = null;
    
    /**
     * Column: name_temp
     * @var RawValue|string|null
     */
    public RawValue|string|null $nameTemp = null;
    
    /**
     * Column: size
     * @var RawValue|string|null
     */
    public RawValue|string|null $size = null;
    
    /**
     * Column: error
     * @var RawValue|string|null
     */
    public RawValue|string|null $error = null;
    
    /**
     * Column: deleted
     * @var RawValue|int
     */
    public RawValue|int $deleted = 0;
    
    /**
     * Column: created_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $createdAt = null;
    
    /**
     * Column: created_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $createdBy = null;
    
    /**
     * Column: created_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $createdAs = null;
    
    /**
     * Column: updated_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $updatedAt = null;
    
    /**
     * Column: updated_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $updatedBy = null;
    
    /**
     * Column: updated_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $updatedAs = null;
    
    /**
     * Column: deleted_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $deletedAt = null;
    
    /**
     * Column: deleted_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedAs = null;
    
    /**
     * Column: deleted_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedBy = null;
    
    /**
     * Column: restored_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $restoredAt = null;
    
    /**
     * Column: restored_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $restoredBy = null;
    
    /**
     * Column: restored_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $restoredAs = null;
    /**
     * Returns the value of field id
     * Column: id
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null
    {
        return $this->id;
    }
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field userId
     * Column: user_id
     * @return RawValue|int|null
     */
    public function getUserId(): RawValue|int|null
    {
        return $this->userId;
    }
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * @param RawValue|int|null $userId
     * @return void
     */
    public function setUserId(RawValue|int|null $userId): void
    {
        $this->userId = $userId;
    }
    
    /**
     * Returns the value of field category
     * Column: category
     * @return RawValue|string
     */
    public function getCategory(): RawValue|string
    {
        return $this->category;
    }
    
    /**
     * Sets the value of field category
     * Column: category 
     * @param RawValue|string $category
     * @return void
     */
    public function setCategory(RawValue|string $category): void
    {
        $this->category = $category;
    }
    
    /**
     * Returns the value of field key
     * Column: key
     * @return RawValue|string|null
     */
    public function getKey(): RawValue|string|null
    {
        return $this->key;
    }
    
    /**
     * Sets the value of field key
     * Column: key 
     * @param RawValue|string|null $key
     * @return void
     */
    public function setKey(RawValue|string|null $key): void
    {
        $this->key = $key;
    }
    
    /**
     * Returns the value of field path
     * Column: path
     * @return RawValue|string|null
     */
    public function getPath(): RawValue|string|null
    {
        return $this->path;
    }
    
    /**
     * Sets the value of field path
     * Column: path 
     * @param RawValue|string|null $path
     * @return void
     */
    public function setPath(RawValue|string|null $path): void
    {
        $this->path = $path;
    }
    
    /**
     * Returns the value of field type
     * Column: type
     * @return RawValue|string|null
     */
    public function getType(): RawValue|string|null
    {
        return $this->type;
    }
    
    /**
     * Sets the value of field type
     * Column: type 
     * @param RawValue|string|null $type
     * @return void
     */
    public function setType(RawValue|string|null $type): void
    {
        $this->type = $type;
    }
    
    /**
     * Returns the value of field typeReal
     * Column: type_real
     * @return RawValue|string|null
     */
    public function getTypeReal(): RawValue|string|null
    {
        return $this->typeReal;
    }
    
    /**
     * Sets the value of field typeReal
     * Column: type_real 
     * @param RawValue|string|null $typeReal
     * @return void
     */
    public function setTypeReal(RawValue|string|null $typeReal): void
    {
        $this->typeReal = $typeReal;
    }
    
    /**
     * Returns the value of field extension
     * Column: extension
     * @return RawValue|string|null
     */
    public function getExtension(): RawValue|string|null
    {
        return $this->extension;
    }
    
    /**
     * Sets the value of field extension
     * Column: extension 
     * @param RawValue|string|null $extension
     * @return void
     */
    public function setExtension(RawValue|string|null $extension): void
    {
        $this->extension = $extension;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * @return RawValue|string|null
     */
    public function getName(): RawValue|string|null
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * @param RawValue|string|null $name
     * @return void
     */
    public function setName(RawValue|string|null $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field nameTemp
     * Column: name_temp
     * @return RawValue|string|null
     */
    public function getNameTemp(): RawValue|string|null
    {
        return $this->nameTemp;
    }
    
    /**
     * Sets the value of field nameTemp
     * Column: name_temp 
     * @param RawValue|string|null $nameTemp
     * @return void
     */
    public function setNameTemp(RawValue|string|null $nameTemp): void
    {
        $this->nameTemp = $nameTemp;
    }
    
    /**
     * Returns the value of field size
     * Column: size
     * @return RawValue|string|null
     */
    public function getSize(): RawValue|string|null
    {
        return $this->size;
    }
    
    /**
     * Sets the value of field size
     * Column: size 
     * @param RawValue|string|null $size
     * @return void
     */
    public function setSize(RawValue|string|null $size): void
    {
        $this->size = $size;
    }
    
    /**
     * Returns the value of field error
     * Column: error
     * @return RawValue|string|null
     */
    public function getError(): RawValue|string|null
    {
        return $this->error;
    }
    
    /**
     * Sets the value of field error
     * Column: error 
     * @param RawValue|string|null $error
     * @return void
     */
    public function setError(RawValue|string|null $error): void
    {
        $this->error = $error;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return RawValue|int
     */
    public function getDeleted(): RawValue|int
    {
        return $this->deleted;
    }
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param RawValue|int $deleted
     * @return void
     */
    public function setDeleted(RawValue|int $deleted): void
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return RawValue|string|null
     */
    public function getCreatedAt(): RawValue|string|null
    {
        return $this->createdAt;
    }
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string|null $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string|null $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return RawValue|int|null
     */
    public function getCreatedBy(): RawValue|int|null
    {
        return $this->createdBy;
    }
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param RawValue|int|null $createdBy
     * @return void
     */
    public function setCreatedBy(RawValue|int|null $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return RawValue|int|null
     */
    public function getCreatedAs(): RawValue|int|null
    {
        return $this->createdAs;
    }
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param RawValue|int|null $createdAs
     * @return void
     */
    public function setCreatedAs(RawValue|int|null $createdAs): void
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return RawValue|string|null
     */
    public function getUpdatedAt(): RawValue|string|null
    {
        return $this->updatedAt;
    }
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param RawValue|string|null $updatedAt
     * @return void
     */
    public function setUpdatedAt(RawValue|string|null $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return RawValue|int|null
     */
    public function getUpdatedBy(): RawValue|int|null
    {
        return $this->updatedBy;
    }
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param RawValue|int|null $updatedBy
     * @return void
     */
    public function setUpdatedBy(RawValue|int|null $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return RawValue|int|null
     */
    public function getUpdatedAs(): RawValue|int|null
    {
        return $this->updatedAs;
    }
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param RawValue|int|null $updatedAs
     * @return void
     */
    public function setUpdatedAs(RawValue|int|null $updatedAs): void
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return RawValue|string|null
     */
    public function getDeletedAt(): RawValue|string|null
    {
        return $this->deletedAt;
    }
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param RawValue|string|null $deletedAt
     * @return void
     */
    public function setDeletedAt(RawValue|string|null $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return RawValue|int|null
     */
    public function getDeletedAs(): RawValue|int|null
    {
        return $this->deletedAs;
    }
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param RawValue|int|null $deletedAs
     * @return void
     */
    public function setDeletedAs(RawValue|int|null $deletedAs): void
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return RawValue|int|null
     */
    public function getDeletedBy(): RawValue|int|null
    {
        return $this->deletedBy;
    }
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param RawValue|int|null $deletedBy
     * @return void
     */
    public function setDeletedBy(RawValue|int|null $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return RawValue|string|null
     */
    public function getRestoredAt(): RawValue|string|null
    {
        return $this->restoredAt;
    }
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param RawValue|string|null $restoredAt
     * @return void
     */
    public function setRestoredAt(RawValue|string|null $restoredAt): void
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return RawValue|int|null
     */
    public function getRestoredBy(): RawValue|int|null
    {
        return $this->restoredBy;
    }
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param RawValue|int|null $restoredBy
     * @return void
     */
    public function setRestoredBy(RawValue|int|null $restoredBy): void
    {
        $this->restoredBy = $restoredBy;
    }
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return RawValue|int|null
     */
    public function getRestoredAs(): RawValue|int|null
    {
        return $this->restoredAs;
    }
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param RawValue|int|null $restoredAs
     * @return void
     */
    public function setRestoredAs(RawValue|int|null $restoredAs): void
    {
        $this->restoredAs = $restoredAs;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->hasMany('id', EmailFile::class, 'fileId', ['alias' => 'EmailFileList']);

        $this->hasManyToMany('id', EmailFile::class, 'fileId',
            'emailId', Email::class, 'id', ['alias' => 'EmailList']);

        $this->hasMany('id', FileRelation::class, 'fileId', ['alias' => 'FileRelationList']);

        $this->belongsTo('userId', User::class, 'id', ['alias' => 'UserEntity']);
    }
    
    /**
     * Adds the default validations to the model.
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addUnsignedIntValidation($validator, 'userId', true);
        $this->addInclusionInValidation($validator, 'category', ['partner','speaker','event','other'], false);
        $this->addStringLengthValidation($validator, 'key', 0, 50, true);
        $this->addStringLengthValidation($validator, 'path', 0, 120, true);
        $this->addStringLengthValidation($validator, 'type', 0, 100, true);
        $this->addStringLengthValidation($validator, 'typeReal', 0, 100, true);
        $this->addStringLengthValidation($validator, 'extension', 0, 6, true);
        $this->addStringLengthValidation($validator, 'name', 0, 100, true);
        $this->addStringLengthValidation($validator, 'nameTemp', 0, 120, true);
        $this->addStringLengthValidation($validator, 'size', 0, 45, true);
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
    public function columnMap(): array {
        return [
            'id' => 'id',
            'user_id' => 'userId',
            'category' => 'category',
            'key' => 'key',
            'path' => 'path',
            'type' => 'type',
            'type_real' => 'typeReal',
            'extension' => 'extension',
            'name' => 'name',
            'name_temp' => 'nameTemp',
            'size' => 'size',
            'error' => 'error',
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