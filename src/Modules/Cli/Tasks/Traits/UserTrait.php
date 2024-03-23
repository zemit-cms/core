<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks\Traits;

use Phalcon\Db\Column;
use Phalcon\Mvc\Model\Resultset;
use Zemit\Models\Role;
use Zemit\Models\User;
use Zemit\Models\UserRole;
use Zemit\Support\Utils;

trait UserTrait
{
    public array $tables = [];
    
    public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
        $this->addModelsPermissions();
    }
    
    public function getDefinitions()
    {
        $userClass = $this->config->getModelClass(User::class);
        $userRoleClass = $this->config->getModelClass(UserRole::class);
        return [
            $userClass => [
                'password' => function ($row) {
                    return $row->getUsername();
                },
                'passwordConfirm' => function ($row) {
                    return $row->getUsername();
                },
            ],
            $userRoleClass => [],
        ];
    }
    
    final public function createAction(string $email, ?string $password = null)
    {
        $response = [
            'errors' => [],
            'save' => 0
        ];
        
        $username = explode('@', $email)[0];
        $firstName = ucfirst($username);
        $lastName = ucfirst($username);
        $password ??= $username;
        
        $assign = [
            'email' => $email,
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'password' => $password,
            'passwordConfirm' => $password,
        ];
        
        $roleClass = $this->config->getModelClass(Role::class);
        $role = $roleClass::findFirst([
            'index = :role:',
            'bind' => ['role' => $username],
            'bindTypes' => ['role' => Column::BIND_PARAM_STR],
        ]);
        
        if ($role) {
            $assign['rolenode'] = [['roleId' => $role->getId()]];
        }
        
        $user = new User();
        $user->assign($assign);
        
        if (!$user->save()) {
            $response['errors'] = $user->getMessages();
        } else {
            $response['save']++;
        }
        
        return $response;
    }
    
    final public function roleAction(string $username, string $role)
    {
        $response = [
            'errors' => [],
            'save' => 0
        ];
        
        $userClass = $this->config->getModelClass(User::class);
        $user = $userClass::findFirst([
            'username = :username: or email = :email:',
            'bind' => ['username' => $username, 'email' => $username],
            'bindTypes' => ['username' => Column::BIND_PARAM_STR, 'email' => Column::BIND_PARAM_STR],
        ]);
        
        $roleClass = $this->config->getModelClass(Role::class);
        $role = $roleClass::findFirst([
            'index = :role:',
            'bind' => ['role' => $role],
            'bindTypes' => ['role' => Column::BIND_PARAM_STR],
        ]);
        
        if ($user && $role) {
            $user->assign([
                'rolenode' => [['roleId' => $role->getId()]],
            ]);
            if (!$user->save()) {
                $response['errors'] = $user->getMessages();
            } else {
                $response['save']++;
            }
        }
        
        return $response;
    }
    
    final public function passwordAction(?string $username = null, ?string $password = null): array
    {
        $response = [];
        
        $class = $this->models->getClassMap(User::class);
        $instance = $this->models->getInstance(User::class);
        $fields = $this->getDefinitions()[$class] ?? [];
            
        // Using a model (run validations, events, etc.)
        $response[$class] = [
            'errors' => [],
            'save' => 0,
        ];
        
        $list = empty($username) ? $instance::find() : $instance::find([
            'username = :username: or email = :email:',
            'bind' => ['username' => $username, 'email' => $username],
            'bindTypes' => ['username' => Column::BIND_PARAM_STR, 'email' => Column::BIND_PARAM_STR],
        ]);
        
        assert($list instanceof \Iterator);
        foreach ($list as $entity) {
            $assign = [];
            foreach ($fields as $field => $value) {
                $assign[$field] = is_callable($value) ? $value($entity) : $value;
            }
            if (!empty($password)) {
                $assign['password'] = $password;
                $assign['passwordConfirm'] = $password;
            }
            $entity->assign($assign);
            if (!$entity->save()) {
                $response[$class]['errors'] = $entity->getMessages();
            }
            else {
                $response[$class]['save']++;
            }
        }
        
        return $response;
    }
    
    public function addModelsPermissions(?array $tables = null): void
    {
        $permissions = [];
        $tables ??= $this->getDefinitions();
        foreach ($tables as $model => $entity) {
            $permissions[$model] = ['*'];
        }
        $this->config->merge([
            'permissions' => [
                'roles' => [
                    'cli' => [
                        'models' => $permissions,
                    ],
                ],
            ],
        ]);
    }
}
