<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Support;

use Phalcon\Di\DiInterface;
use PhalconKit\Bootstrap\Config;
use PhalconKit\Models\Backup;
use PhalconKit\Models\Audit;
use PhalconKit\Models\AuditDetail;
use PhalconKit\Models\Log;
use PhalconKit\Models\Email;
use PhalconKit\Models\Job;
use PhalconKit\Models\File;
use PhalconKit\Models\Oauth2;
use PhalconKit\Models\Session;
use PhalconKit\Models\Flag;
use PhalconKit\Models\Setting;
use PhalconKit\Models\Lang;
use PhalconKit\Models\Translate;
use PhalconKit\Models\TranslateField;
use PhalconKit\Models\TranslateTable;
use PhalconKit\Models\Workspace;
use PhalconKit\Models\WorkspaceLang;
use PhalconKit\Models\Page;
use PhalconKit\Models\Post;
use PhalconKit\Models\Template;
use PhalconKit\Models\Table;
use PhalconKit\Models\Field;
use PhalconKit\Models\Profile;
use PhalconKit\Models\User;
use PhalconKit\Models\UserType;
use PhalconKit\Models\UserGroup;
use PhalconKit\Models\UserRole;
use PhalconKit\Models\UserFeature;
use PhalconKit\Models\Role;
use PhalconKit\Models\RoleRole;
use PhalconKit\Models\RoleFeature;
use PhalconKit\Models\Group;
use PhalconKit\Models\GroupRole;
use PhalconKit\Models\GroupType;
use PhalconKit\Models\GroupFeature;
use PhalconKit\Models\Type;
use PhalconKit\Models\Feature;
use PhalconKit\Mvc\ModelInterface;

/**
 * Allow to get mapped classes without using magic methods
 */
trait ModelsMap
{
    abstract public function getDI(): DiInterface;
    
    /**
     * Store the mapped model classes
     * @var string[] $modelsMap
     */
    public array $modelsMap = [];
    
    /**
     * Retrieve the config from DI
     */
    public function getConfig(): Config
    {
        return $this->getDI()->get('config');
    }
    
    /**
     * Set the models mapping or retrieve the mapped models from the config
     */
    public function setModelsMap(?array $modelsMap = null): void
    {
        $this->modelsMap = $modelsMap ?? $this->getConfig()->pathToArray('models') ?? [];
    }
    
    /**
     * Get an array of mapped models
     */
    public function getModelsMap(): array
    {
        return $this->modelsMap;
    }
    
    /**
     * Map a new class
     */
    public function setClassMap(string $map, string $class): void
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
     * Return the mapped class name of \PhalconKit\Models\Backup::class
     */
    public function getBackupClass(): string
    {
        return $this->getClassMap(Backup::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Audit::class
     */
    public function getAuditClass(): string
    {
        return $this->getClassMap(Audit::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\AuditDetail::class
     */
    public function getAuditDetailClass(): string
    {
        return $this->getClassMap(AuditDetail::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Log::class
     */
    public function getLogClass(): string
    {
        return $this->getClassMap(Log::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Email::class
     */
    public function getEmailClass(): string
    {
        return $this->getClassMap(Email::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Job::class
     */
    public function getJobClass(): string
    {
        return $this->getClassMap(Job::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\File::class
     */
    public function getFileClass(): string
    {
        return $this->getClassMap(File::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Session::class
     */
    public function getSessionClass(): string
    {
        return $this->getClassMap(Session::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Flag::class
     */
    public function getFlagClass(): string
    {
        return $this->getClassMap(Flag::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Setting::class
     */
    public function getSettingClass(): string
    {
        return $this->getClassMap(Setting::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Lang::class
     */
    public function getLangClass(): string
    {
        return $this->getClassMap(Lang::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Translate::class
     */
    public function getTranslateClass(): string
    {
        return $this->getClassMap(Translate::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Workspace::class
     */
    public function getWorkspaceClass(): string
    {
        return $this->getClassMap(Workspace::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\WorkspaceLang::class
     */
    public function getWorkspaceLangClass(): string
    {
        return $this->getClassMap(WorkspaceLang::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Page::class
     */
    public function getPageClass(): string
    {
        return $this->getClassMap(Page::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Post::class
     */
    public function getPostClass(): string
    {
        return $this->getClassMap(Post::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Template::class
     */
    public function getTemplateClass(): string
    {
        return $this->getClassMap(Template::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Table::class
     */
    public function getTableClass(): string
    {
        return $this->getClassMap(Table::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Profile::class
     */
    public function getProfileClass(): string
    {
        return $this->getClassMap(Profile::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Oauth2::class
     */
    public function getOauth2Class(): string
    {
        return $this->getClassMap(Oauth2::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\User::class
     */
    public function getUserClass(): string
    {
        return $this->getClassMap(User::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\UserType::class
     */
    public function getUserTypeClass(): string
    {
        return $this->getClassMap(UserType::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\UserGroup::class
     */
    public function getUserGroupClass(): string
    {
        return $this->getClassMap(UserGroup::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\UserRole::class
     */
    public function getUserRoleClass(): string
    {
        return $this->getClassMap(UserRole::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\UserFeature::class
     */
    public function getUserFeatureClass(): string
    {
        return $this->getClassMap(UserFeature::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Role::class
     */
    public function getRoleClass(): string
    {
        return $this->getClassMap(Role::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\RoleRole::class
     */
    public function getRoleRoleClass(): string
    {
        return $this->getClassMap(RoleRole::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\RoleFeature::class
     */
    public function getRoleFeatureClass(): string
    {
        return $this->getClassMap(RoleFeature::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Group::class
     */
    public function getGroupClass(): string
    {
        return $this->getClassMap(Group::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\GroupRole::class
     */
    public function getGroupRoleClass(): string
    {
        return $this->getClassMap(GroupRole::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\GroupType::class
     */
    public function getGroupTypeClass(): string
    {
        return $this->getClassMap(GroupType::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\GroupFeature::class
     */
    public function getGroupFeatureClass(): string
    {
        return $this->getClassMap(GroupFeature::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Type::class
     */
    public function getTypeClass(): string
    {
        return $this->getClassMap(Type::class);
    }
    
    /**
     * Return the mapped class name of \PhalconKit\Models\Feature::class
     */
    public function getFeatureClass(): string
    {
        return $this->getClassMap(Feature::class);
    }
}
