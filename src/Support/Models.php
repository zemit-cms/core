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

use Zemit\Mvc\Model;
use Zemit\Di\Injectable;

use Zemit\Models\Backup;
use Zemit\Models\Interfaces\BackupInterface;

use Zemit\Models\Audit;
use Zemit\Models\Interfaces\AuditInterface;

use Zemit\Models\AuditDetail;
use Zemit\Models\Interfaces\AuditDetailInterface;

use Zemit\Models\Feature;
use Zemit\Models\Interfaces\FeatureInterface;

use Zemit\Models\Log;
use Zemit\Models\Interfaces\LogInterface;

use Zemit\Models\Email;
use Zemit\Models\Interfaces\EmailInterface;

use Zemit\Models\Job;
use Zemit\Models\Interfaces\JobInterface;

use Zemit\Models\File;
use Zemit\Models\Interfaces\FileInterface;

use Zemit\Models\Session;
use Zemit\Models\Interfaces\SessionInterface;

use Zemit\Models\Flag;
use Zemit\Models\Interfaces\FlagInterface;

use Zemit\Models\Setting;
use Zemit\Models\Interfaces\SettingInterface;

use Zemit\Models\Lang;
use Zemit\Models\Interfaces\LangInterface;

use Zemit\Models\Translate;
use Zemit\Models\Interfaces\TranslateInterface;

use Zemit\Models\TranslateField;
use Zemit\Models\Interfaces\TranslateFieldInterface;

use Zemit\Models\TranslateTable;
use Zemit\Models\Interfaces\TranslateTableInterface;

use Zemit\Models\Workspace;
use Zemit\Models\Interfaces\WorkspaceInterface;

use Zemit\Models\WorkspaceLang;
use Zemit\Models\Interfaces\WorkspaceLangInterface;

use Zemit\Models\Page;
use Zemit\Models\Interfaces\PageInterface;

use Zemit\Models\Post;
use Zemit\Models\Interfaces\PostInterface;

use Zemit\Models\Template;
use Zemit\Models\Interfaces\TemplateInterface;

use Zemit\Models\Table;
use Zemit\Models\Interfaces\TableInterface;

use Zemit\Models\Field;
use Zemit\Models\Interfaces\FieldInterface;

use Zemit\Models\Profile;
use Zemit\Models\Interfaces\ProfileInterface;

use Zemit\Models\User;
use Zemit\Models\Interfaces\UserInterface;

use Zemit\Models\UserType;
use Zemit\Models\Interfaces\UserTypeInterface;

use Zemit\Models\UserGroup;
use Zemit\Models\Interfaces\UserGroupInterface;

use Zemit\Models\UserRole;
use Zemit\Models\Interfaces\UserRoleInterface;

use Zemit\Models\UserFeature;
use Zemit\Models\Interfaces\UserFeatureInterface;

use Zemit\Models\Role;
use Zemit\Models\Interfaces\RoleInterface;

use Zemit\Models\RoleRole;
use Zemit\Models\Interfaces\RoleRoleInterface;

use Zemit\Models\RoleFeature;
use Zemit\Models\Interfaces\RoleFeatureInterface;

use Zemit\Models\Group;
use Zemit\Models\Interfaces\GroupInterface;

use Zemit\Models\GroupRole;
use Zemit\Models\Interfaces\GroupRoleInterface;

use Zemit\Models\GroupType;
use Zemit\Models\Interfaces\GroupTypeInterface;

use Zemit\Models\GroupFeature;
use Zemit\Models\Interfaces\GroupFeatureInterface;

use Zemit\Models\Type;
use Zemit\Models\Interfaces\TypeInterface;

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
     * Return an instance of \Zemit\Models\Interfaces\BackupInterface
     */
    public function getBackup(): BackupInterface
    {
        $instance = $this->getInstance(Backup::class);
        assert($instance instanceof BackupInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\AuditInterface
     */
    public function getAudit(): AuditInterface
    {
        $instance = $this->getInstance(Audit::class);
        assert($instance instanceof AuditInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\AuditDetailInterface
     */
    public function getAuditDetail(): AuditDetailInterface
    {
        $instance = $this->getInstance(AuditDetail::class);
        assert($instance instanceof AuditDetailInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\LogInterface
     */
    public function getLog(): LogInterface
    {
        $instance = $this->getInstance(Log::class);
        assert($instance instanceof LogInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\EmailInterface
     */
    public function getEmail(): EmailInterface
    {
        $instance = $this->getInstance(Email::class);
        assert($instance instanceof EmailInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\JobInterface
     */
    public function getJob(): JobInterface
    {
        $instance = $this->getInstance(Job::class);
        assert($instance instanceof JobInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\FileInterface
     */
    public function getFile(): FileInterface
    {
        $instance = $this->getInstance(File::class);
        assert($instance instanceof FileInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\SessionInterface
     */
    public function getSession(): SessionInterface
    {
        $instance = $this->getInstance(Session::class);
        assert($instance instanceof SessionInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\FlagInterface
     */
    public function getFlag(): FlagInterface
    {
        $instance = $this->getInstance(Flag::class);
        assert($instance instanceof FlagInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\SettingInterface
     */
    public function getSetting(): SettingInterface
    {
        $instance = $this->getInstance(Setting::class);
        assert($instance instanceof SettingInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\LangInterface
     */
    public function getLang(): LangInterface
    {
        $instance = $this->getInstance(Lang::class);
        assert($instance instanceof LangInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\TranslateInterface
     */
    public function getTranslate(): TranslateInterface
    {
        $instance = $this->getInstance(Translate::class);
        assert($instance instanceof TranslateInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\TranslateFieldInterface
     */
    public function getTranslateField(): TranslateFieldInterface
    {
        $instance = $this->getInstance(TranslateField::class);
        assert($instance instanceof TranslateFieldInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\TranslateTableInterface
     */
    public function getTranslateTable(): TranslateTableInterface
    {
        $instance = $this->getInstance(TranslateTable::class);
        assert($instance instanceof TranslateTableInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\WorkspaceInterface
     */
    public function getWorkspace(): WorkspaceInterface
    {
        $instance = $this->getInstance(Workspace::class);
        assert($instance instanceof WorkspaceInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\WorkspaceInterface
     */
    public function getWorkspaceLang(): WorkspaceLangInterface
    {
        $instance = $this->getInstance(WorkspaceLang::class);
        assert($instance instanceof WorkspaceLangInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\PageInterface
     */
    public function getPage(): PageInterface
    {
        $instance = $this->getInstance(Page::class);
        assert($instance instanceof PageInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\PostInterface
     */
    public function getPost(): PostInterface
    {
        $instance = $this->getInstance(Post::class);
        assert($instance instanceof PostInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\TemplateInterface
     */
    public function getTemplate(): TemplateInterface
    {
        $instance = $this->getInstance(Template::class);
        assert($instance instanceof TemplateInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\TableInterface
     */
    public function getTable(): TableInterface
    {
        $instance = $this->getInstance(Table::class);
        assert($instance instanceof TableInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\FieldInterface
     */
    public function getField(): FieldInterface
    {
        $instance = $this->getInstance(Field::class);
        assert($instance instanceof FieldInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\ProfileInterface
     */
    public function getProfile(): ProfileInterface
    {
        $instance = $this->getInstance(Profile::class);
        assert($instance instanceof ProfileInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\UserInterface
     */
    public function getUser(): UserInterface
    {
        $instance = $this->getInstance(User::class);
        assert($instance instanceof UserInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\UserTypeInterface
     */
    public function getUserType(): UserTypeInterface
    {
        $instance = $this->getInstance(UserType::class);
        assert($instance instanceof UserTypeInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\UserGroupInterface
     */
    public function getUserGroup(): UserGroupInterface
    {
        $instance = $this->getInstance(UserGroup::class);
        assert($instance instanceof UserGroupInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\UserRoleInterface
     */
    public function getUserRole(): UserRoleInterface
    {
        $instance = $this->getInstance(UserRole::class);
        assert($instance instanceof UserRoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\UserFeatureInterface
     */
    public function getUserFeature(): UserFeatureInterface
    {
        $instance = $this->getInstance(UserFeature::class);
        assert($instance instanceof UserFeatureInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\RoleInterface
     */
    public function getRole(): RoleInterface
    {
        $instance = $this->getInstance(Role::class);
        assert($instance instanceof RoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\RoleRoleInterface
     */
    public function getRoleRole(): RoleRoleInterface
    {
        $instance = $this->getInstance(RoleRole::class);
        assert($instance instanceof RoleRoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\RoleFeatureInterface
     */
    public function getRoleFeature(): RoleFeatureInterface
    {
        $instance = $this->getInstance(RoleFeature::class);
        assert($instance instanceof RoleFeatureInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\GroupInterface
     */
    public function getGroup(): GroupInterface
    {
        $instance = $this->getInstance(Group::class);
        assert($instance instanceof GroupInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\GroupRoleInterface
     */
    public function getGroupRole(): GroupRoleInterface
    {
        $instance = $this->getInstance(GroupRole::class);
        assert($instance instanceof GroupRoleInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\GroupTypeInterface
     */
    public function getGroupType(): GroupTypeInterface
    {
        $instance = $this->getInstance(GroupType::class);
        assert($instance instanceof GroupTypeInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\GroupFeatureInterface
     */
    public function getGroupFeature(): GroupFeatureInterface
    {
        $instance = $this->getInstance(GroupFeature::class);
        assert($instance instanceof GroupFeatureInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\TypeInterface
     */
    public function getType(): TypeInterface
    {
        $instance = $this->getInstance(Type::class);
        assert($instance instanceof TypeInterface);
        return $instance;
    }
    
    /**
     * Return an instance of \Zemit\Models\Interfaces\FeatureInterface
     */
    public function getFeature(): FeatureInterface
    {
        $instance = $this->getInstance(Feature::class);
        assert($instance instanceof FeatureInterface);
        return $instance;
    }
}
