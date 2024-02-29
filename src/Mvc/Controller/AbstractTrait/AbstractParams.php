<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller\AbstractTrait;

trait AbstractParams
{
    abstract public function getParam(string $key, string|array $filters = null, string $default = null, array $params = null): mixed;
    
    abstract protected function getParams(array $filters = null): array;
}
