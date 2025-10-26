<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Query\Conditions;

use Phalcon\Db\Column;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractQuery;

trait SoftDeleteConditions
{
    use AbstractModel;
    use AbstractQuery;
    
    protected ?Collection $softDeleteConditions = null;
    
    public function initializeSoftDeleteConditions(): void
    {
        $this->setSoftDeleteConditions(new Collection([
            'default' => $this->defaultSoftDeleteCondition(),
        ], false));
    }
    
    public function setSoftDeleteConditions(?Collection $softDeleteConditions): void
    {
        $this->softDeleteConditions = $softDeleteConditions;
    }
    
    public function getSoftDeleteConditions(): ?Collection
    {
        return $this->softDeleteConditions;
    }
    
    public function defaultSoftDeleteCondition(): array|string|null
    {
        $field = $this->appendModelName('deleted');
        $bindKey = $this->generateBindKey('deleted');
        
        return [
            "{$field} = :{$bindKey}:",
            [$bindKey => 0],
            [$bindKey => Column::BIND_PARAM_INT],
        ];
    }
}
