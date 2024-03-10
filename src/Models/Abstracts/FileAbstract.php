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
    public $id = null;
        
    /**
     * Column: user_id
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $userId = null;
        
    /**
     * Column: category
     * Attributes: NotNull | Size('partner','speaker','event','other') | Type(18)
     * @var mixed
     */
    public $category = 'other';
        
    /**
     * Column: key
     * Attributes: Size(50) | Type(2)
     * @var mixed
     */
    public $key = null;
        
    /**
     * Column: path
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public $path = null;
        
    /**
     * Column: type
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public $type = null;
        
    /**
     * Column: type_real
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public $typeReal = null;
        
    /**
     * Column: extension
     * Attributes: Size(6) | Type(5)
     * @var mixed
     */
    public $extension = null;
        
    /**
     * Column: name
     * Attributes: Size(100) | Type(2)
     * @var mixed
     */
    public $name = null;
        
    /**
     * Column: name_temp
     * Attributes: Size(120) | Type(2)
     * @var mixed
     */
    public $nameTemp = null;
        
    /**
     * Column: size
     * Attributes: Size(45) | Type(2)
     * @var mixed
     */
    public $size = null;
        
    /**
     * Column: error
     * Attributes: Type(6)
     * @var mixed
     */
    public $error = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public $createdAt = null;
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdBy = null;
        
    /**
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdAs = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedBy = null;
        
    /**
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedAs = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $deletedAt = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedAs = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedBy = null;
        
    /**
     * Column: restored_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $restoredAt = null;
        
    /**
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $restoredBy = null;
        
    /**
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $restoredAs = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId()
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
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field userId
     * Column: user_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUserId()
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
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * Returns the value of field category
     * Column: category
     * Attributes: NotNull | Size('partner','speaker','event','other') | Type(18)
     * @return mixed
     */
    public function getCategory()
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
    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    /**
     * Returns the value of field key
     * Column: key
     * Attributes: Size(50) | Type(2)
     * @return mixed
     */
    public function getKey()
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
    public function setKey($key)
    {
        $this->key = $key;
    }
    
    /**
     * Returns the value of field path
     * Column: path
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getPath()
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
    public function setPath($path)
    {
        $this->path = $path;
    }
    
    /**
     * Returns the value of field type
     * Column: type
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getType()
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
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * Returns the value of field typeReal
     * Column: type_real
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getTypeReal()
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
    public function setTypeReal($typeReal)
    {
        $this->typeReal = $typeReal;
    }
    
    /**
     * Returns the value of field extension
     * Column: extension
     * Attributes: Size(6) | Type(5)
     * @return mixed
     */
    public function getExtension()
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
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: Size(100) | Type(2)
     * @return mixed
     */
    public function getName()
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
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field nameTemp
     * Column: name_temp
     * Attributes: Size(120) | Type(2)
     * @return mixed
     */
    public function getNameTemp()
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
    public function setNameTemp($nameTemp)
    {
        $this->nameTemp = $nameTemp;
    }
    
    /**
     * Returns the value of field size
     * Column: size
     * Attributes: Size(45) | Type(2)
     * @return mixed
     */
    public function getSize()
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
    public function setSize($size)
    {
        $this->size = $size;
    }
    
    /**
     * Returns the value of field error
     * Column: error
     * Attributes: Type(6)
     * @return mixed
     */
    public function getError()
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
    public function setError($error)
    {
        $this->error = $error;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted()
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
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt()
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
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy()
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
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs()
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
    public function setCreatedAs($createdAs)
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt()
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
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy()
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
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs()
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
    public function setUpdatedAs($updatedAs)
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt()
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
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs()
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
    public function setDeletedAs($deletedAs)
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy()
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
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt()
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
    public function setRestoredAt($restoredAt)
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy()
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
    public function setRestoredBy($restoredBy)
    {
        $this->restoredBy = $restoredBy;
    }
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs()
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
    public function setRestoredAs($restoredAs)
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