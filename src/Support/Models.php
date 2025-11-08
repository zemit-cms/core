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

use PhalconKit\Mvc\Model;
use PhalconKit\Di\Injectable;
use PhalconKit\Models\Backup;
use PhalconKit\Models\Interfaces\BackupInterface;
use PhalconKit\Models\Audit;
use PhalconKit\Models\Interfaces\AuditInterface;
use PhalconKit\Models\AuditDetail;
use PhalconKit\Models\Interfaces\AuditDetailInterface;
use PhalconKit\Models\Feature;
use PhalconKit\Models\Interfaces\FeatureInterface;
use PhalconKit\Models\Log;
use PhalconKit\Models\Interfaces\LogInterface;
use PhalconKit\Models\Email;
use PhalconKit\Models\Interfaces\EmailInterface;
use PhalconKit\Models\Job;
use PhalconKit\Models\Interfaces\JobInterface;
use PhalconKit\Models\File;
use PhalconKit\Models\Interfaces\FileInterface;
use PhalconKit\Models\Session;
use PhalconKit\Models\Interfaces\SessionInterface;
use PhalconKit\Models\Flag;
use PhalconKit\Models\Interfaces\FlagInterface;
use PhalconKit\Models\Setting;
use PhalconKit\Models\Interfaces\SettingInterface;
use PhalconKit\Models\Lang;
use PhalconKit\Models\Interfaces\LangInterface;
use PhalconKit\Models\Translate;
use PhalconKit\Models\Interfaces\TranslateInterface;
use PhalconKit\Models\Workspace;
use PhalconKit\Models\Interfaces\WorkspaceInterface;
use PhalconKit\Models\WorkspaceLang;
use PhalconKit\Models\Interfaces\WorkspaceLangInterface;
use PhalconKit\Models\Page;
use PhalconKit\Models\Interfaces\PageInterface;
use PhalconKit\Models\Post;
use PhalconKit\Models\Interfaces\PostInterface;
use PhalconKit\Models\Template;
use PhalconKit\Models\Interfaces\TemplateInterface;
use PhalconKit\Models\Table;
use PhalconKit\Models\Interfaces\TableInterface;
use PhalconKit\Models\Field;
use PhalconKit\Models\Interfaces\FieldInterface;
use PhalconKit\Models\Profile;
use PhalconKit\Models\Interfaces\ProfileInterface;
use PhalconKit\Models\Oauth2;
use PhalconKit\Models\Interfaces\Oauth2Interface;
use PhalconKit\Models\User;
use PhalconKit\Models\Interfaces\UserInterface;
use PhalconKit\Models\UserType;
use PhalconKit\Models\Interfaces\UserTypeInterface;
use PhalconKit\Models\UserGroup;
use PhalconKit\Models\Interfaces\UserGroupInterface;
use PhalconKit\Models\UserRole;
use PhalconKit\Models\Interfaces\UserRoleInterface;
use PhalconKit\Models\UserFeature;
use PhalconKit\Models\Interfaces\UserFeatureInterface;
use PhalconKit\Models\Role;
use PhalconKit\Models\Interfaces\RoleInterface;
use PhalconKit\Models\RoleRole;
use PhalconKit\Models\Interfaces\RoleRoleInterface;
use PhalconKit\Models\RoleFeature;
use PhalconKit\Models\Interfaces\RoleFeatureInterface;
use PhalconKit\Models\Group;
use PhalconKit\Models\Interfaces\GroupInterface;
use PhalconKit\Models\GroupRole;
use PhalconKit\Models\Interfaces\GroupRoleInterface;
use PhalconKit\Models\GroupType;
use PhalconKit\Models\Interfaces\GroupTypeInterface;
use PhalconKit\Models\GroupFeature;
use PhalconKit\Models\Interfaces\GroupFeatureInterface;
use PhalconKit\Models\Type;
use PhalconKit\Models\Interfaces\TypeInterface;

/**
 * Allow to get mapped classes without using magic methods
 */
class Models extends Injectable
{
    use ModelsMap;
    
    /**
     * Store an array of instances
     */
    public array $instances = [];
    
    /**
     * 
     */
    public function __construct(?array $mapping = null)
    {
        $this->setModelsMap($mapping);
    }
    
    /**
     * Get an array of mapped models
     */
    public function getInstances(): array
    {
        return $this->instances;
    }
    
    /**
     * Set the instance for a class
     */
    public function setInstance(string $class, Model $instance): void
    {
        $this->instances[$class] = $instance;
    }
    
    /**
     * Remove an existing class
     */
    public function unsetInstance(string $map): void
    {
        unset($this->instances[$map]);
    }
    
    /**
     * Return an instance of a specified class implementing Model interface
     *
     * @param string $class The fully qualified class name
     * @return Model An instance of the specified class
     */
    public function getInstance(string $class): Model
    {
        if (!isset($this->instances[$class])) {
            $map = $this->getClassMap($class);
            $instance = new $map();
            assert($instance instanceof Model);
            $this->setInstance($class, $instance);
        }
        
        return $this->instances[$class];
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\BackupInterface
     */
    public function getBackup(): BackupInterface
    {
        $instance = $this->getInstance(Backup::class);
        assert($instance instanceof BackupInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\AuditInterface
     */
    public function getAudit(): AuditInterface
    {
        $instance = $this->getInstance(Audit::class);
        assert($instance instanceof AuditInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\AuditDetailInterface
     */
    public function getAuditDetail(): AuditDetailInterface
    {
        $instance = $this->getInstance(AuditDetail::class);
        assert($instance instanceof AuditDetailInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\LogInterface
     */
    public function getLog(): LogInterface
    {
        $instance = $this->getInstance(Log::class);
        assert($instance instanceof LogInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\EmailInterface
     */
    public function getEmail(): EmailInterface
    {
        $instance = $this->getInstance(Email::class);
        assert($instance instanceof EmailInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\JobInterface
     */
    public function getJob(): JobInterface
    {
        $instance = $this->getInstance(Job::class);
        assert($instance instanceof JobInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\FileInterface
     */
    public function getFile(): FileInterface
    {
        $instance = $this->getInstance(File::class);
        assert($instance instanceof FileInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\SessionInterface
     */
    public function getSession(): SessionInterface
    {
        $instance = $this->getInstance(Session::class);
        assert($instance instanceof SessionInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\FlagInterface
     */
    public function getFlag(): FlagInterface
    {
        $instance = $this->getInstance(Flag::class);
        assert($instance instanceof FlagInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\SettingInterface
     */
    public function getSetting(): SettingInterface
    {
        $instance = $this->getInstance(Setting::class);
        assert($instance instanceof SettingInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\LangInterface
     */
    public function getLang(): LangInterface
    {
        $instance = $this->getInstance(Lang::class);
        assert($instance instanceof LangInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\TranslateInterface
     */
    public function getTranslate(): TranslateInterface
    {
        $instance = $this->getInstance(Translate::class);
        assert($instance instanceof TranslateInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\WorkspaceInterface
     */
    public function getWorkspace(): WorkspaceInterface
    {
        $instance = $this->getInstance(Workspace::class);
        assert($instance instanceof WorkspaceInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\WorkspaceInterface
     */
    public function getWorkspaceLang(): WorkspaceLangInterface
    {
        $instance = $this->getInstance(WorkspaceLang::class);
        assert($instance instanceof WorkspaceLangInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\PageInterface
     */
    public function getPage(): PageInterface
    {
        $instance = $this->getInstance(Page::class);
        assert($instance instanceof PageInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\PostInterface
     */
    public function getPost(): PostInterface
    {
        $instance = $this->getInstance(Post::class);
        assert($instance instanceof PostInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\TemplateInterface
     */
    public function getTemplate(): TemplateInterface
    {
        $instance = $this->getInstance(Template::class);
        assert($instance instanceof TemplateInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\TableInterface
     */
    public function getTable(): TableInterface
    {
        $instance = $this->getInstance(Table::class);
        assert($instance instanceof TableInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\ProfileInterface
     */
    public function getProfile(): ProfileInterface
    {
        $instance = $this->getInstance(Profile::class);
        assert($instance instanceof ProfileInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\UserInterface
     */
    public function getOauth2(): Oauth2Interface
    {
        $instance = $this->getInstance(Oauth2::class);
        assert($instance instanceof Oauth2Interface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\UserInterface
     */
    public function getUser(): UserInterface
    {
        $instance = $this->getInstance(User::class);
        assert($instance instanceof UserInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\UserTypeInterface
     */
    public function getUserType(): UserTypeInterface
    {
        $instance = $this->getInstance(UserType::class);
        assert($instance instanceof UserTypeInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\UserGroupInterface
     */
    public function getUserGroup(): UserGroupInterface
    {
        $instance = $this->getInstance(UserGroup::class);
        assert($instance instanceof UserGroupInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\UserRoleInterface
     */
    public function getUserRole(): UserRoleInterface
    {
        $instance = $this->getInstance(UserRole::class);
        assert($instance instanceof UserRoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\UserFeatureInterface
     */
    public function getUserFeature(): UserFeatureInterface
    {
        $instance = $this->getInstance(UserFeature::class);
        assert($instance instanceof UserFeatureInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\RoleInterface
     */
    public function getRole(): RoleInterface
    {
        $instance = $this->getInstance(Role::class);
        assert($instance instanceof RoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\RoleRoleInterface
     */
    public function getRoleRole(): RoleRoleInterface
    {
        $instance = $this->getInstance(RoleRole::class);
        assert($instance instanceof RoleRoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\RoleFeatureInterface
     */
    public function getRoleFeature(): RoleFeatureInterface
    {
        $instance = $this->getInstance(RoleFeature::class);
        assert($instance instanceof RoleFeatureInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\GroupInterface
     */
    public function getGroup(): GroupInterface
    {
        $instance = $this->getInstance(Group::class);
        assert($instance instanceof GroupInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\GroupRoleInterface
     */
    public function getGroupRole(): GroupRoleInterface
    {
        $instance = $this->getInstance(GroupRole::class);
        assert($instance instanceof GroupRoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\GroupTypeInterface
     */
    public function getGroupType(): GroupTypeInterface
    {
        $instance = $this->getInstance(GroupType::class);
        assert($instance instanceof GroupTypeInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\GroupFeatureInterface
     */
    public function getGroupFeature(): GroupFeatureInterface
    {
        $instance = $this->getInstance(GroupFeature::class);
        assert($instance instanceof GroupFeatureInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\TypeInterface
     */
    public function getType(): TypeInterface
    {
        $instance = $this->getInstance(Type::class);
        assert($instance instanceof TypeInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \PhalconKit\Models\Interfaces\FeatureInterface
     */
    public function getFeature(): FeatureInterface
    {
        $instance = $this->getInstance(Feature::class);
        assert($instance instanceof FeatureInterface);
        return $instance;
    }
}
