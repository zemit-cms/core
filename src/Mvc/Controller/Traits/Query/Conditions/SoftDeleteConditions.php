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

trait SoftDeleteConditions
{
    protected ?Collection $softDeleteConditions;
    
    public function initializeSoftDeleteConditions()
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
