<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Mvc\Controller;

use Zemit\Mvc\Controller\Traits\Interfaces\BehaviorInterface;
use Zemit\Mvc\Controller\Traits\Interfaces\CacheInterface;
use Zemit\Mvc\Controller\Traits\Interfaces\DebugInterface;
use Zemit\Mvc\Controller\Traits\Interfaces\FractalInterface;
use Zemit\Mvc\Controller\Traits\Interfaces\ParamsInterface;
use Zemit\Mvc\Controller\Traits\Interfaces\RestResponseInterface;

interface RestInterface extends
    DebugInterface,
    CacheInterface,
    BehaviorInterface,
    ParamsInterface,
    FractalInterface,
    RestResponseInterface
{
}
