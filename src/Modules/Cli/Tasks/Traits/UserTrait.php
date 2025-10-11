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
        return [
            $this->models->getUserClass() => [
                'password' => function ($row) {
                    return $row->getEmail();
                },
                'passwordConfirm' => function ($row) {
                    return $row->getEmail();
                },
            ],
            $this->models->getUserRoleClass() => [],
        ];
    }
    
    final public function createAction(string $email, ?string $password = null)
    {
        $response = [
            'errors' => [],
            'save' => 0
        ];
        
        $role = explode('@', $email)[0];
        $firstName = ucfirst($role);
        $lastName = ucfirst($role);
        $password ??= $role;
        
        $assign = [
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'password' => $password,
            'passwordConfirm' => $password,
        ];
        
        $roleEntity = $this->models->getRole()::findFirst([
            'key = :role:',
            'bind' => ['role' => $role],
            'bindTypes' => ['role' => Column::BIND_PARAM_STR],
        ]);
        
        if ($roleEntity) {
            $assign['rolenode'] = [['roleId' => $roleEntity->getId()]];
        }
        
        $userEntity = new User();
        $userEntity->assign($assign);
        
        if (!$userEntity->save()) {
            $response['errors'] = $userEntity->getMessages();
        } else {
            $response['save']++;
        }
        
        return $response;
    }
    
    final public function roleAction(string $email, string $role)
    {
        $response = [
            'errors' => [],
            'save' => 0
        ];
        
        $userEntity = $this->models->getUser()::findFirst([
            'email = :email:',
            'bind' => ['email' => $email],
            'bindTypes' => ['email' => Column::BIND_PARAM_STR],
        ]);
        
        $roleEntity = $this->models->getRole()::findFirst([
            'key = :role:',
            'bind' => ['role' => $role],
            'bindTypes' => ['role' => Column::BIND_PARAM_STR],
        ]);
        
        if ($userEntity && $roleEntity) {
            $userEntity->assign([
                'rolenode' => [['roleId' => $roleEntity->getId()]],
            ]);
            if (!$userEntity->save()) {
                $response['errors'] = $userEntity->getMessages();
            } else {
                $response['save']++;
            }
        }
        
        return $response;
    }
    
    final public function passwordAction(?string $username = null, ?string $password = null): array
    {
        $response = [];
        
        $class = $this->models->getUserClass();
        $fields = $this->getDefinitions()[$class] ?? [];
        
        // Using a model (run validations, events, etc.)
        $response[$class] = [
            'errors' => [],
            'save' => 0,
        ];
        
        $userInstance = $this->models->getUser();
        $list = empty($username) ? $userInstance::find() : $userInstance::find([
            'email = :email:',
            'bind' => ['email' => $username],
            'bindTypes' => ['email' => Column::BIND_PARAM_STR],
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
        
        $this->acl->setOption('permissions', $this->config->pathToArray('permissions') ?? []);
    }
}
