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

use Phalcon\Support\Collection;
use Zemit\Modules\Api\Controller;

class WorkspaceController extends Controller
{
    protected ?int $limit = 100;
    protected ?int $maxLimit = 100;
    
    #[\Override]
    public function initializeWith(): void
    {
        $this->setWith(new Collection([
            'LangList',
            'TableList.ColumnList'
        ]));
    }
    
    #[\Override]
    public function listExpose(iterable $items, ?array $expose = null): array
    {
        return (array)$items;
    }
    
    #[\Override]
    public function initializeSearchFields(): void
    {
        $this->setSearchFields(new Collection([
            'uuid',
            'name',
            'description'
        ]));
    }
}
