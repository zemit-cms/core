<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query\Fields;

use Phalcon\Support\Collection;

/**
 * The AbstractMapFields trait provides a base implementation for mapping fields.
 */
trait AbstractMapFields
{
    abstract public function initializeMapFields(): void;
    
    abstract public function setMapFields(?Collection $mapFields): void;
    
    abstract public function getMapFields(): ?Collection;
    
}
