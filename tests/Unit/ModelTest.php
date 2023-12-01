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

namespace Zemit\Tests\Unit;

use Phalcon\Db\Column;
use Zemit\Models\Role;
use Zemit\Models\User;
use Zemit\Models\UserRole;

class ModelTest extends AbstractUnit
{
    public function prepareTests(): void
    {
        $db = $this->getDb();
        $db->execute('TRUNCATE TABLE ' . $db->escapeIdentifier((new User())->getSource()));
        $db->execute('TRUNCATE TABLE ' . $db->escapeIdentifier((new UserRole())->getSource()));
        $db->execute('TRUNCATE TABLE ' . $db->escapeIdentifier((new Role())->getSource()));
        $this->addModelsPermissions([User::class => ['*']]);
        $this->addModelsPermissions([UserRole::class => ['*']]);
        $this->addModelsPermissions([Role::class => ['*']]);
        $this->assertEquals('user', (new User())->getSource());
        $this->assertEquals('user_role', (new UserRole())->getSource());
        $this->assertEquals('role', (new Role())->getSource());
    }
    
    public function testModelSave(): void
    {
        $this->prepareTests();
        
        $user = new User();
        $user->setUsername('test');
        $user->setFirstName('test');
        $user->setLastName('test');
        $user->setEmail('test@test.tld');
        
        // Create
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        // Update
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        // Fetch
        $user = User::findFirst([
            'username = :username:',
            'bind' => ['username' => 'test'],
            'bindTypes' => ['username' => Column::BIND_PARAM_STR],
        ]);
        $this->assertInstanceOf(User::class, $user);
        
        // Update fetched
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
    }
    
    public function testModelRelationship(): void
    {
        $this->prepareTests();
        
        $user = new User();
        $user->assign([
            'username' => 'test',
            'firstName' => 'test',
            'lastName' => 'test',
            'email' => 'test@test.tld',
            'rolelist' => [
                false,
                [
                    'index' => 'test',
                    'label' => 'test',
                ],
                [
                    'index' => 'test2',
                    'label' => 'test2',
                ],
                [
                    'index' => 'test3',
                    'label' => 'test3',
                ],
            ],
        ]);
        
        // Create
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        $this->roleFindAssert('test');
        $this->roleFindAssert('test2');
        $this->roleFindAssert('test3');
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 1']);
        $this->assertCount(3, $roleList);
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 0']);
        $this->assertCount(0, $roleList);
        
        // append more
        $user->assign(['rolelist' => [
            true,
            [
                'index' => 'test4',
                'label' => 'test4',
            ],
        ]]);
        
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        $this->roleFindAssert('test');
        $this->roleFindAssert('test2');
        $this->roleFindAssert('test3');
        $this->roleFindAssert('test4');
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 1']);
        $this->assertCount(4, $roleList);
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 0']);
        $this->assertCount(0, $roleList);
        
        // remove and append
        $user->assign(['rolelist' => [
            false,
            [
                'index' => 'test5',
                'label' => 'test5',
            ],
            [
                'index' => 'test6',
                'label' => 'test6',
            ],
        ]]);
        
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        $this->roleFindAssert('test');
        $this->roleFindAssert('test2');
        $this->roleFindAssert('test3');
        $this->roleFindAssert('test4');
        $this->roleFindAssert('test5');
        $this->roleFindAssert('test6');
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 1']);
        $this->assertCount(2, $roleList);
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 0']);
        $this->assertCount(4, $roleList);
        
        // add by id
        $user->assign(['rolelist' => [
            true,
            1,
            2,
            3,
            4,
        ]]);
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 1']);
        $this->assertCount(6, $roleList);
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 0']);
        $this->assertCount(0, $roleList);
        
        // remove by id
        $user->assign(['rolelist' => [
            false,
            1,
            2,
            3,
            4,
        ]]);
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 1']);
        $this->assertCount(4, $roleList);
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 0']);
        $this->assertCount(2, $roleList);
        
        // mixed
        $user->assign(['rolelist' => [
            false, // delete everything else
            1, // using int
            ['id' => 2], // using id only
            ['id' => 3, 'index' => 'changed3'], // edit
            ['id' => 3, 'label' => 'changed3'], // edit twice
            '4', // using string
            5, // restore
            6, // restore
            [
                'index' => 'test7',
                'label' => 'test7',
            ], // new entity
            (new Role(['index' => 'test8']))->assign(['label' => 'test8']),
        ]]);
        $save = $user->save();
        $messages = $user->getMessages();
        
        $this->assertEmpty($messages, json_encode($messages));
        $this->assertTrue($save);
        
        $this->roleFindAssert('test');
        $this->roleFindAssert('test2');
        $this->roleFindAssert('changed3');
        $this->roleFindAssert('test4');
        $this->roleFindAssert('test5');
        $this->roleFindAssert('test6');
        $this->roleFindAssert('test7');
        $this->roleFindAssert('test8');
        
        $roleList = $user->getRoleList(['[' . UserRole::class . '].deleted <> 1']);
        $this->assertCount(8, $roleList);
    }
    
    public function roleFindAssert(string $string)
    {
        $role = Role::findFirst(['index = :index:', 'bind' => ['index' => $string]]);
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals($string, $role->readAttribute('label'));
        $this->assertEquals($string, $role->readAttribute('index'));
        $this->assertEquals(0, $role->readAttribute('deleted'));
        $this->assertNotEmpty($role->readAttribute('createdAt'));
        return $role;
    }
    
    public function addModelsPermissions(array $models = []): void
    {
        $permissions = [];
        foreach ($models as $class => $permission) {
            $permissions[$class] = $permission;
        }
        $this->getConfig()->merge([
            'permissions' => [
                'roles' => [
                    'everyone' => [
                        'models' => $permissions,
                    ],
                ],
            ],
        ]);
    }
}
