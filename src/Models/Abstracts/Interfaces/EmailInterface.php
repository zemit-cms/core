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

use Zemit\Mvc\ModelInterface;

interface EmailInterface extends ModelInterface
{
/**
     * Returns the value of field id
     * Column: id
     * @return ?int
     */
    public function getId(): ?int;
    
    /**
     * Sets the value of field id
     * Column: id 
     * @param ?int $id
     * @return void
     */
    public function setId(?int $id): void;
    
    /**
     * Returns the value of field templateId
     * Column: template_id
     * @return int
     */
    public function getTemplateId(): int;
    
    /**
     * Sets the value of field templateId
     * Column: template_id 
     * @param int $templateId
     * @return void
     */
    public function setTemplateId(int $templateId): void;
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * @return string
     */
    public function getUuid(): string;
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * @param string $uuid
     * @return void
     */
    public function setUuid(string $uuid): void;
    
    /**
     * Returns the value of field from
     * Column: from
     * @return string
     */
    public function getFrom(): string;
    
    /**
     * Sets the value of field from
     * Column: from 
     * @param string $from
     * @return void
     */
    public function setFrom(string $from): void;
    
    /**
     * Returns the value of field to
     * Column: to
     * @return string
     */
    public function getTo(): string;
    
    /**
     * Sets the value of field to
     * Column: to 
     * @param string $to
     * @return void
     */
    public function setTo(string $to): void;
    
    /**
     * Returns the value of field cc
     * Column: cc
     * @return ?string
     */
    public function getCc(): ?string;
    
    /**
     * Sets the value of field cc
     * Column: cc 
     * @param ?string $cc
     * @return void
     */
    public function setCc(?string $cc): void;
    
    /**
     * Returns the value of field bcc
     * Column: bcc
     * @return ?string
     */
    public function getBcc(): ?string;
    
    /**
     * Sets the value of field bcc
     * Column: bcc 
     * @param ?string $bcc
     * @return void
     */
    public function setBcc(?string $bcc): void;
    
    /**
     * Returns the value of field readReceiptTo
     * Column: read_receipt_to
     * @return ?string
     */
    public function getReadReceiptTo(): ?string;
    
    /**
     * Sets the value of field readReceiptTo
     * Column: read_receipt_to 
     * @param ?string $readReceiptTo
     * @return void
     */
    public function setReadReceiptTo(?string $readReceiptTo): void;
    
    /**
     * Returns the value of field subject
     * Column: subject
     * @return string
     */
    public function getSubject(): string;
    
    /**
     * Sets the value of field subject
     * Column: subject 
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject): void;
    
    /**
     * Returns the value of field content
     * Column: content
     * @return string
     */
    public function getContent(): string;
    
    /**
     * Sets the value of field content
     * Column: content 
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void;
    
    /**
     * Returns the value of field meta
     * Column: meta
     * @return ?string
     */
    public function getMeta(): ?string;
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * @param ?string $meta
     * @return void
     */
    public function setMeta(?string $meta): void;
    
    /**
     * Returns the value of field viewPath
     * Column: view_path
     * @return ?string
     */
    public function getViewPath(): ?string;
    
    /**
     * Sets the value of field viewPath
     * Column: view_path 
     * @param ?string $viewPath
     * @return void
     */
    public function setViewPath(?string $viewPath): void;
    
    /**
     * Returns the value of field sent
     * Column: sent
     * @return int
     */
    public function getSent(): int;
    
    /**
     * Sets the value of field sent
     * Column: sent 
     * @param int $sent
     * @return void
     */
    public function setSent(int $sent): void;
    
    /**
     * Returns the value of field sentAt
     * Column: sent_at
     * @return ?string
     */
    public function getSentAt(): ?string;
    
    /**
     * Sets the value of field sentAt
     * Column: sent_at 
     * @param ?string $sentAt
     * @return void
     */
    public function setSentAt(?string $sentAt): void;
    
    /**
     * Returns the value of field sentBy
     * Column: sent_by
     * @return ?int
     */
    public function getSentBy(): ?int;
    
    /**
     * Sets the value of field sentBy
     * Column: sent_by 
     * @param ?int $sentBy
     * @return void
     */
    public function setSentBy(?int $sentBy): void;
    
    /**
     * Returns the value of field sentAs
     * Column: sent_as
     * @return ?int
     */
    public function getSentAs(): ?int;
    
    /**
     * Sets the value of field sentAs
     * Column: sent_as 
     * @param ?int $sentAs
     * @return void
     */
    public function setSentAs(?int $sentAs): void;
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * @return int
     */
    public function getDeleted(): int;
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * @param int $deleted
     * @return void
     */
    public function setDeleted(int $deleted): void;
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * @return string
     */
    public function getCreatedAt(): string;
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * @return ?int
     */
    public function getCreatedBy(): ?int;
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * @param ?int $createdBy
     * @return void
     */
    public function setCreatedBy(?int $createdBy): void;
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * @return ?int
     */
    public function getCreatedAs(): ?int;
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * @param ?int $createdAs
     * @return void
     */
    public function setCreatedAs(?int $createdAs): void;
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * @return ?string
     */
    public function getUpdatedAt(): ?string;
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * @param ?string $updatedAt
     * @return void
     */
    public function setUpdatedAt(?string $updatedAt): void;
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * @return ?int
     */
    public function getUpdatedBy(): ?int;
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * @param ?int $updatedBy
     * @return void
     */
    public function setUpdatedBy(?int $updatedBy): void;
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * @return ?int
     */
    public function getUpdatedAs(): ?int;
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * @param ?int $updatedAs
     * @return void
     */
    public function setUpdatedAs(?int $updatedAs): void;
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * @return ?string
     */
    public function getDeletedAt(): ?string;
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * @param ?string $deletedAt
     * @return void
     */
    public function setDeletedAt(?string $deletedAt): void;
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * @return ?int
     */
    public function getDeletedBy(): ?int;
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * @param ?int $deletedBy
     * @return void
     */
    public function setDeletedBy(?int $deletedBy): void;
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * @return ?int
     */
    public function getDeletedAs(): ?int;
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * @param ?int $deletedAs
     * @return void
     */
    public function setDeletedAs(?int $deletedAs): void;
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * @return ?string
     */
    public function getRestoredAt(): ?string;
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * @param ?string $restoredAt
     * @return void
     */
    public function setRestoredAt(?string $restoredAt): void;
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * @return ?int
     */
    public function getRestoredBy(): ?int;
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * @param ?int $restoredBy
     * @return void
     */
    public function setRestoredBy(?int $restoredBy): void;
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * @return ?int
     */
    public function getRestoredAs(): ?int;
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * @param ?int $restoredAs
     * @return void
     */
    public function setRestoredAs(?int $restoredAs): void;
}