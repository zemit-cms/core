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

namespace Zemit\Mvc\Controller\Traits\Query;

use Phalcon\Filter\Filter;
use Phalcon\Support\Collection;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractModel;
use Zemit\Mvc\Controller\Traits\Abstracts\AbstractParams;
use Zemit\Mvc\Controller\Traits\Abstracts\Query\AbstractGroup;

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
        ], $this->defaultGroup());
        
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
        // @todo use primary keys from model meta data instead
        return 'id';
    }
}
