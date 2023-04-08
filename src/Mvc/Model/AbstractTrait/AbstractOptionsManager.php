<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Model\AbstractTrait;

use Zemit\Support\Options\ManagerInterface;

trait AbstractOptionsManager
{
    abstract public function getOptionsManager(): ?ManagerInterface;
}