<?php

declare(strict_types=1);

/**
 * This file is part of the Phalcon Kit.
 *
 * (c) Phalcon Kit Team
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace PhalconKit\Mvc\Controller\Traits\Query;

use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;
use PhalconKit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use PhalconKit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use PhalconKit\Mvc\Controller\Traits\Abstracts\Query\AbstractGroup;

trait Group
{
    use AbstractGroup;
    
    use AbstractParams;
    use AbstractModel;
    
    protected ?Collection $group = null;
    
    public function initializeGroup(): void
    {
        $group = $this->getParam('group', [
            Filter::FILTER_STRING,
            Filter::FILTER_TRIM
        ], $this->defaultGroup() ?? '');
        
        if (!isset($group)) {
            $this->setGroup(null);
        }
        
        if (!is_array($group)) {
            $group = explode(',', $group);
        }
        
        $collection = new Collection([], false);
        foreach ($group as $key => $item) {
            $item = trim($item);
            if (is_int($key)) {
                $collection->set($item, $this->appendModelName($item));
            } else {
                $collection->set(trim($key), $this->appendModelName($item));
            }
        }
        
        $this->setGroup($collection);
    }
    
    public function setGroup(?Collection $group): void
    {
        $this->group = $group;
    }
    
    public function getGroup(): ?Collection
    {
        return $this->group;
    }
    
    public function defaultGroup(): array|string|null
    {
        return (isset($this->joins) && count($this->joins) > 0) ?
            $this->modelsMetadata->getPrimaryKeyAttributes($this->loadModel())
            : null;
    }
}
