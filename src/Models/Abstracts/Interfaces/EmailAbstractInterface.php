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
 */
interface EmailAbstractInterface extends ModelInterface
{
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId();
    
    /**
     * Sets the value of field id
     * Column: id 
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @param mixed $id
     * @return void
     */
    public function setId($id);
    
    /**
     * Returns the value of field templateId
     * Column: template_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getTemplateId();
    
    /**
     * Sets the value of field templateId
     * Column: template_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $templateId
     * @return void
     */
    public function setTemplateId($templateId);
    
    /**
     * Returns the value of field uuid
     * Column: uuid
     * Attributes: NotNull | Size(36) | Type(5)
     * @return mixed
     */
    public function getUuid();
    
    /**
     * Sets the value of field uuid
     * Column: uuid 
     * Attributes: NotNull | Size(36) | Type(5)
     * @param mixed $uuid
     * @return void
     */
    public function setUuid($uuid);
    
    /**
     * Returns the value of field from
     * Column: from
     * Attributes: NotNull | Size(500) | Type(2)
     * @return mixed
     */
    public function getFrom();
    
    /**
     * Sets the value of field from
     * Column: from 
     * Attributes: NotNull | Size(500) | Type(2)
     * @param mixed $from
     * @return void
     */
    public function setFrom($from);
    
    /**
     * Returns the value of field to
     * Column: to
     * Attributes: NotNull | Type(6)
     * @return mixed
     */
    public function getTo();
    
    /**
     * Sets the value of field to
     * Column: to 
     * Attributes: NotNull | Type(6)
     * @param mixed $to
     * @return void
     */
    public function setTo($to);
    
    /**
     * Returns the value of field cc
     * Column: cc
     * Attributes: Type(6)
     * @return mixed
     */
    public function getCc();
    
    /**
     * Sets the value of field cc
     * Column: cc 
     * Attributes: Type(6)
     * @param mixed $cc
     * @return void
     */
    public function setCc($cc);
    
    /**
     * Returns the value of field bcc
     * Column: bcc
     * Attributes: Type(6)
     * @return mixed
     */
    public function getBcc();
    
    /**
     * Sets the value of field bcc
     * Column: bcc 
     * Attributes: Type(6)
     * @param mixed $bcc
     * @return void
     */
    public function setBcc($bcc);
    
    /**
     * Returns the value of field readReceiptTo
     * Column: read_receipt_to
     * Attributes: Type(6)
     * @return mixed
     */
    public function getReadReceiptTo();
    
    /**
     * Sets the value of field readReceiptTo
     * Column: read_receipt_to 
     * Attributes: Type(6)
     * @param mixed $readReceiptTo
     * @return void
     */
    public function setReadReceiptTo($readReceiptTo);
    
    /**
     * Returns the value of field subject
     * Column: subject
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getSubject();
    
    /**
     * Sets the value of field subject
     * Column: subject 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $subject
     * @return void
     */
    public function setSubject($subject);
    
    /**
     * Returns the value of field content
     * Column: content
     * Attributes: NotNull | Type(23)
     * @return mixed
     */
    public function getContent();
    
    /**
     * Sets the value of field content
     * Column: content 
     * Attributes: NotNull | Type(23)
     * @param mixed $content
     * @return void
     */
    public function setContent($content);
    
    /**
     * Returns the value of field meta
     * Column: meta
     * Attributes: Type(23)
     * @return mixed
     */
    public function getMeta();
    
    /**
     * Sets the value of field meta
     * Column: meta 
     * Attributes: Type(23)
     * @param mixed $meta
     * @return void
     */
    public function setMeta($meta);
    
    /**
     * Returns the value of field viewPath
     * Column: view_path
     * Attributes: Size(255) | Type(2)
     * @return mixed
     */
    public function getViewPath();
    
    /**
     * Sets the value of field viewPath
     * Column: view_path 
     * Attributes: Size(255) | Type(2)
     * @param mixed $viewPath
     * @return void
     */
    public function setViewPath($viewPath);
    
    /**
     * Returns the value of field sent
     * Column: sent
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getSent();
    
    /**
     * Sets the value of field sent
     * Column: sent 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $sent
     * @return void
     */
    public function setSent($sent);
    
    /**
     * Returns the value of field sentAt
     * Column: sent_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getSentAt();
    
    /**
     * Sets the value of field sentAt
     * Column: sent_at 
     * Attributes: Type(4)
     * @param mixed $sentAt
     * @return void
     */
    public function setSentAt($sentAt);
    
    /**
     * Returns the value of field sentBy
     * Column: sent_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getSentBy();
    
    /**
     * Sets the value of field sentBy
     * Column: sent_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $sentBy
     * @return void
     */
    public function setSentBy($sentBy);
    
    /**
     * Returns the value of field sentAs
     * Column: sent_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getSentAs();
    
    /**
     * Sets the value of field sentAs
     * Column: sent_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $sentAs
     * @return void
     */
    public function setSentAs($sentAs);
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted();
    
    /**
     * Sets the value of field deleted
     * Column: deleted 
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @param mixed $deleted
     * @return void
     */
    public function setDeleted($deleted);
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt();
    
    /**
     * Sets the value of field createdAt
     * Column: created_at 
     * Attributes: NotNull | Type(4)
     * @param mixed $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt);
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy();
    
    /**
     * Sets the value of field createdBy
     * Column: created_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdBy
     * @return void
     */
    public function setCreatedBy($createdBy);
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs();
    
    /**
     * Sets the value of field createdAs
     * Column: created_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $createdAs
     * @return void
     */
    public function setCreatedAs($createdAs);
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt();
    
    /**
     * Sets the value of field updatedAt
     * Column: updated_at 
     * Attributes: Type(4)
     * @param mixed $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt);
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy();
    
    /**
     * Sets the value of field updatedBy
     * Column: updated_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedBy
     * @return void
     */
    public function setUpdatedBy($updatedBy);
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs();
    
    /**
     * Sets the value of field updatedAs
     * Column: updated_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $updatedAs
     * @return void
     */
    public function setUpdatedAs($updatedAs);
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt();
    
    /**
     * Sets the value of field deletedAt
     * Column: deleted_at 
     * Attributes: Type(4)
     * @param mixed $deletedAt
     * @return void
     */
    public function setDeletedAt($deletedAt);
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy();
    
    /**
     * Sets the value of field deletedBy
     * Column: deleted_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedBy
     * @return void
     */
    public function setDeletedBy($deletedBy);
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs();
    
    /**
     * Sets the value of field deletedAs
     * Column: deleted_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $deletedAs
     * @return void
     */
    public function setDeletedAs($deletedAs);
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt();
    
    /**
     * Sets the value of field restoredAt
     * Column: restored_at 
     * Attributes: Type(4)
     * @param mixed $restoredAt
     * @return void
     */
    public function setRestoredAt($restoredAt);
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy();
    
    /**
     * Sets the value of field restoredBy
     * Column: restored_by 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredBy
     * @return void
     */
    public function setRestoredBy($restoredBy);
    
    /**
     * Returns the value of field restoredAs
     * Column: restored_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredAs();
    
    /**
     * Sets the value of field restoredAs
     * Column: restored_as 
     * Attributes: Numeric | Unsigned
     * @param mixed $restoredAs
     * @return void
     */
    public function setRestoredAs($restoredAs);
}