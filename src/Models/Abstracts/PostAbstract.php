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
use Zemit\Models\Meta;
use Zemit\Models\Lang;
use Zemit\Models\Site;
use Zemit\Models\Page;
use Zemit\Models\Category;
use Zemit\Models\PostCategory;
use Zemit\Models\Translate;
use Zemit\Models\User;
use Zemit\Models\Abstracts\Interfaces\PostAbstractInterface;

/**
 * Class PostAbstract
 *
 * This class defines a Post abstract model that extends the AbstractModel class and implements the PostAbstractInterface.
 * It provides properties and methods for managing Post data.
 * 
 * @property Meta[] $metalist
 * @property Meta[] $MetaList
 * @method Meta[] getMetaList(?array $params = null)
 *
 * @property Lang[] $metalanglist
 * @property Lang[] $MetaLangList
 * @method Lang[] getMetaLangList(?array $params = null)
 *
 * @property Site[] $metasitelist
 * @property Site[] $MetaSiteList
 * @method Site[] getMetaSiteList(?array $params = null)
 *
 * @property Page[] $metapagelist
 * @property Page[] $MetaPageList
 * @method Page[] getMetaPageList(?array $params = null)
 *
 * @property Category[] $metacategorylist
 * @property Category[] $MetaCategoryList
 * @method Category[] getMetaCategoryList(?array $params = null)
 *
 * @property PostCategory[] $postcategorylist
 * @property PostCategory[] $PostCategoryList
 * @method PostCategory[] getPostCategoryList(?array $params = null)
 *
 * @property Category[] $categorylist
 * @property Category[] $CategoryList
 * @method Category[] getCategoryList(?array $params = null)
 *
 * @property Translate[] $translatelist
 * @property Translate[] $TranslateList
 * @method Translate[] getTranslateList(?array $params = null)
 *
 * @property Lang[] $translatelanglist
 * @property Lang[] $TranslateLangList
 * @method Lang[] getTranslateLangList(?array $params = null)
 *
 * @property Site[] $translatesitelist
 * @property Site[] $TranslateSiteList
 * @method Site[] getTranslateSiteList(?array $params = null)
 *
 * @property Page[] $translatepagelist
 * @property Page[] $TranslatePageList
 * @method Page[] getTranslatePageList(?array $params = null)
 *
 * @property Category[] $translatecategorylist
 * @property Category[] $TranslateCategoryList
 * @method Category[] getTranslateCategoryList(?array $params = null)
 *
 * @property Lang $langentity
 * @property Lang $LangEntity
 * @method Lang getLangEntity(?array $params = null)
 *
 * @property Site $siteentity
 * @property Site $SiteEntity
 * @method Site getSiteEntity(?array $params = null)
 *
 * @property Page $pageentity
 * @property Page $PageEntity
 * @method Page getPageEntity(?array $params = null)
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
 * @property User $deletedasentity
 * @property User $DeletedAsEntity
 * @method User getDeletedAsEntity(?array $params = null)
 *
 * @property User $deletedbyentity
 * @property User $DeletedByEntity
 * @method User getDeletedByEntity(?array $params = null)
 *
 * @property User $restoredbyentity
 * @property User $RestoredByEntity
 * @method User getRestoredByEntity(?array $params = null)
 *
 * @property User $restoredasentity
 * @property User $RestoredAsEntity
 * @method User getRestoredAsEntity(?array $params = null)
 */
abstract class PostAbstract extends AbstractModel implements PostAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public mixed $id = null;
        
    /**
     * Column: lang_id
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $langId = null;
        
    /**
     * Column: site_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public mixed $siteId = null;
        
    /**
     * Column: page_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public mixed $pageId = null;
        
    /**
     * Column: name
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public mixed $name = null;
        
    /**
     * Column: description
     * Attributes: Size(255) | Type(2)
     * @var mixed
     */
    public mixed $description = null;
        
    /**
     * Column: content
     * Attributes: Size(255) | Type(2)
     * @var mixed
     */
    public mixed $content = null;
        
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
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedAs = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public mixed $deletedBy = null;
        
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
     * Returns the value of field langId
     * Column: lang_id
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getLangId(): mixed
    {
        return $this->langId;
    }
    
    /**
     * Sets the value of field langId
     * Column: lang_id 
     * Attributes: Numeric | Unsigned
     * @param mixed $langId
     * @return void
     */
    public function setLangId(mixed $langId): void
    {
        $this->langId = $langId;
    }
    
    /**
     * Returns the value of field siteId
     * Column: site_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getSiteId(): mixed
    {
        return $this->siteId;
    }
    
    /**
     * Sets the value of field siteId
     * Column: site_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $siteId
     * @return void
     */
    public function setSiteId(mixed $siteId): void
    {
        $this->siteId = $siteId;
    }
    
    /**
     * Returns the value of field pageId
     * Column: page_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getPageId(): mixed
    {
        return $this->pageId;
    }
    
    /**
     * Sets the value of field pageId
     * Column: page_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $pageId
     * @return void
     */
    public function setPageId(mixed $pageId): void
    {
        $this->pageId = $pageId;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }
    
    /**
     * Sets the value of field name
     * Column: name 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $name
     * @return void
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field description
     * Column: description
     * Attributes: Size(255) | Type(2)
     * @return mixed
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }
    
    /**
     * Sets the value of field description
     * Column: description 
     * Attributes: Size(255) | Type(2)
     * @param mixed $description
     * @return void
     */
    public function setDescription(mixed $description): void
    {
        $this->description = $description;
    }
    
    /**
     * Returns the value of field content
     * Column: content
     * Attributes: Size(255) | Type(2)
     * @return mixed
     */
    public function getContent(): mixed
    {
        return $this->content;
    }
    
    /**
     * Sets the value of field content
     * Column: content 
     * Attributes: Size(255) | Type(2)
     * @param mixed $content
     * @return void
     */
    public function setContent(mixed $content): void
    {
        $this->content = $content;
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
        $this->hasMany('id', Meta::class, 'postId', ['alias' => 'MetaList']);

        $this->hasManyToMany(
            'id',
            Meta::class,
            'postId',
            'langId',
            Lang::class,
            'id',
            ['alias' => 'MetaLangList']
        );

        $this->hasManyToMany(
            'id',
            Meta::class,
            'postId',
            'siteId',
            Site::class,
            'id',
            ['alias' => 'MetaSiteList']
        );

        $this->hasManyToMany(
            'id',
            Meta::class,
            'postId',
            'pageId',
            Page::class,
            'id',
            ['alias' => 'MetaPageList']
        );

        $this->hasManyToMany(
            'id',
            Meta::class,
            'postId',
            'categoryId',
            Category::class,
            'id',
            ['alias' => 'MetaCategoryList']
        );

        $this->hasMany('id', PostCategory::class, 'postId', ['alias' => 'PostCategoryList']);

        $this->hasManyToMany(
            'id',
            PostCategory::class,
            'postId',
            'categoryId',
            Category::class,
            'id',
            ['alias' => 'CategoryList']
        );

        $this->hasMany('id', Translate::class, 'postId', ['alias' => 'TranslateList']);

        $this->hasManyToMany(
            'id',
            Translate::class,
            'postId',
            'langId',
            Lang::class,
            'id',
            ['alias' => 'TranslateLangList']
        );

        $this->hasManyToMany(
            'id',
            Translate::class,
            'postId',
            'siteId',
            Site::class,
            'id',
            ['alias' => 'TranslateSiteList']
        );

        $this->hasManyToMany(
            'id',
            Translate::class,
            'postId',
            'pageId',
            Page::class,
            'id',
            ['alias' => 'TranslatePageList']
        );

        $this->hasManyToMany(
            'id',
            Translate::class,
            'postId',
            'categoryId',
            Category::class,
            'id',
            ['alias' => 'TranslateCategoryList']
        );

        $this->belongsTo('langId', Lang::class, 'id', ['alias' => 'LangEntity']);

        $this->belongsTo('siteId', Site::class, 'id', ['alias' => 'SiteEntity']);

        $this->belongsTo('pageId', Page::class, 'id', ['alias' => 'PageEntity']);

        $this->belongsTo('createdBy', User::class, 'id', ['alias' => 'CreatedByEntity']);

        $this->belongsTo('createdAs', User::class, 'id', ['alias' => 'CreatedAsEntity']);

        $this->belongsTo('updatedBy', User::class, 'id', ['alias' => 'UpdatedByEntity']);

        $this->belongsTo('updatedAs', User::class, 'id', ['alias' => 'UpdatedAsEntity']);

        $this->belongsTo('deletedAs', User::class, 'id', ['alias' => 'DeletedAsEntity']);

        $this->belongsTo('deletedBy', User::class, 'id', ['alias' => 'DeletedByEntity']);

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
        $this->addUnsignedIntValidation($validator, 'langId', true);
        $this->addUnsignedIntValidation($validator, 'siteId', false);
        $this->addUnsignedIntValidation($validator, 'pageId', false);
        $this->addStringLengthValidation($validator, 'name', 0, 255, false);
        $this->addStringLengthValidation($validator, 'description', 0, 255, true);
        $this->addStringLengthValidation($validator, 'content', 0, 255, true);
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
    public function columnMap(): array
    {
        return [
            'id' => 'id',
            'lang_id' => 'langId',
            'site_id' => 'siteId',
            'page_id' => 'pageId',
            'name' => 'name',
            'description' => 'description',
            'content' => 'content',
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
