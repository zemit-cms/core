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
use Zemit\Models\Category;
use Zemit\Models\Site;
use Zemit\Models\Flag;
use Zemit\Models\Page;
use Zemit\Models\Meta;
use Zemit\Models\Post;
use Zemit\Models\SiteLang;
use Zemit\Models\Table;
use Zemit\Models\Workspace;
use Zemit\Models\Translate;
use Zemit\Models\TranslateField;
use Zemit\Models\WorkspaceLang;
use Zemit\Models\Abstracts\Interfaces\LangAbstractInterface;

/**
 * Class LangAbstract
 *
 * This class defines a Lang abstract model that extends the AbstractModel class and implements the LangAbstractInterface.
 * It provides properties and methods for managing Lang data.
 * 
 * @property Category[] $categorylist
 * @property Category[] $CategoryList
 * @method Category[] getCategoryList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $CategorySiteList
 * @method Site[] getCategorySiteList(?array $params = null)
 *
 * @property Flag[] $flaglist
 * @property Flag[] $FlagList
 * @method Flag[] getFlagList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $FlagSiteList
 * @method Site[] getFlagSiteList(?array $params = null)
 *
 * @property Page[] $pagelist
 * @property Page[] $FlagPageList
 * @method Page[] getFlagPageList(?array $params = null)
 *
 * @property Meta[] $metalist
 * @property Meta[] $MetaList
 * @method Meta[] getMetaList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $MetaSiteList
 * @method Site[] getMetaSiteList(?array $params = null)
 *
 * @property Page[] $pagelist
 * @property Page[] $MetaPageList
 * @method Page[] getMetaPageList(?array $params = null)
 *
 * @property Post[] $postlist
 * @property Post[] $MetaPostList
 * @method Post[] getMetaPostList(?array $params = null)
 *
 * @property Category[] $categorylist
 * @property Category[] $MetaCategoryList
 * @method Category[] getMetaCategoryList(?array $params = null)
 *
 * @property Page[] $pagelist
 * @property Page[] $PageList
 * @method Page[] getPageList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $PageSiteList
 * @method Site[] getPageSiteList(?array $params = null)
 *
 * @property Post[] $postlist
 * @property Post[] $PostList
 * @method Post[] getPostList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $PostSiteList
 * @method Site[] getPostSiteList(?array $params = null)
 *
 * @property Page[] $pagelist
 * @property Page[] $PostPageList
 * @method Page[] getPostPageList(?array $params = null)
 *
 * @property SiteLang[] $sitelanglist
 * @property SiteLang[] $SiteLangList
 * @method SiteLang[] getSiteLangList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $SiteList
 * @method Site[] getSiteList(?array $params = null)
 *
 * @property Table[] $tablelist
 * @property Table[] $TableList
 * @method Table[] getTableList(?array $params = null)
 *
 * @property Workspace[] $workspacelist
 * @property Workspace[] $TableWorkspaceList
 * @method Workspace[] getTableWorkspaceList(?array $params = null)
 *
 * @property Translate[] $translatelist
 * @property Translate[] $TranslateList
 * @method Translate[] getTranslateList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $TranslateSiteList
 * @method Site[] getTranslateSiteList(?array $params = null)
 *
 * @property Page[] $pagelist
 * @property Page[] $TranslatePageList
 * @method Page[] getTranslatePageList(?array $params = null)
 *
 * @property Post[] $postlist
 * @property Post[] $TranslatePostList
 * @method Post[] getTranslatePostList(?array $params = null)
 *
 * @property Category[] $categorylist
 * @property Category[] $TranslateCategoryList
 * @method Category[] getTranslateCategoryList(?array $params = null)
 *
 * @property TranslateField[] $translatefieldlist
 * @property TranslateField[] $TranslateFieldList
 * @method TranslateField[] getTranslateFieldList(?array $params = null)
 *
 * @property Site[] $sitelist
 * @property Site[] $TranslateFieldSiteList
 * @method Site[] getTranslateFieldSiteList(?array $params = null)
 *
 * @property Table[] $tablelist
 * @property Table[] $TranslateFieldTableList
 * @method Table[] getTranslateFieldTableList(?array $params = null)
 *
 * @property WorkspaceLang[] $workspacelanglist
 * @property WorkspaceLang[] $WorkspaceLangList
 * @method WorkspaceLang[] getWorkspaceLangList(?array $params = null)
 *
 * @property Workspace[] $workspacelist
 * @property Workspace[] $WorkspaceList
 * @method Workspace[] getWorkspaceList(?array $params = null)
 */
abstract class LangAbstract extends AbstractModel implements LangAbstractInterface
{
    /**
     * Column: id
     * Attributes: First | Primary | NotNull | Numeric | Unsigned | AutoIncrement
     * @var mixed
     */
    public $id = null;
        
    /**
     * Column: label
     * Attributes: NotNull | Size(255) | Type(2)
     * @var mixed
     */
    public $label = null;
        
    /**
     * Column: code
     * Attributes: NotNull | Size(10) | Type(5)
     * @var mixed
     */
    public $code = null;
        
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
     * Returns the value of field label
     * Column: label
     * Attributes: NotNull | Size(255) | Type(2)
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * Sets the value of field label
     * Column: label 
     * Attributes: NotNull | Size(255) | Type(2)
     * @param mixed $label
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    /**
     * Returns the value of field code
     * Column: code
     * Attributes: NotNull | Size(10) | Type(5)
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * Sets the value of field code
     * Column: code 
     * Attributes: NotNull | Size(10) | Type(5)
     * @param mixed $code
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
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
        $this->hasMany('id', Category::class, 'langId', ['alias' => 'CategoryList']);

        $this->hasManyToMany('id', Category::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'CategorySiteList']);

        $this->hasMany('id', Flag::class, 'langId', ['alias' => 'FlagList']);

        $this->hasManyToMany('id', Flag::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'FlagSiteList']);

        $this->hasManyToMany('id', Flag::class, 'langId',
            'pageId', Page::class, 'id', ['alias' => 'FlagPageList']);

        $this->hasMany('id', Meta::class, 'langId', ['alias' => 'MetaList']);

        $this->hasManyToMany('id', Meta::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'MetaSiteList']);

        $this->hasManyToMany('id', Meta::class, 'langId',
            'pageId', Page::class, 'id', ['alias' => 'MetaPageList']);

        $this->hasManyToMany('id', Meta::class, 'langId',
            'postId', Post::class, 'id', ['alias' => 'MetaPostList']);

        $this->hasManyToMany('id', Meta::class, 'langId',
            'categoryId', Category::class, 'id', ['alias' => 'MetaCategoryList']);

        $this->hasMany('id', Page::class, 'langId', ['alias' => 'PageList']);

        $this->hasManyToMany('id', Page::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'PageSiteList']);

        $this->hasMany('id', Post::class, 'langId', ['alias' => 'PostList']);

        $this->hasManyToMany('id', Post::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'PostSiteList']);

        $this->hasManyToMany('id', Post::class, 'langId',
            'pageId', Page::class, 'id', ['alias' => 'PostPageList']);

        $this->hasMany('id', SiteLang::class, 'langId', ['alias' => 'SiteLangList']);

        $this->hasManyToMany('id', SiteLang::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'SiteList']);

        $this->hasMany('id', Table::class, 'langId', ['alias' => 'TableList']);

        $this->hasManyToMany('id', Table::class, 'langId',
            'workspaceId', Workspace::class, 'id', ['alias' => 'TableWorkspaceList']);

        $this->hasMany('id', Translate::class, 'langId', ['alias' => 'TranslateList']);

        $this->hasManyToMany('id', Translate::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'TranslateSiteList']);

        $this->hasManyToMany('id', Translate::class, 'langId',
            'pageId', Page::class, 'id', ['alias' => 'TranslatePageList']);

        $this->hasManyToMany('id', Translate::class, 'langId',
            'postId', Post::class, 'id', ['alias' => 'TranslatePostList']);

        $this->hasManyToMany('id', Translate::class, 'langId',
            'categoryId', Category::class, 'id', ['alias' => 'TranslateCategoryList']);

        $this->hasMany('id', TranslateField::class, 'langId', ['alias' => 'TranslateFieldList']);

        $this->hasManyToMany('id', TranslateField::class, 'langId',
            'siteId', Site::class, 'id', ['alias' => 'TranslateFieldSiteList']);

        $this->hasManyToMany('id', TranslateField::class, 'langId',
            'tableId', Table::class, 'id', ['alias' => 'TranslateFieldTableList']);

        $this->hasMany('id', WorkspaceLang::class, 'langId', ['alias' => 'WorkspaceLangList']);

        $this->hasManyToMany('id', WorkspaceLang::class, 'langId',
            'workspaceId', Workspace::class, 'id', ['alias' => 'WorkspaceList']);
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
        $this->addStringLengthValidation($validator, 'label', 0, 255, false);
        $this->addStringLengthValidation($validator, 'code', 0, 10, false);
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
            'label' => 'label',
            'code' => 'code',
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