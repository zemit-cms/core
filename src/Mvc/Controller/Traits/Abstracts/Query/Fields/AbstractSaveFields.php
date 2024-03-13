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
 * The AbstractSaveFields trait provides a base implementation for saving fields.
 */
trait AbstractSaveFields
{
    abstract public function initializeSaveFields(): void;
    
    abstract public function setSaveFields(?Collection $saveFields): void;
    
    abstract public function getSaveFields(): ?Collection;
    
}
