<?php

declare(strict_types=1);

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
    
    /**
     * Configuration array for defining the data lifecycle settings,
     * including the models and policies applicable.
     */
    public array $dataLifeCycleConfig = [
        'models' => [],
        'policies' => [],
    ];
    
    /**
     * Initializes the configuration for data life cycle and sets up permissions for models.
     *
     * @return void
     */
    public function initialize(): void
    {
        Utils::setUnlimitedRuntime();
        
        $this->dataLifeCycleConfig = $this->config->pathToArray('dataLifeCycle') ?? [];
        $this->dataLifeCycleConfig['models'] ??= [];
        $this->dataLifeCycleConfig['policies'] ??= [];
        
        $this->addModelsPermissions();
    }
    
    /**
     * Executes the main action by processing the provided table names.
     *
     * This method delegates processing to the modelsAction method with the given
     * table names. The results are then returned in an associative array under the
     * 'models' key.
     *
     * @param string ...$tables A variable number of table names to process.
     * @return array|null An associative array with the processed data under the 'models'
     *                    key, or null if no data is returned.
     */
    #[\Override]
    public function mainAction(string ...$tables): ?array
    {
        $response = [];
        $response ['models'] = $this->modelsAction(...$tables);
        return $response;
    }
    
    /**
     * Processes lifecycle models based on a defined retention policy and tables whitelist,
     * executing actions such as deletion and collecting associated messages.
     *
     * The method retrieves the lifecycle models and applies retention policies to the records.
     * It processes only whitelisted tables if specified, and skips models not matching the input.
     * The response contains information about the number of records processed (deleted) and
     * any associated messages per table.
     *
     * @param string ...$tables A variadic list of table names, which may include comma-separated
     *                          values. These are used to filter models by matching the table names.
     *                          Only matched table records are processed.
     * @return array An associative array where keys are table names and values are arrays
     *               containing the count of deleted records ('deleted') and any messages
     *               ('messages') encountered during processing.
     */
    public function modelsAction(string ...$tables): array
    {
        $models = $this->getDataLifeCycleModels();
        
        // no model to process
        if (empty($models)) {
            return [];
        }
        
        // prepare response
        $response = [];
        
        // prepare tables to process
        $parsedTables = [];
        foreach ($tables as $table) {
            // Explode each table by comma, trim values, and merge into $parsedTables
            $parsedTables = array_merge($parsedTables, array_map('trim', explode(',', $table)));
        }
        
        // Flip the array to swap keys and values
        $parsedTables = array_flip($parsedTables);
        
        // loop through models to process
        foreach ($models as $modelClass => $policyName) {
            // retrieve configured model the policy
            $policy = $this->getDataLifeCyclePolicies()[$policyName] ?? [];
            
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
            
            $callable = $policy['callable'] ?? function (Model $record, string $source, array &$response): void {
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
            
            // re-enable soft-delete
            $model->enableSoftDelete();
        }
        
        return $response;
    }
    
    /**
     * Retrieves the data lifecycle models from the configuration.
     *
     * @return array An array of data lifecycle models or an empty array if not configured.
     */
    public function getDataLifeCycleModels(): array
    {
        return $this->dataLifeCycleConfig['models'] ?? [];
    }
    
    /**
     * Retrieves the data lifecycle policies from the configuration.
     *
     * @return array An array of data lifecycle policies or an empty array if not configured.
     */
    public function getDataLifeCyclePolicies(): array
    {
        return $this->dataLifeCycleConfig['policies'] ?? [];
    }
    
    /**
     * Adds permissions for the specified models to the configuration.
     *
     * If no models are provided, the method retrieves models from the data lifecycle.
     * Each model is granted full permissions ('*'), and these permissions are merged
     * into the configuration under the 'cli' role.
     *
     * @param array|null $models An associative array of models to add permissions for,
     *                           where keys are the model names and values are entities.
     *                           If null, the models are retrieved using the data lifecycle logic.
     * @return void
     */
    public function addModelsPermissions(?array $models = null): void
    {
        $models ??= $this->getDataLifeCycleModels();
        
        // no models to add
        if (empty($models)) {
            return;
        }
        
        // add the permissions
        $this->config->merge([
            'permissions' => [
                'roles' => [
                    'cli' => [
                        'models' => array_map(function ($entity) {
                            return ['*'];
                        }, $models),
                    ],
                ],
            ],
        ], true);
    }
}
