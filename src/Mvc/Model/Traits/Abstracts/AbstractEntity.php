<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\Traits\Abstracts;

trait AbstractEntity
{
    abstract public function readAttribute(string $attribute): mixed;
    
    abstract public function writeAttribute(string $attribute, $value);
}
