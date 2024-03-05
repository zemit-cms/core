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

interface EmailAbstractInterface extends ModelInterface
{
/**
     * Returns the value of field id
     * Column: id
     * @return RawValue|int|null
     */
    public function getId(): RawValue|int|null;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param RawValue|int|null $id
     * @return void
     */
    public function setId(RawValue|int|null $id): void;
    
    /**
     * Returns the value of field templateId
     * Column: template_id
     * @return RawValue|int
     */
    public function getTemplateId(): RawValue|int;
    
    /**
     * Sets the value of field templateId
     * Column: template_id 
     * @param RawValue|int $templateId
     * @return void
     */
    public function setTemplateId(RawValue|int $templateId): void;
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * @return RawValue|string
     */
    public function getUuid(): RawValue|string;
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * @param RawValue|string $uuid
     * @return void
     */
    public function setUuid(RawValue|string $uuid): void;
    
    /**
     * Returns the value of field from
     * Column: from
     * @return RawValue|string
     */
    public function getFrom(): RawValue|string;
    
    /**
     * Sets the value of field from
     * Column: from 
     * @param RawValue|string $from
     * @return void
     */
    public function setFrom(RawValue|string $from): void;
    
    /**
     * Returns the value of field to
     * Column: to
     * @return RawValue|string
     */
    public function getTo(): RawValue|string;
    
    /**
     * Sets the value of field to
     * Column: to 
     * @param RawValue|string $to
     * @return void
     */
    public function setTo(RawValue|string $to): void;
    
    /**
     * Returns the value of field cc
     * Column: cc
     * @return RawValue|string|null
     */
    public function getCc(): RawValue|string|null;
    
    /**
     * Sets the value of field cc
     * Column: cc 
     * @param RawValue|string|null $cc
     * @return void
     */
    public function setCc(RawValue|string|null $cc): void;
    
    /**
     * Returns the value of field bcc
     * Column: bcc
     * @return RawValue|string|null
     */
    public function getBcc(): RawValue|string|null;
    
    /**
     * Sets the value of field bcc
     * Column: bcc 
     * @param RawValue|string|null $bcc
     * @return void
     */
    public function setBcc(RawValue|string|null $bcc): void;
    
    /**
     * Returns the value of field readReceiptTo
     * Column: read_receipt_to
     * @return RawValue|string|null
     */
    public function getReadReceiptTo(): RawValue|string|null;
    
    /**
     * Sets the value of field readReceiptTo
     * Column: read_receipt_to 
     * @param RawValue|string|null $readReceiptTo
     * @return void
     */
    public function setReadReceiptTo(RawValue|string|null $readReceiptTo): void;
    
    /**
     * Returns the value of field subject
     * Column: subject
     * @return RawValue|string
     */
    public function getSubject(): RawValue|string;
    
    /**
     * Sets the value of field subject
     * Column: subject 
     * @param RawValue|string $subject
     * @return void
     */
    public function setSubject(RawValue|string $subject): void;
    
    /**
     * Returns the value of field content
     * Column: content
     * @return RawValue|string
     */
    public function getContent(): RawValue|string;
    
    /**
     * Sets the value of field content
     * Column: content 
     * @param RawValue|string $content
     * @return void
     */
    public function setContent(RawValue|string $content): void;
    
    /**
     * Returns the value of field meta
     * Column: meta
     * @return RawValue|string|null
     */
    public function getMeta(): RawValue|string|null;
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * @param RawValue|string|null $meta
     * @return void
     */
    public function setMeta(RawValue|string|null $meta): void;
    
    /**
     * Returns the value of field viewPath
     * Column: view_path
     * @return RawValue|string|null
     */
    public function getViewPath(): RawValue|string|null;
    
    /**
     * Sets the value of field viewPath
     * Column: view_path 
     * @param RawValue|string|null $viewPath
     * @return void
     */
    public function setViewPath(RawValue|string|null $viewPath): void;
    
    /**
     * Returns the value of field sent
     * Column: sent
     * @return RawValue|int
     */
    public function getSent(): RawValue|int;
    
    /**
     * Sets the value of field sent
     * Column: sent 
     * @param RawValue|int $sent
     * @return void
     */
    public function setSent(RawValue|int $sent): void;
    
    /**
     * Returns the value of field sentAt
     * Column: sent_at
     * @return RawValue|string|null
     */
    public function getSentAt(): RawValue|string|null;
    
    /**
     * Sets the value of field sentAt
     * Column: sent_at 
     * @param RawValue|string|null $sentAt
     * @return void
     */
    public function setSentAt(RawValue|string|null $sentAt): void;
    
    /**
     * Returns the value of field sentBy
     * Column: sent_by
     * @return RawValue|int|null
     */
    public function getSentBy(): RawValue|int|null;
    
    /**
     * Sets the value of field sentBy
     * Column: sent_by 
     * @param RawValue|int|null $sentBy
     * @return void
     */
    public function setSentBy(RawValue|int|null $sentBy): void;
    
    /**
     * Returns the value of field sentAs
     * Column: sent_as
     * @return RawValue|int|null
     */
    public function getSentAs(): RawValue|int|null;
    
    /**
     * Sets the value of field sentAs
     * Column: sent_as 
     * @param RawValue|int|null $sentAs
     * @return void
     */
    public function setSentAs(RawValue|int|null $sentAs): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return RawValue|int
     */
    public function getDeleted(): RawValue|int;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param RawValue|int $deleted
     * @return void
     */
    public function setDeleted(RawValue|int $deleted): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return RawValue|string
     */
    public function getCreatedAt(): RawValue|string;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param RawValue|string $createdAt
     * @return void
     */
    public function setCreatedAt(RawValue|string $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return RawValue|int|null
     */
    public function getCreatedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param RawValue|int|null $createdBy
     * @return void
     */
    public function setCreatedBy(RawValue|int|null $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return RawValue|int|null
     */
    public function getCreatedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param RawValue|int|null $createdAs
     * @return void
     */
    public function setCreatedAs(RawValue|int|null $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return RawValue|string|null
     */
    public function getUpdatedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param RawValue|string|null $updatedAt
     * @return void
     */
    public function setUpdatedAt(RawValue|string|null $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return RawValue|int|null
     */
    public function getUpdatedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param RawValue|int|null $updatedBy
     * @return void
     */
    public function setUpdatedBy(RawValue|int|null $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return RawValue|int|null
     */
    public function getUpdatedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param RawValue|int|null $updatedAs
     * @return void
     */
    public function setUpdatedAs(RawValue|int|null $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return RawValue|string|null
     */
    public function getDeletedAt(): RawValue|string|null;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param RawValue|string|null $deletedAt
     * @return void
     */
    public function setDeletedAt(RawValue|string|null $deletedAt): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return RawValue|int|null
     */
    public function getDeletedBy(): RawValue|int|null;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param RawValue|int|null $deletedBy
     * @return void
     */
    public function setDeletedBy(RawValue|int|null $deletedBy): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return RawValue|int|null
     */
    public function getDeletedAs(): RawValue|int|null;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param RawValue|int|null $deletedAs
     * @return void
     */
    public function setDeletedAs(RawValue|int|null $deletedAs): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return RawValue|string|null
     */
    public function getRestoredAt(): RawValue|string|null;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param RawValue|string|null $restoredAt
     * @return void
     */
    public function setRestoredAt(RawValue|string|null $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return RawValue|int|null
     */
    public function getRestoredBy(): RawValue|int|null;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param RawValue|int|null $restoredBy
     * @return void
     */
    public function setRestoredBy(RawValue|int|null $restoredBy): void;
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return RawValue|int|null
     */
    public function getRestoredAs(): RawValue|int|null;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param RawValue|int|null $restoredAs
     * @return void
     */
    public function setRestoredAs(RawValue|int|null $restoredAs): void;
}