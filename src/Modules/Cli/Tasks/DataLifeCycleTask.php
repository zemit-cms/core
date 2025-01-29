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

use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\ResultsetInterface;
use Zemit\Modules\Cli\Task;
use Zemit\Mvc\Model;
use Zemit\Support\Utils;

class DataLifeCycleTask extends Task
{
    public string $cliDoc = <<<DOC
Usage:
  zemit cli data-life-cycle <action> [<params> ...]

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
        
        $parsedTables = [];
        foreach ($tables as $table) {
            // Explode each table by comma, trim values, and merge into $parsedTables
            $parsedTables = array_merge($parsedTables, array_map('trim', explode(',', $table)));
        }
        
        // Flip the array to swap keys and values
        $parsedTables = array_flip($parsedTables);
        
        foreach ($this->models as $modelClass => $policyName) {
            
            // retrieve configured model the policy
            $policy = $this->policies[$policyName] ?? [];
            
            // load an instance of the model class
            $model = $this->modelsManager->load($modelClass);
            assert($model instanceof Model);
            $source = $model->getSource();
            
            // whitelisted tables
            if (!empty($parsedTables) && !isset($parsedTables[$source])) {
                continue;
            }
            
            if (!isset($response[$source])) {
                $response[$source] = [
                    'deleted' => 0,
                    'messages' => [],
                ];
            }
            
            // temporarily disable soft-delete
            $model->disableSoftDelete();
            
            // find all record matching the defined retention policy
            $records = $model::findLifeCycle($policy['query'] ?? null);
            assert($records instanceof Resultset);
            
            $callable = $policy['callable'] ?? function (Model $record, string $source, array &$response) {
                $deleted =  $record->delete();
                $response[$source]['deleted'] += $deleted? 1 : 0;
                
                $messages = $record->getMessages();
                if (!empty($messages)) {
                    $response[$source]['messages']= array_merge($response[$source]['messages'], $messages);
                }
            };
            
            foreach ($records as $record) {
                $callable($record, $source, $response);
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
