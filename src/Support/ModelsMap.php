<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Support;

use Phalcon\Di\DiInterface;
use Zemit\Bootstrap\Config;
use Zemit\Models\Backup;
use Zemit\Models\Audit;
use Zemit\Models\AuditDetail;
use Zemit\Models\Log;
use Zemit\Models\Email;
use Zemit\Models\Job;
use Zemit\Models\File;
use Zemit\Models\Session;
use Zemit\Models\Flag;
use Zemit\Models\Setting;
use Zemit\Models\Lang;
use Zemit\Models\Translate;
use Zemit\Models\TranslateField;
use Zemit\Models\TranslateTable;
use Zemit\Models\Site;
use Zemit\Models\SiteLang;
use Zemit\Models\Page;
use Zemit\Models\Post;
use Zemit\Models\Template;
use Zemit\Models\Channel;
use Zemit\Models\Field;
use Zemit\Models\Profile;
use Zemit\Models\User;
use Zemit\Models\UserType;
use Zemit\Models\UserGroup;
use Zemit\Models\UserRole;
use Zemit\Models\UserFeature;
use Zemit\Models\Role;
use Zemit\Models\RoleRole;
use Zemit\Models\RoleFeature;
use Zemit\Models\Group;
use Zemit\Models\GroupRole;
use Zemit\Models\GroupType;
use Zemit\Models\GroupFeature;
use Zemit\Models\Type;
use Zemit\Models\Feature;

/**
 * Allow to get mapped classes without using magic methods
 */
trait ModelsMap
{
    /**
     * Store an array of mapped models
     * @var array
     */
    public array $modelsMap;
    
    /**
     * @return DiInterface
     */
    abstract function getDI(): DiInterface;
    
    /**
     * Retrieve the config from DI
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->getDI()->get('config');
    }
    
    /**
     * Get an array of mapped models
     * @return array
     */
    public function getModelsMap(): array
    {
        if (!isset($this->modelsMap)) {
            $this->setModelsMap();
        }
        return $this->modelsMap;
    }
    
    /**
     * Set the models mapping or retrieve the mapped models from the config
     * @param array|null $modelsMap
     * @return void
     */
    public function setModelsMap(array $modelsMap = null)
    {
        if (isset($modelsMap)) {
            $this->modelsMap = $modelsMap;
        }
        else {
            $models = $this->getConfig()->path('models');
            $this->modelsMap = $models ? $models->toArray() : [];
        }
    }
    
    /**
     * Return the class mapping
     * @param string $class
     * @return string
     */
    public function getClassMap(string $class): string
    {
        return $this->getModelsMap()[$class] ?? $class;
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Backup::class
     * @return string
     */
    public function getBackupClass(): string
    {
        return $this->getClassMap(Backup::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Audit::class
     * @return string
     */
    public function getAuditClass(): string
    {
        return $this->getClassMap(Audit::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\AuditDetail::class
     * @return string
     */
    public function getAuditDetailClass(): string
    {
        return $this->getClassMap(AuditDetail::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Log::class
     * @return string
     */
    public function getLogClass(): string
    {
        return $this->getClassMap(Log::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Email::class
     * @return string
     */
    public function getEmailClass(): string
    {
        return $this->getClassMap(Email::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Job::class
     * @return string
     */
    public function getJobClass(): string
    {
        return $this->getClassMap(Job::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\File::class
     * @return string
     */
    public function getFileClass(): string
    {
        return $this->getClassMap(File::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Session::class
     * @return string
     */
    public function getSessionClass(): string
    {
        return $this->getClassMap(Session::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Flag::class
     * @return string
     */
    public function getFlagClass(): string
    {
        return $this->getClassMap(Flag::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Setting::class
     * @return string
     */
    public function getSettingClass(): string
    {
        return $this->getClassMap(Setting::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Lang::class
     * @return string
     */
    public function getLangClass(): string
    {
        return $this->getClassMap(Lang::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Translate::class
     * @return string
     */
    public function getTranslateClass(): string
    {
        return $this->getClassMap(Translate::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\TranslateField::class
     * @return string
     */
    public function getTranslateFieldClass(): string
    {
        return $this->getClassMap(TranslateField::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\TranslateTable::class
     * @return string
     */
    public function getTranslateTableClass(): string
    {
        return $this->getClassMap(TranslateTable::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Site::class
     * @return string
     */
    public function getSiteClass(): string
    {
        return $this->getClassMap(Site::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\SiteLang::class
     * @return string
     */
    public function getSiteLangClass(): string
    {
        return $this->getClassMap(SiteLang::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Page::class
     * @return string
     */
    public function getPageClass(): string
    {
        return $this->getClassMap(Page::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Post::class
     * @return string
     */
    public function getPostClass(): string
    {
        return $this->getClassMap(Post::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Template::class
     * @return string
     */
    public function getTemplateClass(): string
    {
        return $this->getClassMap(Template::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Channel::class
     * @return string
     */
    public function getChannelClass(): string
    {
        return $this->getClassMap(Channel::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Field::class
     * @return string
     */
    public function getFieldClass(): string
    {
        return $this->getClassMap(Field::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Profile::class
     * @return string
     */
    public function getProfileClass(): string
    {
        return $this->getClassMap(Profile::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\User::class
     * @return string
     */
    public function getUserClass(): string
    {
        return $this->getClassMap(User::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserType::class
     * @return string
     */
    public function getUserTypeClass(): string
    {
        return $this->getClassMap(UserType::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserGroup::class
     * @return string
     */
    public function getUserGroupClass(): string
    {
        return $this->getClassMap(UserGroup::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserRole::class
     * @return string
     */
    public function getUserRoleClass(): string
    {
        return $this->getClassMap(UserRole::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserFeature::class
     * @return string
     */
    public function getUserFeatureClass(): string
    {
        return $this->getClassMap(UserFeature::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Role::class
     * @return string
     */
    public function getRoleClass(): string
    {
        return $this->getClassMap(Role::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\RoleRole::class
     * @return string
     */
    public function getRoleRoleClass(): string
    {
        return $this->getClassMap(RoleRole::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\RoleFeature::class
     * @return string
     */
    public function getRoleFeatureClass(): string
    {
        return $this->getClassMap(RoleFeature::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Group::class
     * @return string
     */
    public function getGroupClass(): string
    {
        return $this->getClassMap(Group::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\GroupRole::class
     * @return string
     */
    public function getGroupRoleClass(): string
    {
        return $this->getClassMap(GroupRole::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\GroupType::class
     * @return string
     */
    public function getGroupTypeClass(): string
    {
        return $this->getClassMap(GroupType::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\GroupFeature::class
     * @return string
     */
    public function getGroupFeatureClass(): string
    {
        return $this->getClassMap(GroupFeature::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Type::class
     * @return string
     */
    public function getTypeClass(): string
    {
        return $this->getClassMap(Type::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Feature::class
     * @return string
     */
    public function getFeatureClass(): string
    {
        return $this->getClassMap(Feature::class);
    }
}
