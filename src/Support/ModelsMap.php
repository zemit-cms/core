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
use Zemit\Models\OAuth2;
use Zemit\Models\Session;
use Zemit\Models\Flag;
use Zemit\Models\Setting;
use Zemit\Models\Lang;
use Zemit\Models\Translate;
use Zemit\Models\TranslateField;
use Zemit\Models\TranslateTable;
use Zemit\Models\Workspace;
use Zemit\Models\WorkspaceLang;
use Zemit\Models\Page;
use Zemit\Models\Post;
use Zemit\Models\Template;
use Zemit\Models\Table;
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
     */
    public ?array $modelsMap = null;
    
    abstract public function getDI(): DiInterface;
    
    /**
     * Retrieve the config from DI
     */
    public function getConfig(): Config
    {
        return $this->getDI()->get('config');
    }
    
    /**
     * Get an array of mapped models
     */
    public function getModelsMap(): array
    {
        if (!isset($this->modelsMap)) {
            $this->setModelsMap();
        }
        return $this->modelsMap ?? [];
    }
    
    /**
     * Set the models mapping or retrieve the mapped models from the config
     */
    public function setModelsMap(?array $modelsMap = null): void
    {
        $this->modelsMap = $modelsMap ?? $this->getConfig()->pathToArray('models') ?? [];
    }
    
    /**
     * Map a new class
     */
    public function setClassMap(string $map, ?string $class): void
    {
        $this->modelsMap[$map] = $class;
    }
    
    /**
     * Remove an existing class
     */
    public function removeClassMap(string $map): void
    {
        unset($this->modelsMap[$map]);
    }
    
    /**
     * Return the class mapping
     */
    public function getClassMap(string $class): string
    {
        return $this->getModelsMap()[$class] ?? $class;
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Backup::class
     */
    public function getBackupClass(): string
    {
        return $this->getClassMap(Backup::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Audit::class
     */
    public function getAuditClass(): string
    {
        return $this->getClassMap(Audit::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\AuditDetail::class
     */
    public function getAuditDetailClass(): string
    {
        return $this->getClassMap(AuditDetail::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Log::class
     */
    public function getLogClass(): string
    {
        return $this->getClassMap(Log::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Email::class
     */
    public function getEmailClass(): string
    {
        return $this->getClassMap(Email::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Job::class
     */
    public function getJobClass(): string
    {
        return $this->getClassMap(Job::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\File::class
     */
    public function getFileClass(): string
    {
        return $this->getClassMap(File::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Session::class
     */
    public function getSessionClass(): string
    {
        return $this->getClassMap(Session::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Flag::class
     */
    public function getFlagClass(): string
    {
        return $this->getClassMap(Flag::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Setting::class
     */
    public function getSettingClass(): string
    {
        return $this->getClassMap(Setting::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Lang::class
     */
    public function getLangClass(): string
    {
        return $this->getClassMap(Lang::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Translate::class
     */
    public function getTranslateClass(): string
    {
        return $this->getClassMap(Translate::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\TranslateField::class
     */
    public function getTranslateFieldClass(): string
    {
        return $this->getClassMap(TranslateField::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\TranslateTable::class
     */
    public function getTranslateTableClass(): string
    {
        return $this->getClassMap(TranslateTable::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Workspace::class
     */
    public function getWorkspaceClass(): string
    {
        return $this->getClassMap(Workspace::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\WorkspaceLang::class
     */
    public function getWorkspaceLangClass(): string
    {
        return $this->getClassMap(WorkspaceLang::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Page::class
     */
    public function getPageClass(): string
    {
        return $this->getClassMap(Page::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Post::class
     */
    public function getPostClass(): string
    {
        return $this->getClassMap(Post::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Template::class
     */
    public function getTemplateClass(): string
    {
        return $this->getClassMap(Template::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Table::class
     */
    public function getTableClass(): string
    {
        return $this->getClassMap(Table::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Field::class
     */
    public function getFieldClass(): string
    {
        return $this->getClassMap(Field::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Profile::class
     */
    public function getProfileClass(): string
    {
        return $this->getClassMap(Profile::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\OAuth2::class
     */
    public function getOAuth2Class(): string
    {
        return $this->getClassMap(OAuth2::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\User::class
     */
    public function getUserClass(): string
    {
        return $this->getClassMap(User::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserType::class
     */
    public function getUserTypeClass(): string
    {
        return $this->getClassMap(UserType::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserGroup::class
     */
    public function getUserGroupClass(): string
    {
        return $this->getClassMap(UserGroup::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserRole::class
     */
    public function getUserRoleClass(): string
    {
        return $this->getClassMap(UserRole::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\UserFeature::class
     */
    public function getUserFeatureClass(): string
    {
        return $this->getClassMap(UserFeature::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Role::class
     */
    public function getRoleClass(): string
    {
        return $this->getClassMap(Role::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\RoleRole::class
     */
    public function getRoleRoleClass(): string
    {
        return $this->getClassMap(RoleRole::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\RoleFeature::class
     */
    public function getRoleFeatureClass(): string
    {
        return $this->getClassMap(RoleFeature::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Group::class
     */
    public function getGroupClass(): string
    {
        return $this->getClassMap(Group::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\GroupRole::class
     */
    public function getGroupRoleClass(): string
    {
        return $this->getClassMap(GroupRole::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\GroupType::class
     */
    public function getGroupTypeClass(): string
    {
        return $this->getClassMap(GroupType::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\GroupFeature::class
     */
    public function getGroupFeatureClass(): string
    {
        return $this->getClassMap(GroupFeature::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Type::class
     */
    public function getTypeClass(): string
    {
        return $this->getClassMap(Type::class);
    }
    
    /**
     * Return the mapped class name of \Zemit\Models\Feature::class
     */
    public function getFeatureClass(): string
    {
        return $this->getClassMap(Feature::class);
    }
}
