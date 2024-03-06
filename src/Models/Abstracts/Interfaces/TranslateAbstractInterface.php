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

interface TranslateAbstractInterface extends ModelInterface
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
     * Returns the value of field langId
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getLangId();
    
    /**
     * Sets the value of field langId
     * Column: lang_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $langId
     * @return void
     */
    public function setLangId($langId);
    
    /**
     * Returns the value of field siteId
     * Column: site_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getSiteId();
    
    /**
     * Sets the value of field siteId
     * Column: site_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $siteId
     * @return void
     */
    public function setSiteId($siteId);
    
    /**
     * Returns the value of field pageId
     * Column: page_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getPageId();
    
    /**
     * Sets the value of field pageId
     * Column: page_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $pageId
     * @return void
     */
    public function setPageId($pageId);
    
    /**
     * Returns the value of field postId
     * Column: post_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getPostId();
    
    /**
     * Sets the value of field postId
     * Column: post_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $postId
     * @return void
     */
    public function setPostId($postId);
    
    /**
     * Returns the value of field categoryId
     * Column: category_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCategoryId();
    
    /**
     * Sets the value of field categoryId
     * Column: category_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $categoryId
     * @return void
     */
    public function setCategoryId($categoryId);
    
    /**
     * Returns the value of field key
     * Column: key
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getKey();
    
    /**
     * Sets the value of field key
     * Column: key 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $key
     * @return void
     */
    public function setKey($key);
    
    /**
     * Returns the value of field value
     * Column: value
     * Attributes: Type(23)
     * @return mixed
     */
    public function getValue();
    
    /**
     * Sets the value of field value
     * Column: value 
     * Attributes: Type(23)
     * @param mixed $value
     * @return void
     */
    public function setValue($value);
    
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
}