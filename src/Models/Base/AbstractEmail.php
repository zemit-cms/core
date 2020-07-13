<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * --------------------------------------------------------------
 *
 * New BSD License
 *
 * Copyright (c) 2017-present, Zemit CMS Team
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Zemit nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL ZEMIT FRAMEWORK TEAM BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Zemit\Models\Base;

/**
 * AbstractEmail
 * 
 * @package Zemit\Models\Base
 * @autogenerated by Phalcon Developer Tools
 * @date 2020-07-12, 19:33:59
 */
abstract class AbstractEmail extends \Zemit\Models\Base
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=10, nullable=false)
     */
    protected $id;

    /**
     *
     * @var integer
     * @Column(column="template_id", type="integer", length=10, nullable=false)
     */
    protected $templateId;

    /**
     *
     * @var string
     * @Column(column="from", type="string", length=500, nullable=false)
     */
    protected $from;

    /**
     *
     * @var string
     * @Column(column="to", type="string", nullable=false)
     */
    protected $to;

    /**
     *
     * @var string
     * @Column(column="cc", type="string", nullable=true)
     */
    protected $cc;

    /**
     *
     * @var string
     * @Column(column="bcc", type="string", nullable=true)
     */
    protected $bcc;

    /**
     *
     * @var string
     * @Column(column="read_receipt_to", type="string", nullable=true)
     */
    protected $readReceiptTo;

    /**
     *
     * @var string
     * @Column(column="subject", type="string", length=255, nullable=false)
     */
    protected $subject;

    /**
     *
     * @var string
     * @Column(column="content", type="string", nullable=false)
     */
    protected $content;

    /**
     *
     * @var string
     * @Column(column="meta", type="string", nullable=true)
     */
    protected $meta;

    /**
     *
     * @var string
     * @Column(column="view_path", type="string", length=255, nullable=true)
     */
    protected $viewPath;

    /**
     *
     * @var string
     * @Column(column="sent", type="string", length=1, nullable=false)
     */
    protected $sent;

    /**
     *
     * @var string
     * @Column(column="sent_at", type="string", nullable=true)
     */
    protected $sentAt;

    /**
     *
     * @var integer
     * @Column(column="sent_by", type="integer", length=10, nullable=true)
     */
    protected $sentBy;

    /**
     *
     * @var string
     * @Column(column="deleted", type="string", length=1, nullable=false)
     */
    protected $deleted;

    /**
     *
     * @var string
     * @Column(column="created_at", type="string", nullable=false)
     */
    protected $createdAt;

    /**
     *
     * @var integer
     * @Column(column="created_by", type="integer", length=10, nullable=true)
     */
    protected $createdBy;

    /**
     *
     * @var integer
     * @Column(column="created_as", type="integer", length=10, nullable=true)
     */
    protected $createdAs;

    /**
     *
     * @var string
     * @Column(column="updated_at", type="string", nullable=true)
     */
    protected $updatedAt;

    /**
     *
     * @var integer
     * @Column(column="updated_by", type="integer", length=10, nullable=true)
     */
    protected $updatedBy;

    /**
     *
     * @var integer
     * @Column(column="updated_as", type="integer", length=10, nullable=true)
     */
    protected $updatedAs;

    /**
     *
     * @var string
     * @Column(column="deleted_at", type="string", nullable=true)
     */
    protected $deletedAt;

    /**
     *
     * @var integer
     * @Column(column="deleted_by", type="integer", length=10, nullable=true)
     */
    protected $deletedBy;

    /**
     *
     * @var integer
     * @Column(column="deleted_as", type="integer", length=10, nullable=true)
     */
    protected $deletedAs;

    /**
     *
     * @var string
     * @Column(column="restored_at", type="string", nullable=true)
     */
    protected $restoredAt;

    /**
     *
     * @var integer
     * @Column(column="restored_by", type="integer", length=10, nullable=true)
     */
    protected $restoredBy;

    /**
     *
     * @var integer
     * @Column(column="restored_as", type="integer", length=10, nullable=true)
     */
    protected $restoredAs;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field template_id
     *
     * @param integer $templateId
     * @return $this
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Method to set the value of field from
     *
     * @param string $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Method to set the value of field to
     *
     * @param string $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Method to set the value of field cc
     *
     * @param string $cc
     * @return $this
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * Method to set the value of field bcc
     *
     * @param string $bcc
     * @return $this
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * Method to set the value of field read_receipt_to
     *
     * @param string $readReceiptTo
     * @return $this
     */
    public function setReadReceiptTo($readReceiptTo)
    {
        $this->readReceiptTo = $readReceiptTo;

        return $this;
    }

    /**
     * Method to set the value of field subject
     *
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Method to set the value of field content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Method to set the value of field meta
     *
     * @param string $meta
     * @return $this
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Method to set the value of field view_path
     *
     * @param string $viewPath
     * @return $this
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;

        return $this;
    }

    /**
     * Method to set the value of field sent
     *
     * @param string $sent
     * @return $this
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Method to set the value of field sent_at
     *
     * @param string $sentAt
     * @return $this
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Method to set the value of field sent_by
     *
     * @param integer $sentBy
     * @return $this
     */
    public function setSentBy($sentBy)
    {
        $this->sentBy = $sentBy;

        return $this;
    }

    /**
     * Method to set the value of field deleted
     *
     * @param string $deleted
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Method to set the value of field created_at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Method to set the value of field created_by
     *
     * @param integer $createdBy
     * @return $this
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Method to set the value of field created_as
     *
     * @param integer $createdAs
     * @return $this
     */
    public function setCreatedAs($createdAs)
    {
        $this->createdAs = $createdAs;

        return $this;
    }

    /**
     * Method to set the value of field updated_at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Method to set the value of field updated_by
     *
     * @param integer $updatedBy
     * @return $this
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Method to set the value of field updated_as
     *
     * @param integer $updatedAs
     * @return $this
     */
    public function setUpdatedAs($updatedAs)
    {
        $this->updatedAs = $updatedAs;

        return $this;
    }

    /**
     * Method to set the value of field deleted_at
     *
     * @param string $deletedAt
     * @return $this
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Method to set the value of field deleted_by
     *
     * @param integer $deletedBy
     * @return $this
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * Method to set the value of field deleted_as
     *
     * @param integer $deletedAs
     * @return $this
     */
    public function setDeletedAs($deletedAs)
    {
        $this->deletedAs = $deletedAs;

        return $this;
    }

    /**
     * Method to set the value of field restored_at
     *
     * @param string $restoredAt
     * @return $this
     */
    public function setRestoredAt($restoredAt)
    {
        $this->restoredAt = $restoredAt;

        return $this;
    }

    /**
     * Method to set the value of field restored_by
     *
     * @param integer $restoredBy
     * @return $this
     */
    public function setRestoredBy($restoredBy)
    {
        $this->restoredBy = $restoredBy;

        return $this;
    }

    /**
     * Method to set the value of field restored_as
     *
     * @param integer $restoredAs
     * @return $this
     */
    public function setRestoredAs($restoredAs)
    {
        $this->restoredAs = $restoredAs;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field templateId
     *
     * @return integer
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * Returns the value of field from
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Returns the value of field to
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Returns the value of field cc
     *
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Returns the value of field bcc
     *
     * @return string
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Returns the value of field readReceiptTo
     *
     * @return string
     */
    public function getReadReceiptTo()
    {
        return $this->readReceiptTo;
    }

    /**
     * Returns the value of field subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Returns the value of field content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the value of field meta
     *
     * @return string
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Returns the value of field viewPath
     *
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * Returns the value of field sent
     *
     * @return string
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Returns the value of field sentAt
     *
     * @return string
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * Returns the value of field sentBy
     *
     * @return integer
     */
    public function getSentBy()
    {
        return $this->sentBy;
    }

    /**
     * Returns the value of field deleted
     *
     * @return string
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Returns the value of field createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns the value of field createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Returns the value of field createdAs
     *
     * @return integer
     */
    public function getCreatedAs()
    {
        return $this->createdAs;
    }

    /**
     * Returns the value of field updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Returns the value of field updatedBy
     *
     * @return integer
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Returns the value of field updatedAs
     *
     * @return integer
     */
    public function getUpdatedAs()
    {
        return $this->updatedAs;
    }

    /**
     * Returns the value of field deletedAt
     *
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Returns the value of field deletedBy
     *
     * @return integer
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * Returns the value of field deletedAs
     *
     * @return integer
     */
    public function getDeletedAs()
    {
        return $this->deletedAs;
    }

    /**
     * Returns the value of field restoredAt
     *
     * @return string
     */
    public function getRestoredAt()
    {
        return $this->restoredAt;
    }

    /**
     * Returns the value of field restoredBy
     *
     * @return integer
     */
    public function getRestoredBy()
    {
        return $this->restoredBy;
    }

    /**
     * Returns the value of field restoredAs
     *
     * @return integer
     */
    public function getRestoredAs()
    {
        return $this->restoredAs;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
		parent::initialize();
        // $this->setSchema("zemit");
        $this->setSource("email");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractEmail[]|AbstractEmail|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AbstractEmail|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'template_id' => 'templateId',
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
            'restored_as' => 'restoredAs'
        ];
    }

}
