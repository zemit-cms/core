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

namespace Zemit\Tests\Unit\Support;

use Zemit\Support\Models;
use Zemit\Tests\Unit\AbstractUnit;

class ModelsTest extends AbstractUnit
{
    public Models $models;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->models = new Models();
    }
    
    public function testInstances(): void
    {
        // no instance should be loaded
        $this->assertEquals([], $this->models->getInstances());
        
        // load all instances
        $instances = [
            \Zemit\Models\Backup::class => $this->models->getBackup(),
            \Zemit\Models\Audit::class => $this->models->getAudit(),
            \Zemit\Models\AuditDetail::class => $this->models->getAuditDetail(),
            \Zemit\Models\Log::class => $this->models->getLog(),
            \Zemit\Models\Email::class => $this->models->getEmail(),
            \Zemit\Models\Job::class => $this->models->getJob(),
            \Zemit\Models\File::class => $this->models->getFile(),
            \Zemit\Models\Session::class => $this->models->getSession(),
            \Zemit\Models\Flag::class => $this->models->getFlag(),
            \Zemit\Models\Setting::class => $this->models->getSetting(),
            \Zemit\Models\Lang::class => $this->models->getLang(),
            \Zemit\Models\Translate::class => $this->models->getTranslate(),
            \Zemit\Models\Workspace::class => $this->models->getWorkspace(),
            \Zemit\Models\WorkspaceLang::class => $this->models->getWorkspaceLang(),
            \Zemit\Models\Page::class => $this->models->getPage(),
            \Zemit\Models\Post::class => $this->models->getPost(),
            \Zemit\Models\Template::class => $this->models->getTemplate(),
            \Zemit\Models\Table::class => $this->models->getTable(),
            \Zemit\Models\Profile::class => $this->models->getProfile(),
            \Zemit\Models\Oauth2::class => $this->models->getOauth2(),
            \Zemit\Models\User::class => $this->models->getUser(),
            \Zemit\Models\UserType::class => $this->models->getUserType(),
            \Zemit\Models\UserGroup::class => $this->models->getUserGroup(),
            \Zemit\Models\UserRole::class => $this->models->getUserRole(),
            \Zemit\Models\UserFeature::class => $this->models->getUserFeature(),
            \Zemit\Models\Role::class => $this->models->getRole(),
            \Zemit\Models\RoleRole::class => $this->models->getRoleRole(),
            \Zemit\Models\RoleFeature::class => $this->models->getRoleFeature(),
            \Zemit\Models\Group::class => $this->models->getGroup(),
            \Zemit\Models\GroupRole::class => $this->models->getGroupRole(),
            \Zemit\Models\GroupType::class => $this->models->getGroupType(),
            \Zemit\Models\GroupFeature::class => $this->models->getGroupFeature(),
            \Zemit\Models\Type::class => $this->models->getType(),
            \Zemit\Models\Feature::class => $this->models->getFeature(),
        ];
        
        // check instance types
        foreach ($instances as $expected => $actual) {
            $this->assertInstanceOf($expected, $actual);
            $this->assertInstanceOf($expected, $this->models->getInstance($expected));
        }
        
        // all instances should be loaded
        $this->assertSame($instances, $this->models->getInstances());
        
        // test unset instance
        $this->models->unsetInstance(\Zemit\Models\Backup::class);
        unset($instances[\Zemit\Models\Backup::class]);
        $this->assertSame($instances, $this->models->getInstances());
    }
}
