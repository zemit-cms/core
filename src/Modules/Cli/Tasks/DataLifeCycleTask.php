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
  zemit cli data-life-cycle <action> [--tables=<tables>] [--hard-delete=<hardDelete>]

Actions:
  main
  models

Options:
  --tables=<tables>               Comma seperated list of table to execute the data-life-cycle query on
  --hard-delete=<hardDelete>      Set 'true' to hard delete records if the soft-delete is enabled

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
    
    public function mainAction(): ?array
    {
        $response = [];
        $response ['models'] = $this->modelsAction();
        return $response;
    }
    
    public function modelsAction(): array
    {
        $response = [];
        
        $tables = array_flip(array_filter(array_map('trim', explode(',', $this->dispatcher->getParam('tables') ?? ''))));
        $hardDelete = $this->dispatcher->getParam('hardDelete') === 'true';
        
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
                $response[$source] = [
                    'deleted' => 0,
                    'messages' => [],
                ];
            }
            
            // skip empty query
            if (empty($policy['query'])) {
                continue;
            }
            
            $query = [$policy['query']];
            if (isset($policy['hardDelete']) && $hardDelete) {
                $query [] = $policy['hardDelete'];
            }
            
            // temporarily disable soft-delete if it is enabled and the hardDelete param is requested
            $modelSoftDeleteIsEnabled = $model->getSoftDeleteBehavior()->isEnabled();
            if ($hardDelete && $modelSoftDeleteIsEnabled) {
                $model->disableSoftDelete();
            }
            
            // find all record matching the defined retention policy
            $records = $model::findLifeCycle(...$query);
            assert($records instanceof ResultsetInterface);
            
            $callable = $policy['callable'] ?? function (Model $record, string $source, array &$response) {
                $deleted = $record->delete();
                $response[$source]['deleted'] += $deleted ? 1 : 0;
                
                $messages = $record->getMessages();
                if (!empty($messages)) {
                    $response[$source]['messages'] = array_merge($response[$source]['messages'], $messages);
                }
            };
            
            foreach ($records as $record) {
                $callable($record, $source, $response);
            }
            
            // re-enable soft-delete if it was previously enabled
            if ($hardDelete && $modelSoftDeleteIsEnabled) {
                $model->enableSoftDelete();
            }
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
