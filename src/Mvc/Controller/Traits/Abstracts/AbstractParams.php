<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\Traits\Abstracts;

trait AbstractParams
{
    abstract public function getParam(string $key, array|string|null $filters = null, mixed $default = null, array $params = null): mixed;
    
    abstract public function getParams(array $filters = null): array;
}
