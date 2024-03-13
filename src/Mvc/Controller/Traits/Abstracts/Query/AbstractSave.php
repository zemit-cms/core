<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts\Query;

use Phalcon\Mvc\ModelInterface;

trait AbstractSave
{
    abstract protected function save(): array;
    
    abstract public function beforeAssign(ModelInterface &$entity, array &$assign, ?array &$whiteList, ?array &$columnMap): void;
}
