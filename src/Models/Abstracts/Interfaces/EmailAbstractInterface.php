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
 * @property FileAbstractInterface[] $filelist
 * @property FileAbstractInterface[] $FileList
 * @method FileAbstractInterface[] getFileList(?array $params = null)
 *
 * @property TemplateAbstractInterface $templateentity
 * @property TemplateAbstractInterface $TemplateEntity
 * @method TemplateAbstractInterface getTemplateEntity(?array $params = null)
 *
 * @property UserAbstractInterface $sentbyentity
 * @property UserAbstractInterface $SentByEntity
 * @method UserAbstractInterface getSentByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $sentasentity
 * @property UserAbstractInterface $SentAsEntity
 * @method UserAbstractInterface getSentAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdbyentity
 * @property UserAbstractInterface $CreatedByEntity
 * @method UserAbstractInterface getCreatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $createdasentity
 * @property UserAbstractInterface $CreatedAsEntity
 * @method UserAbstractInterface getCreatedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $updatedbyentity
 * @property UserAbstractInterface $UpdatedByEntity
 * @method UserAbstractInterface getUpdatedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $updatedasentity
 * @property UserAbstractInterface $UpdatedAsEntity
 * @method UserAbstractInterface getUpdatedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $deletedbyentity
 * @property UserAbstractInterface $DeletedByEntity
 * @method UserAbstractInterface getDeletedByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $deletedasentity
 * @property UserAbstractInterface $DeletedAsEntity
 * @method UserAbstractInterface getDeletedAsEntity(?array $params = null)
 *
 * @property UserAbstractInterface $restoredbyentity
 * @property UserAbstractInterface $RestoredByEntity
 * @method UserAbstractInterface getRestoredByEntity(?array $params = null)
 *
 * @property UserAbstractInterface $restoredasentity
 * @property UserAbstractInterface $RestoredAsEntity
 * @method UserAbstractInterface getRestoredAsEntity(?array $params = null)
 */
interface EmailAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId(): mixed;
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId(mixed $id): void;
    
    /**
     * Returns the value of field templateId
     * Column: template_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getTemplateId(): mixed;
    
    /**
     * Sets the value of field templateId
     * Column: template_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $templateId
     * @return void
     */
    public function setTemplateId(mixed $templateId): void;
    
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
     * Returns the value of field from
     * Column: from
     * Attributes: NotNull | Size(500) | Type(2)
     * @return mixed
     */
    public function getFrom(): mixed;
    
    /**
     * Sets the value of field from
     * Column: from 
     * Attributes: NotNull | Size(500) | Type(2)
     * @param mixed $from
     * @return void
     */
    public function setFrom(mixed $from): void;
    
    /**
     * Returns the value of field to
     * Column: to
     * Attributes: NotNull | Type(6)
     * @return mixed
     */
    public function getTo(): mixed;
    
    /**
     * Sets the value of field to
     * Column: to 
     * Attributes: NotNull | Type(6)
     * @param mixed $to
     * @return void
     */
    public function setTo(mixed $to): void;
    
    /**
     * Returns the value of field cc
     * Column: cc
     * Attributes: Type(6)
     * @return mixed
     */
    public function getCc(): mixed;
    
    /**
     * Sets the value of field cc
     * Column: cc 
     * Attributes: Type(6)
     * @param mixed $cc
     * @return void
     */
    public function setCc(mixed $cc): void;
    
    /**
     * Returns the value of field bcc
     * Column: bcc
     * Attributes: Type(6)
     * @return mixed
     */
    public function getBcc(): mixed;
    
    /**
     * Sets the value of field bcc
     * Column: bcc 
     * Attributes: Type(6)
     * @param mixed $bcc
     * @return void
     */
    public function setBcc(mixed $bcc): void;
    
    /**
     * Returns the value of field readReceiptTo
     * Column: read_receipt_to
     * Attributes: Type(6)
     * @return mixed
     */
    public function getReadReceiptTo(): mixed;
    
    /**
     * Sets the value of field readReceiptTo
     * Column: read_receipt_to 
     * Attributes: Type(6)
     * @param mixed $readReceiptTo
     * @return void
     */
    public function setReadReceiptTo(mixed $readReceiptTo): void;
    
    /**
     * Returns the value of field subject
     * Column: subject
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getSubject(): mixed;
    
    /**
     * Sets the value of field subject
     * Column: subject 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $subject
     * @return void
     */
    public function setSubject(mixed $subject): void;
    
    /**
     * Returns the value of field content
     * Column: content
     * Attributes: NotNull | Type(23)
     * @return mixed
     */
    public function getContent(): mixed;
    
    /**
     * Sets the value of field content
     * Column: content 
     * Attributes: NotNull | Type(23)
     * @param mixed $content
     * @return void
     */
    public function setContent(mixed $content): void;
    
    /**
     * Returns the value of field meta
     * Column: meta
     * Attributes: Type(23)
     * @return mixed
     */
    public function getMeta(): mixed;
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * Attributes: Type(23)
     * @param mixed $meta
     * @return void
     */
    public function setMeta(mixed $meta): void;
    
    /**
     * Returns the value of field viewPath
     * Column: view_path
     * Attributes: Size(255) | Type(2)
     * @return mixed
     */
    public function getViewPath(): mixed;
    
    /**
     * Sets the value of field viewPath
     * Column: view_path 
     * Attributes: Size(255) | Type(2)
     * @param mixed $viewPath
     * @return void
     */
    public function setViewPath(mixed $viewPath): void;
    
    /**
     * Returns the value of field sent
     * Column: sent
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getSent(): mixed;
    
    /**
     * Sets the value of field sent
     * Column: sent 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $sent
     * @return void
     */
    public function setSent(mixed $sent): void;
    
    /**
     * Returns the value of field sentAt
     * Column: sent_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getSentAt(): mixed;
    
    /**
     * Sets the value of field sentAt
     * Column: sent_at 
     * Attributes: Type(4)
     * @param mixed $sentAt
     * @return void
     */
    public function setSentAt(mixed $sentAt): void;
    
    /**
     * Returns the value of field sentBy
     * Column: sent_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getSentBy(): mixed;
    
    /**
     * Sets the value of field sentBy
     * Column: sent_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $sentBy
     * @return void
     */
    public function setSentBy(mixed $sentBy): void;
    
    /**
     * Returns the value of field sentAs
     * Column: sent_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getSentAs(): mixed;
    
    /**
     * Sets the value of field sentAs
     * Column: sent_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $sentAs
     * @return void
     */
    public function setSentAs(mixed $sentAs): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted(): mixed;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
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
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy(): mixed;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy(mixed $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs(): mixed;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs(mixed $createdAs): void;
    
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
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy(): mixed;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy(mixed $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs(): mixed;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs(mixed $updatedAs): void;
    
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
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy(): mixed;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy(mixed $deletedBy): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs(): mixed;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs(mixed $deletedAs): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt(): mixed;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt(mixed $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy(): mixed;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy(mixed $restoredBy): void;
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs(): mixed;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs(mixed $restoredAs): void;
}