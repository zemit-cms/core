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
use Zemit\Models\Abstracts\Interfaces\EmailAbstractInterface;

/**
 * Class EmailAbstract
 *
 * This class defines a Email abstract model that extends the AbstractModel class and implements the EmailAbstractInterface.
 * It provides properties and methods for managing Email data.
 * 
 * @property EmailFile[] $EmailFileList
 * @method EmailFile[] getEmailFileList(?array $params = null)
 *
 * @property File[] $FileList
 * @method File[] getFileList(?array $params = null)
 *
 * @property Template $TemplateEntity
 * @method Template getTemplateEntity(?array $params = null)
 */
class EmailAbstract extends AbstractModel implements EmailAbstractInterface
{
    /**
     * Column: id
     * @var RawValue|int|null
     */
    public RawValue|int|null $id = null;
    
    /**
     * Column: template_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $templateId = null;
    
    /**
     * Column: uuid
     * @var RawValue|string|null
     */
    public RawValue|string|null $uuid = null;
    
    /**
     * Column: from
     * @var RawValue|string|null
     */
    public RawValue|string|null $from = null;
    
    /**
     * Column: to
     * @var RawValue|string|null
     */
    public RawValue|string|null $to = null;
    
    /**
     * Column: cc
     * @var RawValue|string|null
     */
    public RawValue|string|null $cc = null;
    
    /**
     * Column: bcc
     * @var RawValue|string|null
     */
    public RawValue|string|null $bcc = null;
    
    /**
     * Column: read_receipt_to
     * @var RawValue|string|null
     */
    public RawValue|string|null $readReceiptTo = null;
    
    /**
     * Column: subject
     * @var RawValue|string|null
     */
    public RawValue|string|null $subject = null;
    
    /**
     * Column: content
     * @var RawValue|string|null
     */
    public RawValue|string|null $content = null;
    
    /**
     * Column: meta
     * @var RawValue|string|null
     */
    public RawValue|string|null $meta = null;
    
    /**
     * Column: view_path
     * @var RawValue|string|null
     */
    public RawValue|string|null $viewPath = null;
    
    /**
     * Column: sent
     * @var RawValue|int
     */
    public RawValue|int $sent = 0;
    
    /**
     * Column: sent_at
     * @var RawValue|string|null
     */
    public RawValue|string|null $sentAt = null;
    
    /**
     * Column: sent_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $sentBy = null;
    
    /**
     * Column: sent_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $sentAs = null;
    
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
     * Column: deleted_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedBy = null;
    
    /**
     * Column: deleted_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedAs = null;
    
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
     * Returns the value of field templateId
     * Column: template_id
     * @return RawValue|int|null
     */
    public function getTemplateId(): RawValue|int|null
    {
        return $this->templateId;
    }
    
    /**
     * Sets the value of field templateId
     * Column: template_id 
     * @param RawValue|int|null $templateId
     * @return void
     */
    public function setTemplateId(RawValue|int|null $templateId): void
    {
        $this->templateId = $templateId;
    }
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * @return RawValue|string|null
     */
    public function getUuid(): RawValue|string|null
    {
        return $this->uuid;
    }
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * @param RawValue|string|null $uuid
     * @return void
     */
    public function setUuid(RawValue|string|null $uuid): void
    {
        $this->uuid = $uuid;
    }
    
    /**
     * Returns the value of field from
     * Column: from
     * @return RawValue|string|null
     */
    public function getFrom(): RawValue|string|null
    {
        return $this->from;
    }
    
    /**
     * Sets the value of field from
     * Column: from 
     * @param RawValue|string|null $from
     * @return void
     */
    public function setFrom(RawValue|string|null $from): void
    {
        $this->from = $from;
    }
    
    /**
     * Returns the value of field to
     * Column: to
     * @return RawValue|string|null
     */
    public function getTo(): RawValue|string|null
    {
        return $this->to;
    }
    
    /**
     * Sets the value of field to
     * Column: to 
     * @param RawValue|string|null $to
     * @return void
     */
    public function setTo(RawValue|string|null $to): void
    {
        $this->to = $to;
    }
    
    /**
     * Returns the value of field cc
     * Column: cc
     * @return RawValue|string|null
     */
    public function getCc(): RawValue|string|null
    {
        return $this->cc;
    }
    
    /**
     * Sets the value of field cc
     * Column: cc 
     * @param RawValue|string|null $cc
     * @return void
     */
    public function setCc(RawValue|string|null $cc): void
    {
        $this->cc = $cc;
    }
    
    /**
     * Returns the value of field bcc
     * Column: bcc
     * @return RawValue|string|null
     */
    public function getBcc(): RawValue|string|null
    {
        return $this->bcc;
    }
    
    /**
     * Sets the value of field bcc
     * Column: bcc 
     * @param RawValue|string|null $bcc
     * @return void
     */
    public function setBcc(RawValue|string|null $bcc): void
    {
        $this->bcc = $bcc;
    }
    
    /**
     * Returns the value of field readReceiptTo
     * Column: read_receipt_to
     * @return RawValue|string|null
     */
    public function getReadReceiptTo(): RawValue|string|null
    {
        return $this->readReceiptTo;
    }
    
    /**
     * Sets the value of field readReceiptTo
     * Column: read_receipt_to 
     * @param RawValue|string|null $readReceiptTo
     * @return void
     */
    public function setReadReceiptTo(RawValue|string|null $readReceiptTo): void
    {
        $this->readReceiptTo = $readReceiptTo;
    }
    
    /**
     * Returns the value of field subject
     * Column: subject
     * @return RawValue|string|null
     */
    public function getSubject(): RawValue|string|null
    {
        return $this->subject;
    }
    
    /**
     * Sets the value of field subject
     * Column: subject 
     * @param RawValue|string|null $subject
     * @return void
     */
    public function setSubject(RawValue|string|null $subject): void
    {
        $this->subject = $subject;
    }
    
    /**
     * Returns the value of field content
     * Column: content
     * @return RawValue|string|null
     */
    public function getContent(): RawValue|string|null
    {
        return $this->content;
    }
    
    /**
     * Sets the value of field content
     * Column: content 
     * @param RawValue|string|null $content
     * @return void
     */
    public function setContent(RawValue|string|null $content): void
    {
        $this->content = $content;
    }
    
    /**
     * Returns the value of field meta
     * Column: meta
     * @return RawValue|string|null
     */
    public function getMeta(): RawValue|string|null
    {
        return $this->meta;
    }
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * @param RawValue|string|null $meta
     * @return void
     */
    public function setMeta(RawValue|string|null $meta): void
    {
        $this->meta = $meta;
    }
    
    /**
     * Returns the value of field viewPath
     * Column: view_path
     * @return RawValue|string|null
     */
    public function getViewPath(): RawValue|string|null
    {
        return $this->viewPath;
    }
    
    /**
     * Sets the value of field viewPath
     * Column: view_path 
     * @param RawValue|string|null $viewPath
     * @return void
     */
    public function setViewPath(RawValue|string|null $viewPath): void
    {
        $this->viewPath = $viewPath;
    }
    
    /**
     * Returns the value of field sent
     * Column: sent
     * @return RawValue|int
     */
    public function getSent(): RawValue|int
    {
        return $this->sent;
    }
    
    /**
     * Sets the value of field sent
     * Column: sent 
     * @param RawValue|int $sent
     * @return void
     */
    public function setSent(RawValue|int $sent): void
    {
        $this->sent = $sent;
    }
    
    /**
     * Returns the value of field sentAt
     * Column: sent_at
     * @return RawValue|string|null
     */
    public function getSentAt(): RawValue|string|null
    {
        return $this->sentAt;
    }
    
    /**
     * Sets the value of field sentAt
     * Column: sent_at 
     * @param RawValue|string|null $sentAt
     * @return void
     */
    public function setSentAt(RawValue|string|null $sentAt): void
    {
        $this->sentAt = $sentAt;
    }
    
    /**
     * Returns the value of field sentBy
     * Column: sent_by
     * @return RawValue|int|null
     */
    public function getSentBy(): RawValue|int|null
    {
        return $this->sentBy;
    }
    
    /**
     * Sets the value of field sentBy
     * Column: sent_by 
     * @param RawValue|int|null $sentBy
     * @return void
     */
    public function setSentBy(RawValue|int|null $sentBy): void
    {
        $this->sentBy = $sentBy;
    }
    
    /**
     * Returns the value of field sentAs
     * Column: sent_as
     * @return RawValue|int|null
     */
    public function getSentAs(): RawValue|int|null
    {
        return $this->sentAs;
    }
    
    /**
     * Sets the value of field sentAs
     * Column: sent_as 
     * @param RawValue|int|null $sentAs
     * @return void
     */
    public function setSentAs(RawValue|int|null $sentAs): void
    {
        $this->sentAs = $sentAs;
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
        $this->hasMany('id', EmailFile::class, 'emailId', ['alias' => 'EmailFileList']);

        $this->hasManyToMany('id', EmailFile::class, 'emailId',
            'fileId', File::class, 'id', ['alias' => 'FileList']);

        $this->belongsTo('templateId', Template::class, 'id', ['alias' => 'TemplateEntity']);
    }
    
    /**
     * Adds the default validations to the model.
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