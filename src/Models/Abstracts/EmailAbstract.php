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
use Zemit\Models\File;
use Zemit\Models\Template;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\EmailAbstractInterface;

/**
 * Class EmailAbstract
 *
 * This class defines a Email abstract model that extends the AbstractModel class and implements the EmailAbstractInterface.
 * It provides properties and methods for managing Email data.
 * 
 * @property EmailFile[] $emailfilelist
 * @property EmailFile[] $EmailFileList
 * @method EmailFile[] getEmailFileList(?array $params = null)
 *
 * @property File[] $filelist
 * @property File[] $FileList
 * @method File[] getFileList(?array $params = null)
 *
 * @property Template $templateentity
 * @property Template $TemplateEntity
 * @method Template getTemplateEntity(?array $params = null)
 *
 * @property User $sentbyentity
 * @property User $SentByEntity
 * @method User getSentByEntity(?array $params = null)
 *
 * @property User $sentasentity
 * @property User $SentAsEntity
 * @method User getSentAsEntity(?array $params = null)
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
 * @property User $deletedbyentity
 * @property User $DeletedByEntity
 * @method User getDeletedByEntity(?array $params = null)
 *
 * @property User $deletedasentity
 * @property User $DeletedAsEntity
 * @method User getDeletedAsEntity(?array $params = null)
 *
 * @property User $restoredbyentity
 * @property User $RestoredByEntity
 * @method User getRestoredByEntity(?array $params = null)
 *
 * @property User $restoredasentity
 * @property User $RestoredAsEntity
 * @method User getRestoredAsEntity(?array $params = null)
 */
abstract class EmailAbstract extends AbstractModel implements EmailAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public mixed $id = null;
        
    /**
     * Column: template_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public mixed $templateId = null;
        
    /**
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @var mixed
     */
    public mixed $uuid = null;
        
    /**
     * Column: from
     * Attributes: NotNull | Size(500) | Type(2)
     * @var mixed
     */
    public mixed $from = null;
        
    /**
     * Column: to
     * Attributes: NotNull | Type(6)
     * @var mixed
     */
    public mixed $to = null;
        
    /**
     * Column: cc
     * Attributes: Type(6)
     * @var mixed
     */
    public mixed $cc = null;
        
    /**
     * Column: bcc
     * Attributes: Type(6)
     * @var mixed
     */
    public mixed $bcc = null;
        
    /**
     * Column: read_receipt_to
     * Attributes: Type(6)
     * @var mixed
     */
    public mixed $readReceiptTo = null;
        
    /**
     * Column: subject
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public mixed $subject = null;
        
    /**
     * Column: content
     * Attributes: NotNull | Type(23)
     * @var mixed
     */
    public mixed $content = null;
        
    /**
     * Column: meta
     * Attributes: Type(23)
     * @var mixed
     */
    public mixed $meta = null;
        
    /**
     * Column: view_path
     * Attributes: Size(255) | Type(2)
     * @var mixed
     */
    public mixed $viewPath = null;
        
    /**
     * Column: sent
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public mixed $sent = 0;
        
    /**
     * Column: sent_at
     * Attributes: Type(4)
     * @var mixed
     */
    public mixed $sentAt = null;
        
    /**
     * Column: sent_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $sentBy = null;
        
    /**
     * Column: sent_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $sentAs = null;
        
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
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedBy = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedAs = null;
        
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
     * Returns the value of field templateId
     * Column: template_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getTemplateId(): mixed
    {
        return $this->templateId;
    }
    
    /**
     * Sets the value of field templateId
     * Column: template_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $templateId
     * @return void
     */
    public function setTemplateId(mixed $templateId): void
    {
        $this->templateId = $templateId;
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
     * Returns the value of field from
     * Column: from
     * Attributes: NotNull | Size(500) | Type(2)
     * @return mixed
     */
    public function getFrom(): mixed
    {
        return $this->from;
    }
    
    /**
     * Sets the value of field from
     * Column: from 
     * Attributes: NotNull | Size(500) | Type(2)
     * @param mixed $from
     * @return void
     */
    public function setFrom(mixed $from): void
    {
        $this->from = $from;
    }
    
    /**
     * Returns the value of field to
     * Column: to
     * Attributes: NotNull | Type(6)
     * @return mixed
     */
    public function getTo(): mixed
    {
        return $this->to;
    }
    
    /**
     * Sets the value of field to
     * Column: to 
     * Attributes: NotNull | Type(6)
     * @param mixed $to
     * @return void
     */
    public function setTo(mixed $to): void
    {
        $this->to = $to;
    }
    
    /**
     * Returns the value of field cc
     * Column: cc
     * Attributes: Type(6)
     * @return mixed
     */
    public function getCc(): mixed
    {
        return $this->cc;
    }
    
    /**
     * Sets the value of field cc
     * Column: cc 
     * Attributes: Type(6)
     * @param mixed $cc
     * @return void
     */
    public function setCc(mixed $cc): void
    {
        $this->cc = $cc;
    }
    
    /**
     * Returns the value of field bcc
     * Column: bcc
     * Attributes: Type(6)
     * @return mixed
     */
    public function getBcc(): mixed
    {
        return $this->bcc;
    }
    
    /**
     * Sets the value of field bcc
     * Column: bcc 
     * Attributes: Type(6)
     * @param mixed $bcc
     * @return void
     */
    public function setBcc(mixed $bcc): void
    {
        $this->bcc = $bcc;
    }
    
    /**
     * Returns the value of field readReceiptTo
     * Column: read_receipt_to
     * Attributes: Type(6)
     * @return mixed
     */
    public function getReadReceiptTo(): mixed
    {
        return $this->readReceiptTo;
    }
    
    /**
     * Sets the value of field readReceiptTo
     * Column: read_receipt_to 
     * Attributes: Type(6)
     * @param mixed $readReceiptTo
     * @return void
     */
    public function setReadReceiptTo(mixed $readReceiptTo): void
    {
        $this->readReceiptTo = $readReceiptTo;
    }
    
    /**
     * Returns the value of field subject
     * Column: subject
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getSubject(): mixed
    {
        return $this->subject;
    }
    
    /**
     * Sets the value of field subject
     * Column: subject 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $subject
     * @return void
     */
    public function setSubject(mixed $subject): void
    {
        $this->subject = $subject;
    }
    
    /**
     * Returns the value of field content
     * Column: content
     * Attributes: NotNull | Type(23)
     * @return mixed
     */
    public function getContent(): mixed
    {
        return $this->content;
    }
    
    /**
     * Sets the value of field content
     * Column: content 
     * Attributes: NotNull | Type(23)
     * @param mixed $content
     * @return void
     */
    public function setContent(mixed $content): void
    {
        $this->content = $content;
    }
    
    /**
     * Returns the value of field meta
     * Column: meta
     * Attributes: Type(23)
     * @return mixed
     */
    public function getMeta(): mixed
    {
        return $this->meta;
    }
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * Attributes: Type(23)
     * @param mixed $meta
     * @return void
     */
    public function setMeta(mixed $meta): void
    {
        $this->meta = $meta;
    }
    
    /**
     * Returns the value of field viewPath
     * Column: view_path
     * Attributes: Size(255) | Type(2)
     * @return mixed
     */
    public function getViewPath(): mixed
    {
        return $this->viewPath;
    }
    
    /**
     * Sets the value of field viewPath
     * Column: view_path 
     * Attributes: Size(255) | Type(2)
     * @param mixed $viewPath
     * @return void
     */
    public function setViewPath(mixed $viewPath): void
    {
        $this->viewPath = $viewPath;
    }
    
    /**
     * Returns the value of field sent
     * Column: sent
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getSent(): mixed
    {
        return $this->sent;
    }
    
    /**
     * Sets the value of field sent
     * Column: sent 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $sent
     * @return void
     */
    public function setSent(mixed $sent): void
    {
        $this->sent = $sent;
    }
    
    /**
     * Returns the value of field sentAt
     * Column: sent_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getSentAt(): mixed
    {
        return $this->sentAt;
    }
    
    /**
     * Sets the value of field sentAt
     * Column: sent_at 
     * Attributes: Type(4)
     * @param mixed $sentAt
     * @return void
     */
    public function setSentAt(mixed $sentAt): void
    {
        $this->sentAt = $sentAt;
    }
    
    /**
     * Returns the value of field sentBy
     * Column: sent_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getSentBy(): mixed
    {
        return $this->sentBy;
    }
    
    /**
     * Sets the value of field sentBy
     * Column: sent_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $sentBy
     * @return void
     */
    public function setSentBy(mixed $sentBy): void
    {
        $this->sentBy = $sentBy;
    }
    
    /**
     * Returns the value of field sentAs
     * Column: sent_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getSentAs(): mixed
    {
        return $this->sentAs;
    }
    
    /**
     * Sets the value of field sentAs
     * Column: sent_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $sentAs
     * @return void
     */
    public function setSentAs(mixed $sentAs): void
    {
        $this->sentAs = $sentAs;
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
        $this->hasMany('id', EmailFile::class, 'emailId', ['alias' => 'EmailFileList']);

        $this->hasManyToMany('id', EmailFile::class, 'emailId',
            'fileId', File::class, 'id', ['alias' => 'FileList']);

        $this->belongsTo('templateId', Template::class, 'id', ['alias' => 'TemplateEntity']);

        $this->belongsTo('sentBy', User::class, 'id', ['alias' => 'SentByEntity']);

        $this->belongsTo('sentAs', User::class, 'id', ['alias' => 'SentAsEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);

        $this->belongsTo('createdAs', User::class, 'id', ['alias' => 'CreatedAsEntity']);

        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);

        $this->belongsTo('updatedAs', User::class, 'id', ['alias' => 'UpdatedAsEntity']);

        $this->belongsTo('deletedBy', User::class, 'id', ['alias' => 'DeletedByEntity']);

        $this->belongsTo('deletedAs', User::class, 'id', ['alias' => 'DeletedAsEntity']);

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
        $this->addUnsignedIntValidation($validator, 'templateId', false);
        $this->addStringLengthValidation($validator, 'uuid', 0, 36, false);
        $this->addStringLengthValidation($validator, 'from', 0, 500, false);
        $this->addStringLengthValidation($validator, 'subject', 0, 255, false);
        $this->addStringLengthValidation($validator, 'viewPath', 0, 255, true);
        $this->addUnsignedIntValidation($validator, 'sent', false);
        $this->addDateTimeValidation($validator, 'sentAt', true);
        $this->addUnsignedIntValidation($validator, 'sentBy', true);
        $this->addUnsignedIntValidation($validator, 'sentAs', true);
        $this->addUnsignedIntValidation($validator, 'deleted', false);
        $this->addDateTimeValidation($validator, 'createdAt', false);
        $this->addUnsignedIntValidation($validator, 'createdBy', true);
        $this->addUnsignedIntValidation($validator, 'createdAs', true);
        $this->addDateTimeValidation($validator, 'updatedAt', true);
        $this->addUnsignedIntValidation($validator, 'updatedBy', true);
        $this->addUnsignedIntValidation($validator, 'updatedAs', true);
        $this->addDateTimeValidation($validator, 'deletedAt', true);
        $this->addUnsignedIntValidation($validator, 'deletedBy', true);
        $this->addUnsignedIntValidation($validator, 'deletedAs', true);
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
            'template_id' => 'templateId',
            'uuid' => 'uuid',
            'from' => 'from',
            'to' => 'to',
            'cc' => 'cc',
            'bcc' => 'bcc',
            'read_receipt_to' => 'readReceiptTo',
            'subject' => 'subject',
            'content' => 'content',
            'meta' => 'meta',
            'view_path' => 'viewPath',
            'sent' => 'sent',
            'sent_at' => 'sentAt',
            'sent_by' => 'sentBy',
            'sent_as' => 'sentAs',
            'deleted' => 'deleted',
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'created_as' => 'createdAs',
            'updated_at' => 'updatedAt',
            'updated_by' => 'updatedBy',
            'updated_as' => 'updatedAs',
            'deleted_at' => 'deletedAt',
            'deleted_by' => 'deletedBy',
            'deleted_as' => 'deletedAs',
            'restored_at' => 'restoredAt',
            'restored_by' => 'restoredBy',
            'restored_as' => 'restoredAs',
        ];
    }
}