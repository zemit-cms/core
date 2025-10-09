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
use Zemit\Models\Email;
use Zemit\Models\File;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\EmailFileAbstractInterface;

/**
 * Class EmailFileAbstract
 *
 * This class defines a EmailFile abstract model that extends the AbstractModel class and implements the EmailFileAbstractInterface.
 * It provides properties and methods for managing EmailFile data.
 * 
 * @property Email $emailentity
 * @property Email $EmailEntity
 * @method Email getEmailEntity(?array $params = null)
 *
 * @property File $fileentity
 * @property File $FileEntity
 * @method File getFileEntity(?array $params = null)
 *
 * @property User $createdbyentity
 * @property User $CreatedByEntity
 * @method User getCreatedByEntity(?array $params = null)
 */
abstract class EmailFileAbstract extends \Zemit\Models\AbstractModel implements EmailFileAbstractInterface
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
     * Column: email_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $emailId = null;
        
    /**
     * Column: file_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @var mixed
     */
    public mixed $fileId = null;
        
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
     * Returns the value of field emailId
     * Column: email_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getEmailId(): mixed
    {
        return $this->emailId;
    }
    
    /**
     * Sets the value of field emailId
     * Column: email_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $emailId
     * @return void
     */
    public function setEmailId(mixed $emailId): void
    {
        $this->emailId = $emailId;
    }
    
    /**
     * Returns the value of field fileId
     * Column: file_id
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @return mixed
     */
    public function getFileId(): mixed
    {
        return $this->fileId;
    }
    
    /**
     * Sets the value of field fileId
     * Column: file_id 
     * Attributes: NotNull | Numeric | Unsigned | Size(1) | Type(14)
     * @param mixed $fileId
     * @return void
     */
    public function setFileId(mixed $fileId): void
    {
        $this->fileId = $fileId;
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
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->belongsTo('emailId', Email::class, 'id', ['alias' => 'EmailEntity']);

        $this->belongsTo('fileId', File::class, 'id', ['alias' => 'FileEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);
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
        $this->addUnsignedIntValidation($validator, 'emailId', false);
        $this->addUnsignedIntValidation($validator, 'fileId', false);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        
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
            'email_id' => 'emailId',
            'file_id' => 'fileId',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
        ];
    }
}
