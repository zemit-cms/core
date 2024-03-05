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
use Zemit\Models\Flag;
use Zemit\Models\Site;
use Zemit\Models\Lang;
use Zemit\Models\Meta;
use Zemit\Models\Post;
use Zemit\Models\Category;
use Zemit\Models\Translate;
use Zemit\Models\Abstracts\Interfaces\PageAbstractInterface;

/**
 * Class PageAbstract
 *
 * This class defines a Page abstract model that extends the AbstractModel class and implements the PageAbstractInterface.
 * It provides properties and methods for managing Page data.
 * 
 * @property Flag[] $FlagList
 * @method Flag[] getFlagList(?array $params = null)
 *
 * @property Site[] $FlagSiteList
 * @method Site[] getFlagSiteList(?array $params = null)
 *
 * @property Lang[] $FlagLangList
 * @method Lang[] getFlagLangList(?array $params = null)
 *
 * @property Meta[] $MetaList
 * @method Meta[] getMetaList(?array $params = null)
 *
 * @property Lang[] $MetaLangList
 * @method Lang[] getMetaLangList(?array $params = null)
 *
 * @property Site[] $MetaSiteList
 * @method Site[] getMetaSiteList(?array $params = null)
 *
 * @property Post[] $MetaPostList
 * @method Post[] getMetaPostList(?array $params = null)
 *
 * @property Category[] $MetaCategoryList
 * @method Category[] getMetaCategoryList(?array $params = null)
 *
 * @property Post[] $PostList
 * @method Post[] getPostList(?array $params = null)
 *
 * @property Lang[] $PostLangList
 * @method Lang[] getPostLangList(?array $params = null)
 *
 * @property Site[] $PostSiteList
 * @method Site[] getPostSiteList(?array $params = null)
 *
 * @property Translate[] $TranslateList
 * @method Translate[] getTranslateList(?array $params = null)
 *
 * @property Lang[] $TranslateLangList
 * @method Lang[] getTranslateLangList(?array $params = null)
 *
 * @property Site[] $TranslateSiteList
 * @method Site[] getTranslateSiteList(?array $params = null)
 *
 * @property Post[] $TranslatePostList
 * @method Post[] getTranslatePostList(?array $params = null)
 *
 * @property Category[] $TranslateCategoryList
 * @method Category[] getTranslateCategoryList(?array $params = null)
 *
 * @property Lang $LangEntity
 * @method Lang getLangEntity(?array $params = null)
 *
 * @property Site $SiteEntity
 * @method Site getSiteEntity(?array $params = null)
 */
abstract class PageAbstract extends AbstractModel implements PageAbstractInterface
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
     * Column: name
     * @var RawValue|string|null
     */
    public RawValue|string|null $name = null;
    
    /**
     * Column: description
     * @var RawValue|string|null
     */
    public RawValue|string|null $description = null;
    
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
     * Returns the value of field name
     * Column: name
     * @return RawValue|string|null
     */
    public function getName(): RawValue|string|null
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * @param RawValue|string|null $name
     * @return void
     */
    public function setName(RawValue|string|null $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field description
     * Column: description
     * @return RawValue|string|null
     */
    public function getDescription(): RawValue|string|null
    {
        return $this->description;
    }
    
    /**
     * Sets the value of field description
     * Column: description 
     * @param RawValue|string|null $description
     * @return void
     */
    public function setDescription(RawValue|string|null $description): void
    {
        $this->description = $description;
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
        $this->hasMany('id', Flag::class, 'pageId', ['alias' => 'FlagList']);

        $this->hasManyToMany('id', Flag::class, 'pageId',
            'siteId', Site::class, 'id', ['alias' => 'FlagSiteList']);

        $this->hasManyToMany('id', Flag::class, 'pageId',
            'langId', Lang::class, 'id', ['alias' => 'FlagLangList']);

        $this->hasMany('id', Meta::class, 'pageId', ['alias' => 'MetaList']);

        $this->hasManyToMany('id', Meta::class, 'pageId',
            'langId', Lang::class, 'id', ['alias' => 'MetaLangList']);

        $this->hasManyToMany('id', Meta::class, 'pageId',
            'siteId', Site::class, 'id', ['alias' => 'MetaSiteList']);

        $this->hasManyToMany('id', Meta::class, 'pageId',
            'postId', Post::class, 'id', ['alias' => 'MetaPostList']);

        $this->hasManyToMany('id', Meta::class, 'pageId',
            'categoryId', Category::class, 'id', ['alias' => 'MetaCategoryList']);

        $this->hasMany('id', Post::class, 'pageId', ['alias' => 'PostList']);

        $this->hasManyToMany('id', Post::class, 'pageId',
            'langId', Lang::class, 'id', ['alias' => 'PostLangList']);

        $this->hasManyToMany('id', Post::class, 'pageId',
            'siteId', Site::class, 'id', ['alias' => 'PostSiteList']);

        $this->hasMany('id', Translate::class, 'pageId', ['alias' => 'TranslateList']);

        $this->hasManyToMany('id', Translate::class, 'pageId',
            'langId', Lang::class, 'id', ['alias' => 'TranslateLangList']);

        $this->hasManyToMany('id', Translate::class, 'pageId',
            'siteId', Site::class, 'id', ['alias' => 'TranslateSiteList']);

        $this->hasManyToMany('id', Translate::class, 'pageId',
            'postId', Post::class, 'id', ['alias' => 'TranslatePostList']);

        $this->hasManyToMany('id', Translate::class, 'pageId',
            'categoryId', Category::class, 'id', ['alias' => 'TranslateCategoryList']);

        $this->belongsTo('langId', Lang::class, 'id', ['alias' => 'LangEntity']);

        $this->belongsTo('siteId', Site::class, 'id', ['alias' => 'SiteEntity']);
    }
    
    /**
     * Adds the default validations to the model.
     * @return Validation
     */
    public function addDefaultValidations(?Validation $validator = null): Validation
    {
        $validator ??= new Validation();
    
        $this->addUnsignedIntValidation($validator, 'id', true);
        $this->addUnsignedIntValidation($validator, 'langId', true);
        $this->addUnsignedIntValidation($validator, 'siteId', false);
        $this->addStringLengthValidation($validator, 'name', 0, 255, false);
        $this->addStringLengthValidation($validator, 'description', 0, 255, true);
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
            'lang_id' => 'langId',
            'site_id' => 'siteId',
            'name' => 'name',
            'description' => 'description',
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
            'restored_as' => 'restoredAs',
        ];
    }
}