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
use Zemit\Models\Post;
use Zemit\Models\PostCategory;
use Zemit\Models\Translate;
use Zemit\Models\Abstracts\Interfaces\CategoryAbstractInterface;

/**
 * Class CategoryAbstract
 *
 * This class defines a Category abstract model that extends the AbstractModel class and implements the CategoryAbstractInterface.
 * It provides properties and methods for managing Category data.
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
 * @property Page[] $MetaPageList
 * @method Page[] getMetaPageList(?array $params = null)
 *
 * @property Post[] $MetaPostList
 * @method Post[] getMetaPostList(?array $params = null)
 *
 * @property PostCategory[] $PostCategoryList
 * @method PostCategory[] getPostCategoryList(?array $params = null)
 *
 * @property Post[] $PostList
 * @method Post[] getPostList(?array $params = null)
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
 * @property Page[] $TranslatePageList
 * @method Page[] getTranslatePageList(?array $params = null)
 *
 * @property Post[] $TranslatePostList
 * @method Post[] getTranslatePostList(?array $params = null)
 *
 * @property Site $SiteEntity
 * @method Site getSiteEntity(?array $params = null)
 *
 * @property Lang $LangEntity
 * @method Lang getLangEntity(?array $params = null)
 */
abstract class CategoryAbstract extends AbstractModel implements CategoryAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public $id = null;
        
    /**
     * Column: site_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public $siteId = null;
        
    /**
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned
     * @var mixed
     */
    public $langId = null;
        
    /**
     * Column: name
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public $name = null;
        
    /**
     * Column: index
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public $index = null;
        
    /**
     * Column: description
     * Attributes: Type(23)
     * @var mixed
     */
    public $description = null;
        
    /**
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @var mixed
     */
    public $deleted = 0;
        
    /**
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @var mixed
     */
    public $createdAt = null;
        
    /**
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdBy = null;
        
    /**
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $createdAs = null;
        
    /**
     * Column: updated_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $updatedAt = null;
        
    /**
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedBy = null;
        
    /**
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $updatedAs = null;
        
    /**
     * Column: deleted_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $deletedAt = null;
        
    /**
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedAs = null;
        
    /**
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $deletedBy = null;
        
    /**
     * Column: restored_at
     * Attributes: Type(4)
     * @var mixed
     */
    public $restoredAt = null;
        
    /**
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @var mixed
     */
    public $restoredBy = null;
    
    /**
     * Returns the value of field id
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @return mixed
     */
    public function getId()
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
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Returns the value of field siteId
     * Column: site_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getSiteId()
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
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }
    
    /**
     * Returns the value of field langId
     * Column: lang_id
     * Attributes: NotNull | Numeric | Unsigned
     * @return mixed
     */
    public function getLangId()
    {
        return $this->langId;
    }
    
    /**
     * Sets the value of field langId
     * Column: lang_id 
     * Attributes: NotNull | Numeric | Unsigned
     * @param mixed $langId
     * @return void
     */
    public function setLangId($langId)
    {
        $this->langId = $langId;
    }
    
    /**
     * Returns the value of field name
     * Column: name
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getName()
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
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the value of field index
     * Column: index
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }
    
    /**
     * Sets the value of field index
     * Column: index 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $index
     * @return void
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }
    
    /**
     * Returns the value of field description
     * Column: description
     * Attributes: Type(23)
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the value of field description
     * Column: description 
     * Attributes: Type(23)
     * @param mixed $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Returns the value of field deleted
     * Column: deleted
     * Attributes: NotNull | Numeric | Unsigned | Type(26)
     * @return mixed
     */
    public function getDeleted()
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
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }
    
    /**
     * Returns the value of field createdAt
     * Column: created_at
     * Attributes: NotNull | Type(4)
     * @return mixed
     */
    public function getCreatedAt()
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
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Returns the value of field createdBy
     * Column: created_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedBy()
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
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }
    
    /**
     * Returns the value of field createdAs
     * Column: created_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getCreatedAs()
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
    public function setCreatedAs($createdAs)
    {
        $this->createdAs = $createdAs;
    }
    
    /**
     * Returns the value of field updatedAt
     * Column: updated_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getUpdatedAt()
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
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Returns the value of field updatedBy
     * Column: updated_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedBy()
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
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }
    
    /**
     * Returns the value of field updatedAs
     * Column: updated_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getUpdatedAs()
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
    public function setUpdatedAs($updatedAs)
    {
        $this->updatedAs = $updatedAs;
    }
    
    /**
     * Returns the value of field deletedAt
     * Column: deleted_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getDeletedAt()
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
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * Returns the value of field deletedAs
     * Column: deleted_as
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedAs()
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
    public function setDeletedAs($deletedAs)
    {
        $this->deletedAs = $deletedAs;
    }
    
    /**
     * Returns the value of field deletedBy
     * Column: deleted_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getDeletedBy()
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
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }
    
    /**
     * Returns the value of field restoredAt
     * Column: restored_at
     * Attributes: Type(4)
     * @return mixed
     */
    public function getRestoredAt()
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
    public function setRestoredAt($restoredAt)
    {
        $this->restoredAt = $restoredAt;
    }
    
    /**
     * Returns the value of field restoredBy
     * Column: restored_by
     * Attributes: Numeric | Unsigned
     * @return mixed
     */
    public function getRestoredBy()
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
    public function setRestoredBy($restoredBy)
    {
        $this->restoredBy = $restoredBy;
    }

    /**
     * Adds the default relationships to the model.
     * @return void
     */
    public function addDefaultRelationships(): void
    {
        $this->hasMany('id', Meta::class, 'categoryId', ['alias' => 'MetaList']);

        $this->hasManyToMany('id', Meta::class, 'categoryId',
            'langId', Lang::class, 'id', ['alias' => 'MetaLangList']);

        $this->hasManyToMany('id', Meta::class, 'categoryId',
            'siteId', Site::class, 'id', ['alias' => 'MetaSiteList']);

        $this->hasManyToMany('id', Meta::class, 'categoryId',
            'pageId', Page::class, 'id', ['alias' => 'MetaPageList']);

        $this->hasManyToMany('id', Meta::class, 'categoryId',
            'postId', Post::class, 'id', ['alias' => 'MetaPostList']);

        $this->hasMany('id', PostCategory::class, 'categoryId', ['alias' => 'PostCategoryList']);

        $this->hasManyToMany('id', PostCategory::class, 'categoryId',
            'postId', Post::class, 'id', ['alias' => 'PostList']);

        $this->hasMany('id', Translate::class, 'categoryId', ['alias' => 'TranslateList']);

        $this->hasManyToMany('id', Translate::class, 'categoryId',
            'langId', Lang::class, 'id', ['alias' => 'TranslateLangList']);

        $this->hasManyToMany('id', Translate::class, 'categoryId',
            'siteId', Site::class, 'id', ['alias' => 'TranslateSiteList']);

        $this->hasManyToMany('id', Translate::class, 'categoryId',
            'pageId', Page::class, 'id', ['alias' => 'TranslatePageList']);

        $this->hasManyToMany('id', Translate::class, 'categoryId',
            'postId', Post::class, 'id', ['alias' => 'TranslatePostList']);

        $this->belongsTo('siteId', Site::class, 'id', ['alias' => 'SiteEntity']);

        $this->belongsTo('langId', Lang::class, 'id', ['alias' => 'LangEntity']);
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
        $this->addUnsignedIntValidation($validator, 'siteId', false);
        $this->addUnsignedIntValidation($validator, 'langId', false);
        $this->addStringLengthValidation($validator, 'name', 0, 255, false);
        $this->addStringLengthValidation($validator, 'index', 0, 255, false);
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
            'site_id' => 'siteId',
            'lang_id' => 'langId',
            'name' => 'name',
            'index' => 'index',
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
        ];
    }
}