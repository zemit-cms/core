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
 * @property User $userentity
 * @property User $UserEntity
 * @method User getUserEntity(?array $params = null)
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
abstract class FileAbstract extends AbstractModel implements FileAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public mixed $id = null;
        
    /**
     * Column: user_id
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $userId = null;
        
    /**
     * Column: category
     * Attributes: NotNull | Size('partner','speaker','event','other') | Type(18)
     * @var mixed
     */
    public mixed $category = 'other';
        
    /**
     * Column: key
     * Attributes: Size(50) | Type(2)
     * @var mixed
     */
    public mixed $key = null;
        
    /**
     * Column: path
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public mixed $path = null;
        
    /**
     * Column: type
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public mixed $type = null;
        
    /**
     * Column: type_real
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public mixed $typeReal = null;
        
    /**
     * Column: extension
     * Attributes: Size(6) | Type(5)
     * @var mixed
     */
    public mixed $extension = null;
        
    /**
     * Column: name
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public mixed $name = null;
        
    /**
     * Column: name_temp
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public mixed $nameTemp = null;
        
    /**
     * Column: size
     * Attributes: Size(45) | Type(2)
     * @var mixed
     */
    public mixed $size = null;
        
    /**
     * Column: error
     * Attributes: Type(6)
     * @var mixed
     */
    public mixed $error = null;
        
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
     * Returns the value of field userId
     * Column: user_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUserId(): mixed
    {
        return $this->userId;
    }
    
    /**
     * Sets the value of field userId
     * Column: user_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $userId
     * @return void
     */
    public function setUserId(mixed $userId): void
    {
        $this->userId = $userId;
    }
    
    /**
     * Returns the value of field category
     * Column: category
     * Attributes: NotNull | Size('partner','speaker','event','other') | Type(18)
     * @return mixed
     */
    public function getCategory(): mixed
    {
        return $this->category;
    }
    
    /**
     * Sets the value of field category
     * Column: category 
     * Attributes: NotNull | Size('partner','speaker','event','other') | Type(18)
     * @param mixed $category
     * @return void
     */
    public function setCategory(mixed $category): void
    {
        $this->category = $category;
    }
    
    /**
     * Returns the value of field key
     * Column: key
     * Attributes: Size(50) | Type(2)
     * @return mixed
     */
    public function getKey(): mixed
    {
        return $this->key;
    }
    
    /**
     * Sets the value of field key
     * Column: key 
     * Attributes: Size(50) | Type(2)
     * @param mixed $key
     * @return void
     */
    public function setKey(mixed $key): void
    {
        $this->key = $key;
    }
    
    /**
     * Returns the value of field path
     * Column: path
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getPath(): mixed
    {
        return $this->path;
    }
    
    /**
     * Sets the value of field path
     * Column: path 
     * Attributes: Size(120) | Type(2)
     * @param mixed $path
     * @return void
     */
    public function setPath(mixed $path): void
    {
        $this->path = $path;
    }
    
    /**
     * Returns the value of field type
     * Column: type
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }
    
    /**
     * Sets the value of field type
     * Column: type 
     * Attributes: Size(100) | Type(2)
     * @param mixed $type
     * @return void
     */
    public function setType(mixed $type): void
    {
        $this->type = $type;
    }
    
    /**
     * Returns the value of field typeReal
     * Column: type_real
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getTypeReal(): mixed
    {
        return $this->typeReal;
    }
    
    /**
     * Sets the value of field typeReal
     * Column: type_real 
     * Attributes: Size(100) | Type(2)
     * @param mixed $typeReal
     * @return void
     */
    public function setTypeReal(mixed $typeReal): void
    {
        $this->typeReal = $typeReal;
    }
    
    /**
     * Returns the value of field extension
     * Column: extension
     * Attributes: Size(6) | Type(5)
     * @return mixed
     */
    public function getExtension(): mixed
    {
        return $this->extension;
    }
    
    /**
     * Sets the value of field extension
     * Column: extension 
     * Attributes: Size(6) | Type(5)
     * @param mixed $extension
     * @return void
     */
    public function setExtension(mixed $extension): void
    {
        $this->extension = $extension;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: Size(100) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field nameTemp
     * Column: name_temp
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getNameTemp(): mixed
    {
        return $this->nameTemp;
    }
    
    /**
     * Sets the value of field nameTemp
     * Column: name_temp 
     * Attributes: Size(120) | Type(2)
     * @param mixed $nameTemp
     * @return void
     */
    public function setNameTemp(mixed $nameTemp): void
    {
        $this->nameTemp = $nameTemp;
    }
    
    /**
     * Returns the value of field size
     * Column: size
     * Attributes: Size(45) | Type(2)
     * @return mixed
     */
    public function getSize(): mixed
    {
        return $this->size;
    }
    
    /**
     * Sets the value of field size
     * Column: size 
     * Attributes: Size(45) | Type(2)
     * @param mixed $size
     * @return void
     */
    public function setSize(mixed $size): void
    {
        $this->size = $size;
    }
    
    /**
     * Returns the value of field error
     * Column: error
     * Attributes: Type(6)
     * @return mixed
     */
    public function getError(): mixed
    {
        return $this->error;
    }
    
    /**
     * Sets the value of field error
     * Column: error 
     * Attributes: Type(6)
     * @param mixed $error
     * @return void
     */
    public function setError(mixed $error): void
    {
        $this->error = $error;
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

        $this->belongsTo('userId', User::class, 'id', ['alias' => 'UserEntity']);

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
    public function columnMap(): array
    {
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
