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
 * The AbstractExposeFields trait provides a base implementation for exposing fields.
 */
trait AbstractExposeFields
{
    abstract public function initializeExposeFields(): void;
    
    abstract public function setExposeFields(?Collection $exposeFields): void;
    
    abstract public function getExposeFields(): ?Collection;
}
