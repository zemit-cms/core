<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Modules\Api\Controllers;

use Phalcon\Mvc\ModelInterface;
use Phalcon\Support\Collection;
use Zemit\Models\Table;
use Zemit\Modules\Api\Controller;
use Zemit\Mvc\Model\Dynamic;

class RecordController extends Controller
{
    protected ?int $limit = 10000;
    protected ?int $maxLimit = 10000;
    
    public function listExpose(iterable $items, ?array $expose = null): array
    {
        return (array)$items;
    }
    
    public function initializeSearchFields(): void
    {
        // uuid is always searchable
        $collection = new Collection([
            'uuid',
        ]);
        
        // appends searchable fields from table columns
        $advanced = $this->getParam('advanced') ?? [];
        if (isset($advanced['tableUuid'])) {
            $table = Table::findFirst([
                'uuid = :uuid:',
                'bind' => ['uuid' => $advanced['tableUuid']]
            ]);
            $columns = $table->getColumnList();
            foreach ($columns as $column) {
                $collection->set($column->getUuid(), $column->getUuid());
            }
        }
        
        $this->setSearchFields($collection);
    }
    
    public function initializeFilterFields(): void
    {
        $this->setFilterFields(new Collection([
            'workspaceId',
            'tableId',
        ]));
    }
    
    public function hasAdvanced(string $key)
    {
        $advanced = $this->getParam('advanced') ?? [];
        return isset($advanced[$key]);
    }
    
    public function getModelName(): ?string
    {
        if ($this->hasAdvanced('tableUuid')) {
            $this->modelName = Dynamic::class;
        } else {
            parent::getModelName();
        }
        
        return $this->modelName;
    }
    
    public function loadModel(?string $modelName = null): ModelInterface
    {
        $modelName ??= $this->getModelName() ?? '';
//        $modelInstance = $this->modelsManager->load($modelName);
        $modelInstance = new $modelName();
        if ($modelInstance instanceof Dynamic) {
            $advanced = $this->getParam('advanced') ?? [];
            $modelInstance->setDynamicSource($advanced['tableUuid'] ?? 'dynamic');
        }
        assert($modelInstance instanceof ModelInterface);
        return $modelInstance;
    }
}
