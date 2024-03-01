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

use Phalcon\Mvc\ModelInterface;

trait AbstractGetSingle
{
    abstract public function getSingle(?int $id = null, ?string $modelName = null, ?array $with = null, ?array $find = null): ?ModelInterface;
}
