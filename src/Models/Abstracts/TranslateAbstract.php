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
use Zemit\Models\Lang;
use Zemit\Models\Site;
use Zemit\Models\Page;
use Zemit\Models\Post;
use Zemit\Models\Category;
use Zemit\Models\Abstracts\Interfaces\TranslateAbstractInterface;

/**
 * Class TranslateAbstract
 *
 * This class defines a Translate abstract model that extends the AbstractModel class and implements the TranslateAbstractInterface.
 * It provides properties and methods for managing Translate data.
 * 
 * @property Lang $LangEntity
 * @method Lang getLangEntity(?array $params = null)
 *
 * @property Site $SiteEntity
 * @method Site getSiteEntity(?array $params = null)
 *
 * @property Page $PageEntity
 * @method Page getPageEntity(?array $params = null)
 *
 * @property Post $PostEntity
 * @method Post getPostEntity(?array $params = null)
 *
 * @property Category $CategoryEntity
 * @method Category getCategoryEntity(?array $params = null)
 */
class TranslateAbstract extends AbstractModel implements TranslateAbstractInterface
{
    /**
     * Column: id
     * @var RawValue|int|null
     */
    public RawValue|int|null $id = null;
    
    /**
     * Column: lang_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $langId = null;
    
    /**
     * Column: site_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $siteId = null;
    
    /**
     * Column: page_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $pageId = null;
    
    /**
     * Column: post_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $postId = null;
    
    /**
     * Column: category_id
     * @var RawValue|int|null
     */
    public RawValue|int|null $categoryId = null;
    
    /**
     * Column: key
     * @var RawValue|string|null
     */
    public RawValue|string|null $key = null;
    
    /**
     * Column: value
     * @var RawValue|string|null
     */
    public RawValue|string|null $value = null;
    
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
     * Column: deleted_as
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedAs = null;
    
    /**
     * Column: deleted_by
     * @var RawValue|int|null
     */
    public RawValue|int|null $deletedBy = null;
    
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
     * Returns the value of field langId
     * Column: lang_id
     * @return RawValue|int|null
     */
    public function getLangId(): RawValue|int|null
    {
        return $this->langId;
    }
    
    /**
     * Sets the value of field langId
     * Column: lang_id 
     * @param RawValue|int|null $langId
     * @return void
     */
    public function setLangId(RawValue|int|null $langId): void
    {
        $this->langId = $langId;
    }
    
    /**
     * Returns the value of field siteId
     * Column: site_id
     * @return RawValue|int|null
     */
    public function getSiteId(): RawValue|int|null
    {
        return $this->siteId;
    }
    
    /**
     * Sets the value of field siteId
     * Column: site_id 
     * @param RawValue|int|null $siteId
     * @return void
     */
    public function setSiteId(RawValue|int|null $siteId): void
    {
        $this->siteId = $siteId;
    }
    
    /**
     * Returns the value of field pageId
     * Column: page_id
     * @return RawValue|int|null
     */
    public function getPageId(): RawValue|int|null
    {
        return $this->pageId;
    }
    
    /**
     * Sets the value of field pageId
     * Column: page_id 
     * @param RawValue|int|null $pageId
     * @return void
     */
    public function setPageId(RawValue|int|null $pageId): void
    {
        $this->pageId = $pageId;
    }
    
    /**
     * Returns the value of field postId
     * Column: post_id
     * @return RawValue|int|null
     */
    public function getPostId(): RawValue|int|null
    {
        return $this->postId;
    }
    
    /**
     * Sets the value of field postId
     * Column: post_id 
     * @param RawValue|int|null $postId
     * @return void
     */
    public function setPostId(RawValue|int|null $postId): void
    {
        $this->postId = $postId;
    }
    
    /**
     * Returns the value of field categoryId
     * Column: category_id
     * @return RawValue|int|null
     */
    public function getCategoryId(): RawValue|int|null
    {
        return $this->categoryId;
    }
    
    /**
     * Sets the value of field categoryId
     * Column: category_id 
     * @param RawValue|int|null $categoryId
     * @return void
     */
    public function setCategoryId(RawValue|int|null $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
    
    /**
     * Returns the value of field key
     * Column: key
     * @return RawValue|string|null
     */
    public function getKey(): RawValue|string|null
    {
        return $this->key;
    }
    
    /**
     * Sets the value of field key
     * Column: key 
     * @param RawValue|string|null $key
     * @return void
     */
    public function setKey(RawValue|string|null $key): void
    {
        $this->key = $key;
    }
    
    /**
     * Returns the value of field value
     * Column: value
     * @return RawValue|string|null
     */
    public function getValue(): RawValue|string|null
    {
        return $this->value;
    }
    
    /**
     * Sets the value of field value
     * Column: value 
     * @param RawValue|string|null $value
     * @return void
     */
    public function setValue(RawValue|string|null $value): void
    {
        $this->value = $value;
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
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->belongsTo('langId', Lang::class, 'id', ['alias' => 'LangEntity']);

        $this->belongsTo('siteId', Site::class, 'id', ['alias' => 'SiteEntity']);

        $this->belongsTo('pageId', Page::class, 'id', ['alias' => 'PageEntity']);

        $this->belongsTo('postId', Post::class, 'id', ['alias' => 'PostEntity']);

        $this->belongsTo('categoryId', Category::class, 'id', ['alias' => 'CategoryEntity']);
    }
    
    /**
     * Adds the default validations to the model.
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addUnsignedIntValidation($validator, 'langId', false);
        $this->addUnsignedIntValidation($validator, 'siteId', true);
        $this->addUnsignedIntValidation($validator, 'pageId', true);
        $this->addUnsignedIntValidation($validator, 'postId', true);
        $this->addUnsignedIntValidation($validator, 'categoryId', true);
        $this->addStringLengthValidation($validator, 'key', 0, 255, false);
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
            'lang_id' => 'langId',
            'site_id' => 'siteId',
            'page_id' => 'pageId',
            'post_id' => 'postId',
            'category_id' => 'categoryId',
            'key' => 'key',
            'value' => 'value',
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
        ];
    }
}