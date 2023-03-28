<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Cli\Tasks;

use Phalcon\Mvc\ModelInterface;
use Zemit\Exception\CliException;
use Zemit\Models\Lang;
use Zemit\Models\Site;
use Zemit\Modules\Cli\Task;
use Zemit\Models\Role;
use Zemit\Models\Setting;
use Zemit\Models\Template;
use Zemit\Utils;

class DeploymentTask extends Task
{
    /**
     * @var string
     */
    public string $cliDoc = <<<DOC
Usage:
  php zemit cli deployment <action> [<params> ...]

Options:
  task: cache
  action: clear


DOC;
    
    public array $drops = [];
    
    /**
     * Tables to truncate
     * @var array Raw DB table sources
     */
    private array $truncates = [
        'audit',
        'audit_detail',
        'category',
        'channel',
        'data',
        'email',
        'email_file',
        'field',
        'file',
        'file_relation',
        'flag',
        'group',
        'group_role',
        'group_type',
        'lang',
        'log',
        'menu',
        'meta',
        'page',
        'phalcon_migrations',
        'post',
        'post_category',
        'role',
        'session',
        'setting',
        'site',
        'site_lang',
        'template',
        'translate',
        'translate_field',
        'translate_table',
        'type',
        'user',
        'user_group',
        'user_role',
        'user_type',
        'validator',
    ];
    
    private array $engines = [];
    
    public array $insert = [
        Role::class => [
            ['index' => 'dev', 'label' => 'Developer', 'userlist' => [
                ['username' => 'dev', 'email' => 'dev@zemit.com', 'firstName' => 'Developer', 'lastName' => 'Zemit'],
            ]],
            ['index' => 'admin', 'label' => 'Administrator'],
            ['index' => 'user', 'label' => 'User'],
            ['index' => 'guest', 'label' => 'Guest'],
            ['index' => 'everyone', 'label' => 'Everyone'],
        ],
//        User::class => [
//            ['username' => 'dev', 'email' => 'dev@zemit.com', 'firstName' => 'Developer', 'lastName' => 'Zemit'],
//        ],
        Lang::class => [
            ['label' => 'Francais', 'code' => 'fr'],
            ['label' => 'English', 'code' => 'en'],
            ['label' => 'Spanish', 'code' => 'sp'],
        ],
        Site::class => [
            ['name' => 'Zemit CMS', 'title' => 'Zemit CMS', 'description' => ''],
        ],
        Template::class => [
        ],
        Setting::class => [
        ],
    ];
    
    public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
        $this->addModelsPermissions();
    }
    
    /**
     * Default action
     * @throws CliException
     */
    public function mainAction(): ?array
    {
        $response = [];
        
        $response ['truncate'] = $this->truncateAction();
        $response ['drop'] = $this->dropAction();
        $response ['engine'] = $this->fixEngineAction();
        $response ['insert'] = $this->insertAction();
        
        return $response;
    }
    
    /**
     * Truncate tables
     */
    public function truncateAction(): array
    {
        $response = [];
        
        foreach ($this->truncates as $table) {
            $response [] = $this->db->execute('TRUNCATE TABLE ' . $this->db->escapeIdentifier($table));
        }
        
        return $response;
    }
    
    /**
     * Drops tables
     */
    public function dropAction(): array
    {
        $response = [];
        
        foreach ($this->drops as $table) {
            $response [] = $this->db->execute('DROP TABLE IF EXISTS ' . $this->db->escapeIdentifier($table));
        }
        
        return $response;
    }
    
    /**
     * Fix tables engine
     */
    public function fixEngineAction(): array
    {
        $response = [];
        
        foreach ($this->engines as $table => $engine) {
            $response [] = $this->db->execute('ALTER TABLE ' . $this->db->escapeIdentifier($table) . ' ENGINE = ' . $engine);
        }
        
        return $response;
    }
    
    /**
     * Insert records
     * @throws CliException
     */
    public function insertAction(): array
    {
        $response = [
            'saved' => 0,
            'error' => [],
            'message' => [],
        ];
        
        foreach ($this->insert as $modelName => $insert) {
            
            foreach ($insert as $key => $row) {
                $entity = new $modelName();
                assert($entity instanceof ModelInterface);
                
                $assign = isset($row[0]) ? array_combine($entity->columnMap(), $row) : $row;
                if (!$assign) {
                    throw new CliException('Can\'t assign row #' . $key . ' for model `' . $modelName . '`.');
                } else {
                    $entity->assign($assign);
                }
                
                // Automagically fill passwords
                if (property_exists($entity, 'password')) {
                    if (empty($row['password'])) {
                        $entity->assign(['password' => $row['username'], 'passwordConfirm' => $row['username']]);
                    }
                    elseif (empty($row['passwordConfirm'])) {
                        $entity->assign(['passwordConfirm' => $row['password']]);
                    }
                }
                
                if (!$entity->save()) {
                    $response['error'][$modelName][] = $entity->toArray();
                    
                    foreach ($entity->getMessages() as $message) {
                        $response['message'][$modelName][] = $message;
                    }
                }
                else {
                    $response['saved']++;
                }
            }
        }
        
        return $response;
    }
    
    public function addModelsPermissions(?array $tables = null): void
    {
        $permissions = [];
        $tables ??= $this->insert;
        foreach ($tables as $model => $entity) {
            $permissions[$model] = ['*'];
        }
        $this->config->merge([
            'permissions' => [
                'roles' => [
                    'cli' => [
                        'models' => $permissions
                    ],
                ]
            ]
        ]);
    }
}
