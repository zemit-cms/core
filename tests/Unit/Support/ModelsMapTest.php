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

namespace Unit\Support;

use Zemit\Di\Injectable;
use Zemit\Support\ModelsMap;
use Zemit\Tests\Unit\AbstractUnit;

class ModelsMapTest extends AbstractUnit
{
    public $modelsMap;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->modelsMap = new class extends Injectable {
            use ModelsMap;
        };
    }
    
    public function testModelsMap(): void
    {
        $classesMap = [
            \Zemit\Bootstrap\Config::class => \Zemit\Bootstrap\Config::class,
            \Zemit\Models\Backup::class => \Zemit\Models\Backup::class,
            \Zemit\Models\Audit::class => \Zemit\Models\Audit::class,
            \Zemit\Models\AuditDetail::class => \Zemit\Models\AuditDetail::class,
            \Zemit\Models\Log::class => \Zemit\Models\Log::class,
            \Zemit\Models\Email::class => \Zemit\Models\Email::class,
            \Zemit\Models\Job::class => \Zemit\Models\Job::class,
            \Zemit\Models\File::class => \Zemit\Models\File::class,
            \Zemit\Models\Session::class => \Zemit\Models\Session::class,
            \Zemit\Models\Flag::class => \Zemit\Models\Flag::class,
            \Zemit\Models\Setting::class => \Zemit\Models\Setting::class,
            \Zemit\Models\Lang::class => \Zemit\Models\Lang::class,
            \Zemit\Models\Translate::class => \Zemit\Models\Translate::class,
            \Zemit\Models\TranslateField::class => \Zemit\Models\TranslateField::class,
            \Zemit\Models\TranslateTable::class => \Zemit\Models\TranslateTable::class,
            \Zemit\Models\Workspace::class => \Zemit\Models\Workspace::class,
            \Zemit\Models\WorkspaceLang::class => \Zemit\Models\WorkspaceLang::class,
            \Zemit\Models\Page::class => \Zemit\Models\Page::class,
            \Zemit\Models\Post::class => \Zemit\Models\Post::class,
            \Zemit\Models\Template::class => \Zemit\Models\Template::class,
            \Zemit\Models\Table::class => \Zemit\Models\Table::class,
            \Zemit\Models\Field::class => \Zemit\Models\Field::class,
            \Zemit\Models\Profile::class => \Zemit\Models\Profile::class,
            \Zemit\Models\User::class => \Zemit\Models\User::class,
            \Zemit\Models\UserType::class => \Zemit\Models\UserType::class,
            \Zemit\Models\UserGroup::class => \Zemit\Models\UserGroup::class,
            \Zemit\Models\UserRole::class => \Zemit\Models\UserRole::class,
            \Zemit\Models\UserFeature::class => \Zemit\Models\UserFeature::class,
            \Zemit\Models\Role::class => \Zemit\Models\Role::class,
            \Zemit\Models\RoleRole::class => \Zemit\Models\RoleRole::class,
            \Zemit\Models\RoleFeature::class => \Zemit\Models\RoleFeature::class,
            \Zemit\Models\Group::class => \Zemit\Models\Group::class,
            \Zemit\Models\GroupRole::class => \Zemit\Models\GroupRole::class,
            \Zemit\Models\GroupType::class => \Zemit\Models\GroupType::class,
            \Zemit\Models\GroupFeature::class => \Zemit\Models\GroupFeature::class,
            \Zemit\Models\Type::class => \Zemit\Models\Type::class,
            \Zemit\Models\Feature::class => \Zemit\Models\Feature::class,
        ];
        
        $classes = [
            \Zemit\Models\Backup::class => $this->modelsMap->getBackupClass(),
            \Zemit\Models\Audit::class => $this->modelsMap->getAuditClass(),
            \Zemit\Models\AuditDetail::class => $this->modelsMap->getAuditDetailClass(),
            \Zemit\Models\Log::class => $this->modelsMap->getLogClass(),
            \Zemit\Models\Email::class => $this->modelsMap->getEmailClass(),
            \Zemit\Models\Job::class => $this->modelsMap->getJobClass(),
            \Zemit\Models\File::class => $this->modelsMap->getFileClass(),
            \Zemit\Models\Session::class => $this->modelsMap->getSessionClass(),
            \Zemit\Models\Flag::class => $this->modelsMap->getFlagClass(),
            \Zemit\Models\Setting::class => $this->modelsMap->getSettingClass(),
            \Zemit\Models\Lang::class => $this->modelsMap->getLangClass(),
            \Zemit\Models\Translate::class => $this->modelsMap->getTranslateClass(),
            \Zemit\Models\TranslateField::class => $this->modelsMap->getTranslateFieldClass(),
            \Zemit\Models\TranslateTable::class => $this->modelsMap->getTranslateTableClass(),
            \Zemit\Models\Workspace::class => $this->modelsMap->getWorkspaceClass(),
            \Zemit\Models\WorkspaceLang::class => $this->modelsMap->getWorkspaceLangClass(),
            \Zemit\Models\Page::class => $this->modelsMap->getPageClass(),
            \Zemit\Models\Post::class => $this->modelsMap->getPostClass(),
            \Zemit\Models\Template::class => $this->modelsMap->getTemplateClass(),
            \Zemit\Models\Table::class => $this->modelsMap->getTableClass(),
            \Zemit\Models\Field::class => $this->modelsMap->getFieldClass(),
            \Zemit\Models\Profile::class => $this->modelsMap->getProfileClass(),
            \Zemit\Models\Oauth2::class => $this->modelsMap->getOauth2Class(),
            \Zemit\Models\User::class => $this->modelsMap->getUserClass(),
            \Zemit\Models\UserType::class => $this->modelsMap->getUserTypeClass(),
            \Zemit\Models\UserGroup::class => $this->modelsMap->getUserGroupClass(),
            \Zemit\Models\UserRole::class => $this->modelsMap->getUserRoleClass(),
            \Zemit\Models\UserFeature::class => $this->modelsMap->getUserFeatureClass(),
            \Zemit\Models\Role::class => $this->modelsMap->getRoleClass(),
            \Zemit\Models\RoleRole::class => $this->modelsMap->getRoleRoleClass(),
            \Zemit\Models\RoleFeature::class => $this->modelsMap->getRoleFeatureClass(),
            \Zemit\Models\Group::class => $this->modelsMap->getGroupClass(),
            \Zemit\Models\GroupRole::class => $this->modelsMap->getGroupRoleClass(),
            \Zemit\Models\GroupType::class => $this->modelsMap->getGroupTypeClass(),
            \Zemit\Models\GroupFeature::class => $this->modelsMap->getGroupFeatureClass(),
            \Zemit\Models\Type::class => $this->modelsMap->getTypeClass(),
            \Zemit\Models\Feature::class => $this->modelsMap->getFeatureClass(),
        ];
        
        foreach ($classesMap as $class => $expected) {
            $actual = $this->modelsMap->getClassMap($class);
            $this->assertIsString($actual);
            $this->assertEquals($expected, $actual);
        }
        
        foreach ($classes as $expected => $actual) {
            $this->assertIsString($actual);
            $this->assertEquals($expected, $actual);
        }
        
        $this->assertIsArray($this->modelsMap->getModelsMap());
        
        // Map User to UserTest
        $this->modelsMap->setClassMap(\Zemit\Models\User::class, 'UserTest');
        $this->assertEquals('UserTest', $this->modelsMap->getUserClass());
        
        // Set a new mapping array
        $this->modelsMap->setModelsMap(['Test' => 'New', 'Test2' => 'New2']);
        $this->assertEquals('New', $this->modelsMap->getClassMap('Test'));
        $this->assertEquals('New2', $this->modelsMap->getClassMap('Test2'));
        
        // Set a new mapping
        $this->modelsMap->setClassMap('Test', 'New3');
        $this->assertEquals('New3', $this->modelsMap->getClassMap('Test'));
        
        // Set an existing mapping to null
        $this->modelsMap->setClassMap('Test', null);
        $this->assertEquals('Test', $this->modelsMap->getClassMap('Test'));
        
        // Remove an existing mapping
        $this->modelsMap->removeClassMap('Test');
        $this->assertEquals('Test', $this->modelsMap->getClassMap('Test'));
    }
}
