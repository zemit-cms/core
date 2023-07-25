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

use Phalcon\Mvc\ModelInterface;
use Zemit\Exception\CliException;
use Zemit\Utils;

trait DeploymentTrait
{
    
    
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
        
        foreach ($this->truncate as $table) {
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
        
        foreach ($this->drop as $table) {
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
        
        foreach ($this->engine as $table => $engine) {
            $response [] = $this->db->execute('ALTER TABLE ' . $this->db->escapeIdentifier($table) . ' ENGINE = ' . $engine);
        }
        
        return $response;
    }
    
    /**
     * Insert records
     * @throws CliException
     */
    public function insertAction(?string $models = null): array
    {
        $response = [
            'saved' => 0,
            'error' => [],
            'message' => [],
        ];
        
        $models = (!empty($models))? explode(',', $models) : null;
        
        foreach ($this->insert as $modelName => $insert) {
            if (is_array($models) && !in_array($modelName, $models, true)) {
                continue;
            }
            
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
                    if (empty($row['password']) && property_exists($entity, 'username')) {
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
