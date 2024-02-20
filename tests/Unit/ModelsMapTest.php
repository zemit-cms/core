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

namespace Unit;

use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;
use Zemit\Bootstrap\Config;
use Zemit\Support\ModelsMap;
use Zemit\Tests\Unit\AbstractUnit;

/**
 * Class ProviderTest
 * @package Tests\Unit
 */
class ModelsMapTest extends AbstractUnit
{
    use ModelsMap;
    
    public function setUp(): void
    {
        $this->di = new Di();
        $this->di->set('config', new Config());
    }
    
    public function getDI(): DiInterface
    {
        return $this->di;
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
            \Zemit\Models\Backup::class => $this->getBackupClass(),
            \Zemit\Models\Audit::class => $this->getAuditClass(),
            \Zemit\Models\AuditDetail::class => $this->getAuditDetailClass(),
            \Zemit\Models\Log::class => $this->getLogClass(),
            \Zemit\Models\Email::class => $this->getEmailClass(),
            \Zemit\Models\Job::class => $this->getJobClass(),
            \Zemit\Models\File::class => $this->getFileClass(),
            \Zemit\Models\Session::class => $this->getSessionClass(),
            \Zemit\Models\Flag::class => $this->getFlagClass(),
            \Zemit\Models\Setting::class => $this->getSettingClass(),
            \Zemit\Models\Lang::class => $this->getLangClass(),
            \Zemit\Models\Translate::class => $this->getTranslateClass(),
            \Zemit\Models\TranslateField::class => $this->getTranslateFieldClass(),
            \Zemit\Models\TranslateTable::class => $this->getTranslateTableClass(),
            \Zemit\Models\Workspace::class => $this->getSiteClass(),
            \Zemit\Models\WorkspaceLang::class => $this->getSiteLangClass(),
            \Zemit\Models\Page::class => $this->getPageClass(),
            \Zemit\Models\Post::class => $this->getPostClass(),
            \Zemit\Models\Template::class => $this->getTemplateClass(),
            \Zemit\Models\Table::class => $this->getChannelClass(),
            \Zemit\Models\Field::class => $this->getFieldClass(),
            \Zemit\Models\Profile::class => $this->getProfileClass(),
            \Zemit\Models\User::class => $this->getUserClass(),
            \Zemit\Models\UserType::class => $this->getUserTypeClass(),
            \Zemit\Models\UserGroup::class => $this->getUserGroupClass(),
            \Zemit\Models\UserRole::class => $this->getUserRoleClass(),
            \Zemit\Models\UserFeature::class => $this->getUserFeatureClass(),
            \Zemit\Models\Role::class => $this->getRoleClass(),
            \Zemit\Models\RoleRole::class => $this->getRoleRoleClass(),
            \Zemit\Models\RoleFeature::class => $this->getRoleFeatureClass(),
            \Zemit\Models\Group::class => $this->getGroupClass(),
            \Zemit\Models\GroupRole::class => $this->getGroupRoleClass(),
            \Zemit\Models\GroupType::class => $this->getGroupTypeClass(),
            \Zemit\Models\GroupFeature::class => $this->getGroupFeatureClass(),
            \Zemit\Models\Type::class => $this->getTypeClass(),
            \Zemit\Models\Feature::class => $this->getFeatureClass(),
        ];
        
        foreach ($classesMap as $class => $expected) {
            $actual = $this->getClassMap($class);
            $this->assertIsString($actual);
            $this->assertEquals($expected, $actual);
        }
        
        foreach ($classes as $expected => $actual) {
            $this->assertIsString($actual);
            $this->assertEquals($expected, $actual);
        }
        
        $this->assertIsArray($this->getModelsMap());
        
        // Map User to UserTest
        $this->setClassMap(\Zemit\Models\User::class, 'UserTest');
        $this->assertEquals('UserTest', $this->getUserClass());
        
        // Set a new mapping array
        $this->setModelsMap(['Test' => 'New', 'Test2' => 'New2']);
        $this->assertEquals('New', $this->getClassMap('Test'));
        $this->assertEquals('New2', $this->getClassMap('Test2'));
        
        // Set a new mapping
        $this->setClassMap('Test', 'New3');
        $this->assertEquals('New3', $this->getClassMap('Test'));
        
        // Set an existing mapping to null
        $this->setClassMap('Test', null);
        $this->assertEquals('Test', $this->getClassMap('Test'));
        
        // Remove an existing mapping
        $this->removeClassMap('Test');
        $this->assertEquals('Test', $this->getClassMap('Test'));
    }
}
