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

use Phalcon\Mvc\Model\ResultsetInterface;
use Zemit\Modules\Cli\Task;
use Zemit\Mvc\Model;
use Zemit\Support\Utils;

class DataLifeCycleTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  php zemit cli data-life-cycle <action> [<params> ...]

Options:
  task: cache
  action: clear


DOC;
    
    public ?array $models = null;
    
    public ?array $policies = null;
    
    public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
        
        $dataLifeCycleConfig = $this->config->pathToArray('dataLifeCycle');
        $this->models ??= $dataLifeCycleConfig['models'] ?? [];
        $this->policies ??= $dataLifeCycleConfig['policies'] ?? [];
        
        $this->addModelsPermissions();
    }
    
    /**
     * Default action
     */
    public function mainAction(string ...$tables): ?array
    {
        $response = [];

//        $response ['backup'] = $this->backupAction();
        $response ['models'] = $this->modelsAction(...$tables);
        
        return $response;
    }
    
    public function modelsAction(string ...$tables): array
    {
        $response = [];
        
        foreach ($tables as &$table) {
            $table = array_map('trim', explode(',', $table));
        }
        $tables = array_flip(array_merge_recursive(...$tables));
        
        foreach ($this->models as $modelClass => $policyName) {
            
            // retrieve configured model the policy
            $policy = $this->policies[$policyName] ?? null;
            
            // load an instance of the model class
            $model = $this->modelsManager->load($modelClass);
            assert($model instanceof Model);
            $source = $model->getSource();
            
            // whitelisted tables
            if (!empty($tables) && !isset($tables[$source])) {
                continue;
            }
            
            if (!isset($response[$source])) {
                $response[$source] = [];
            }
            
            // find all record matching the defined retention policy
            $records = $model::findLifeCycle($policy['query'] ?? null);
            assert($records instanceof ResultsetInterface);
            
            // temporarily disable soft-delete
            $model->disableSoftDelete();
            
            foreach ($records as $record) {
                assert($record instanceof Model);
                
                // disable soft delete
                $record->disableSoftDelete();
                
                // delete record
                $response[$source] []= [
                    'primaryKeys' => $record->getPrimaryKeysValues(),
                    'deleted' => $record->delete(),
                ];
            }
            
            // re-enable soft-delete
            $model->enableSoftDelete();
        }
        
        return $response;
    }
    
    public function addModelsPermissions(?array $models = null): void
    {
        $permissions = [];
        $models ??= $this->models;
        if ($models) {
            foreach ($models as $model => $entity) {
                $permissions[$model] = ['*'];
            }
        }
        $this->config->merge([
            'permissions' => [
                'roles' => [
                    'cli' => [
                        'models' => $permissions,
                    ],
                ],
            ],
        ], true);
    }
}
